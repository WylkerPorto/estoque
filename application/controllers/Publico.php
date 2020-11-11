<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Publico extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $dados = [
            /*Load*/
            'waves' => true, 'anima' => true, 'customcss' => true, 'validation' => true, 'customjs' => true, 'sign_in' => true, 'mycss' => true,
            /*Dados*/
            'titulo' => 'Sistema de vidraçaria',

        ];
        $this->load->vars($dados);
        $this->load->view('components/login_head');
        $this->load->view('login');
        $this->load->view('components/login_footer');
    }

    public function login()
    {
        $data = $this->input->post();
        $this->form_validation->set_rules('usuario', 'usuario', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('senha', 'senha', 'trim|required|max_length[100]');
        if (!$this->form_validation->run($data)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
            redirect(base_url());
        } else {
            if (!$user = $this->usuarios_model->getByUser($data['usuario'])) {
                $this->session->set_flashdata('usuario', 'Usuário não encontrado');
                redirect(base_url());
            }
            if (!password_verify($data['senha'], $user->senha)) {
                $this->session->set_flashdata('senha', 'Senha invalida');
                redirect(base_url());
            } else {
                $validate = [
                    'id' => $user->id,
                    'nome' => $user->nome,
                    'grupo' => $user->grupo,
                    'usuario' => $user->usuario,
                ];
                $this->session->set_userdata('auth', $validate);
                redirect('dashboard');
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function recupera()
    {
        $dados = [
            /*Load*/
            'waves' => true, 'anima' => true, 'customcss' => true, 'validation' => true, 'customjs' => true, 'sign_in' => true,
            /*Dados*/
            'titulo' => 'Sistema de vidraçaria',

        ];
        $this->load->vars($dados);
        $this->load->view('components/login_head');
        $this->load->view('login');
        $this->load->view('components/login_footer');
    }

    public function reseta()
    {
        $dados = [
            /*Load*/
            'waves' => true, 'anima' => true, 'customcss' => true, 'validation' => true, 'customjs' => true, 'sign_in' => true,
            /*Dados*/
            'titulo' => 'Sistema de vidraçaria',

        ];
        $this->load->vars($dados);
        $this->load->view('components/login_head');
        $this->load->view('login');
        $this->load->view('components/login_footer');
    }
}
