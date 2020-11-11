<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller
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
        if (!ver_regra('usuarios', 'c')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('usuarios');
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('nome', 'nome', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('email', 'email', 'trim|required|max_length[50]|is_unique[usuarios.email]');
        $this->form_validation->set_rules('usuario', 'usuario', 'trim|required|max_length[50]|is_unique[usuarios.usuario]');
        $this->form_validation->set_rules('senha', 'senha', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('grupo', 'grupo', 'trim|required');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
        } else {
            $dados['id'] = 0;
            $dados['status'] = true;
            $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
            if (!$this->usuarios_model->update($dados)) {
                $this->session->set_flashdata('erro', 'erro ao cadastrar usuário');
            } else {
                $this->session->set_flashdata('sucesso', 'usuário cadastrado com sucesso');
            }
        }
        redirect('usuarios');
    }

    public function get($id)
    {
        if (!ver_regra('usuarios', 'r')) {
            $this->output->set_status_header(401);
        } else {
            $usuario = $this->usuarios_model->find($id)[0];
            unset($usuario->senha);
            $this->output->set_content_type('application/json')->set_output(json_encode($usuario));
        }
    }

    public function update()
    {
        if (!ver_regra('usuarios', 'u')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('usuarios');
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('nome', 'nome', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('email', 'email', 'trim|required|max_length[50]|callback_email_check');
        $this->form_validation->set_rules('usuario', 'usuario', 'trim|required|max_length[50]|callback_user_check');
        $this->form_validation->set_rules('senha', 'senha', 'trim|max_length[100]');
        $this->form_validation->set_rules('grupo', 'grupo', 'trim|required');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
        } else {
            $dados['status'] = true;
            if($dados['senha']){
                $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
            } else {
                unset($dados['senha']);
            }
            if (!$this->usuarios_model->update($dados)) {
                $this->session->set_flashdata('erro', 'erro ao atualizar usuário');
            } else {
                $this->session->set_flashdata('sucesso', 'usuário atualizado com sucesso');
            }
        }
        redirect('usuarios');
    }

    public function stats()
    {
        if (!ver_regra('usuarios', 'u')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('usuarios');
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        $this->form_validation->set_rules('nome', 'nome', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('status', 'status', 'trim|required');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
        } else {
            if (!$this->usuarios_model->update($dados)) {
                $this->session->set_flashdata('erro', 'erro ao atualizar usuário');
            } else {
                $this->session->set_flashdata('sucesso', 'usuário atualizado com sucesso');
            }
        }
        redirect('usuarios');
    }

    public function delete()
    {
        if (!ver_regra('usuarios', 'd')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('usuarios');
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        $this->form_validation->set_rules('nome', 'nome', 'trim|required|max_length[50]');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
        } else {
            if (!$this->usuarios_model->delete($dados['id'], $dados['nome'])) {
                $this->session->set_flashdata('erro', 'erro ao excluir usuário');
            } else {
                $this->session->set_flashdata('sucesso', 'usuário excluido com sucesso');
            }
        }
        redirect('usuarios');
    }

    public function perfil()
    {
        $dados = $this->input->post();
        $this->form_validation->set_rules('nome', 'nome', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('email', 'email', 'trim|required|max_length[50]|callback_email_check');
        $this->form_validation->set_rules('usuario', 'usuario', 'trim|required|max_length[50]|callback_user_check');
        $this->form_validation->set_rules('senha', 'senha', 'trim|max_length[100]');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
        } else {
            $dados['status'] = true;
            $dados['id'] = $this->session->userdata('auth')['id'];
            if($dados['senha']){
                $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
            } else {
                unset($dados['senha']);
            }
            if (!$this->usuarios_model->update($dados)) {
                $this->session->set_flashdata('erro', 'erro ao atualizar perfil');
            } else {
                $auth = $this->session->userdata('auth');
                $auth['nome'] = $dados['nome'];
                $auth['usuario'] = $dados['usuario'];
                $this->session->set_userdata('auth', $auth);
                $this->session->set_flashdata('sucesso', 'perfil atualizado com sucesso');
            }
        }
        redirect('dashboard');
    }

    public function user_check($user)
    {
        $nome = $this->usuarios_model->getByUser($user);
        if ($nome) {
            if ($nome->usuario != $user) {
                $this->form_validation->set_message('user_check', "Usuário já existe!");
                return FALSE;
            }
            return TRUE;
        } else {
            return TRUE;
        }
    }

    public function email_check($email)
    {
        $nome = $this->usuarios_model->getByEmail($email);
        if ($nome) {
            if ($nome->email != $email) {
                $this->form_validation->set_message('email_check', "Email já existe!");
                return FALSE;
            }
            return TRUE;
        } else {
            return TRUE;
        }
    }
}
