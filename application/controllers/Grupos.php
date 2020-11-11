<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Grupos extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$auth = $this->session->userdata('auth')) {
            redirect();
        } else {
            if (!$acoes = $this->acoes_model->getByGrupo($auth['grupo'])) {
                redirect('dashboard');
            }
        }
    }

    public function create()
    {
        if (!ver_regra('controles', 'c')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('grupos');
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('nome', 'nome', 'trim|required|max_length[50]|is_unique[grupos.nome]');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
        } else {
            $grupo = [
                'id' => 0,
                'nome' => $dados['nome'],
                'desc' => $dados['desc'],
            ];
            if (!$grupo = $this->grupos_model->update($grupo)) {
                $this->session->set_flashdata('erro', 'erro ao cadastrar grupo');
            } else {
                unset($dados['nome']);
                unset($dados['desc']);
                foreach ($dados as $acesso => $regra) {
                    true;
                    $acoes = [
                        'grupo' => $grupo,
                        'regra' => $regra,
                        'acesso' => $acesso,
                    ];
                    if (!$this->acoes_model->update($acoes)) {
                        $this->session->set_flashdata('erro', 'erro ao salvar regra');
                        redirect('grupos');
                    } else {
                        $this->session->set_flashdata('sucesso', 'grupo criado com sucesso');
                    }
                }
            }
        }
        redirect('grupos');
    }

    public function get($id)
    {
        if (!ver_regra('controles', 'r')) {
            $this->output->set_status_header(401);
        } else {
            $grupo = $this->grupos_model->find($id);
            $grupo['acoes'] = $this->acoes_model->getByGrupo($id);
            $grupo['regras'] = $this->acessos_model->find();
            if ($grupo['regras']) {
                foreach ($grupo['regras'] as $regra) {
                    $regra->nome = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($regra->nome)));
                }
            }
            if ($grupo['acoes']) {
                foreach ($grupo['acoes'] as $acoe) {
                    $acoe->acesso = $this->acessos_model->getName($acoe->acesso);
                    $acoe->acesso = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($acoe->acesso)));
                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($grupo));
        }
    }

    public function update()
    {
        if (!ver_regra('controles', 'u')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('grupos');
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('nome', 'nome', 'trim|required|max_length[50]|callback_name_check');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('msg', validation_errors('<p>', '</p>'));
        } else {
            if ($dados['id'] < 3) {
                $this->session->set_flashdata('erro', 'grupo padrão não pode ser editado');
                redirect('grupos');
            }
            $grupo = [
                'id' => $dados['id'],
                'nome' => $dados['nome'],
                'desc' => $dados['desc'],
            ];
            if (!$this->grupos_model->update($grupo)) {
                $this->session->set_flashdata('erro', 'erro ao salvar grupo');
            } else {
                unset($dados['id']);
                unset($dados['nome']);
                unset($dados['desc']);
                foreach ($dados as $acesso => $regra) {
                    $acoes = [
                        'grupo' => $grupo['id'],
                        'regra' => $regra,
                        'acesso' => $acesso,
                    ];
                    if (!$ext = $this->acoes_model->update($acoes)) {
                        $this->session->set_flashdata('erro', 'erro ao salvar regra');
                        redirect('grupos');
                    } else {
                        $this->session->set_flashdata('sucesso', 'grupo salvo com sucesso');
                    }
                }
            }
        }
        redirect('grupos');
    }

    public function delete()
    {
        if (!ver_regra('controles', 'd')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('grupos');
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('nome', 'nome', 'trim|required|max_length[50]');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
        } else {
            if ($dados['id'] < 3) {
                $this->session->set_flashdata('erro', 'grupo padrão não pode ser excluído');
                redirect('grupos');
            }
            if (!$this->grupos_model->delete($dados['id'], $dados['nome'])) {
                $this->session->set_flashdata('erro', 'erro ao excluir grupo');
            } else {
                $this->session->set_flashdata('sucesso', 'grupo excluido com sucesso');
            }
        }
        redirect('grupos');
    }

    public function name_check($name)
    {
        $nome = $this->grupos_model->getByName($name);
        if ($nome) {
            if ($nome->nome != $name) {
                $this->form_validation->set_message('name_check', "Nome já existente");
                return FALSE;
            }
            return TRUE;
        } else {
            return TRUE;
        }
    }
}
