<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller
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
        if (!ver_regra('clientes', 'c')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('clientes');
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('tipo', 'tipo', 'trim|required');
        $this->form_validation->set_rules('nome', 'nome', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('nascimento', 'nascimento', 'trim');
        $this->form_validation->set_rules('cnpj', 'cnpj', 'trim|max_length[18]|is_unique[clientes.cnpj]');
        $this->form_validation->set_rules('ie', 'ie', 'trim|max_length[17]');
        $this->form_validation->set_rules('cpf', 'cpf', 'trim|max_length[14]|is_unique[clientes.cpf]');
        $this->form_validation->set_rules('rg', 'rg', 'trim|max_length[12]');
        $this->form_validation->set_rules('telefone', 'telefone', 'trim|max_length[16]');
        $this->form_validation->set_rules('telefone2', 'telefone2', 'trim|max_length[16]');
        $this->form_validation->set_rules('email', 'email', 'trim|max_length[100]');
        $this->form_validation->set_rules('cep', 'cep', 'trim');
        $this->form_validation->set_rules('endereco', 'endereco', 'trim');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
        } else {
            $dados['id'] = 0;
            $dados['status'] = true;
            if (!$this->clientes_model->update($dados)) {
                $this->session->set_flashdata('erro', 'erro ao cadastrar cliente');
            } else {
                $this->session->set_flashdata('sucesso', 'cliente cadastrado com sucesso');
            }
        }
        redirect('clientes');
    }

    public function get($id)
    {
        if (!ver_regra('clientes', 'r')) {
            $this->output->set_status_header(401);
        } else {
            $cliente = $this->clientes_model->find($id)[0];
            $this->output->set_content_type('application/json')->set_output(json_encode($cliente));
        }
    }

    public function update()
    {
        if (!ver_regra('clientes', 'u')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('clientes');
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        $this->form_validation->set_rules('tipo', 'tipo', 'trim|required');
        $this->form_validation->set_rules('nome', 'nome', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('nascimento', 'nascimento', 'trim');
        $this->form_validation->set_rules('cnpj', 'cnpj', 'trim|max_length[18]|callback_cnpj_check');
        $this->form_validation->set_rules('ie', 'ie', 'trim|max_length[17]');
        $this->form_validation->set_rules('cpf', 'cpf', 'trim|max_length[14]|callback_cpf_check');
        $this->form_validation->set_rules('rg', 'rg', 'trim|max_length[12]');
        $this->form_validation->set_rules('telefone', 'telefone', 'trim|max_length[16]');
        $this->form_validation->set_rules('telefone2', 'telefone2', 'trim|max_length[16]');
        $this->form_validation->set_rules('email', 'email', 'trim|max_length[100]');
        $this->form_validation->set_rules('cep', 'cep', 'trim');
        $this->form_validation->set_rules('endereco', 'endereco', 'trim');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
        } else {
            $dados['status'] = true;
            if (!$this->clientes_model->update($dados)) {
                $this->session->set_flashdata('erro', 'erro ao atualizar cliente');
            } else {
                $this->session->set_flashdata('sucesso', 'cliente atualizado com sucesso');
            }
        }
        redirect('clientes');
    }

    public function stats()
    {
        if (!ver_regra('clientes', 'u')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('clientes');
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        $this->form_validation->set_rules('nome', 'nome', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('status', 'status', 'trim|required');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
        } else {
            if (!$this->clientes_model->update($dados)) {
                $this->session->set_flashdata('erro', 'erro ao atualizar cliente');
            } else {
                $this->session->set_flashdata('sucesso', 'cliente atualizado com sucesso');
            }
        }
        redirect('clientes');
    }

    public function delete()
    {
        if (!ver_regra('clientes', 'd')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('clientes');
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        $this->form_validation->set_rules('nome', 'nome', 'trim|required|max_length[50]');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
        } else {
            if (!$this->clientes_model->delete($dados['id'], $dados['nome'])) {
                $this->session->set_flashdata('erro', 'erro ao excluir cliente');
            } else {
                $this->session->set_flashdata('sucesso', 'cliente excluido com sucesso');
            }
        }
        redirect('clientes');
    }

    public function cnpj_check($cnpj)
    {
        $cliente = $this->clientes_model->getByCNPJ($cnpj);
        if ($cliente) {
            if ($cliente->cnpj != $cnpj) {
                $this->form_validation->set_message('cnpj_check', "CNPJ já cadastrado!");
                return FALSE;
            }
            return TRUE;
        } else {
            return TRUE;
        }
    }

    public function cpf_check($cpf)
    {
        $nome = $this->clientes_model->getByCPF($cpf);
        if ($nome) {
            if ($nome->cpf != $cpf) {
                $this->form_validation->set_message('cpf_check', "CPF já cadastrado!");
                return FALSE;
            }
            return TRUE;
        } else {
            return TRUE;
        }
    }

    public function relatorio()
    {
        $filtros = $this->input->post();
        if (!ver_regra('clientes', 'r') || !$filtros) {
            echo('Você não pode fazer esta acão');
        } else {
            $dados = $this->clientes_model->relatorio($filtros);

            $saida = [
                /*Load*/
                'customcss' => true,
                /*Dados*/
                'titulo' => 'Relatório de Clientes',
                'dados' => $dados,
            ];

            $this->load->vars($saida);
            $this->load->view('components/head');
            $this->load->view('clientes/relatorio');
        }
    }
}
