<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Atendimentos extends CI_Controller
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

    public function get($id)
    {
        if (!ver_regra('atendimentos', 'r')) {
            $this->output->set_status_header(401);
        } elseif (!$id) {
            $this->output->set_status_header(401);
        } else {
            $pedido = $this->pedidos_model->find($id)[0];
            $pedido->data_pedido = date('d/m/Y', strtotime($pedido->data_pedido));
            $pedido->data_entrega = date('d/m/Y', strtotime($pedido->data_entrega));
            $pedido->data_finalizado = ($pedido->data_finalizado) ? date('d/m/Y', strtotime($pedido->data_finalizado)) : null;
            $pedido->status = $this->status_model->find($pedido->status)[0]->nome;
            $pedido->cliente = $this->clientes_model->find($pedido->cliente)[0]->nome;
            $this->output->set_content_type('application/json')->set_output(json_encode($pedido));
        }
    }

    public function history($id)
    {
        if (!ver_regra('atendimentos', 'r')) {
            $this->output->set_status_header(401);
        } elseif (!$id) {
            $this->output->set_status_header(401);
        } else {
            $pedidos = $this->atendimentos_model->getByCliente($id);
            if ($pedidos) {
                foreach ($pedidos as $pedido) {
                    $pedido->data = date('d/m/Y', strtotime($pedido->data));
                    $pedido->usuario = $this->usuarios_model->find($pedido->usuario)[0]->nome;
                    $pedido->cliente = $this->clientes_model->find($pedido->cliente)[0]->nome;
                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($pedidos));
        }
    }

    public function create()
    {
        if (!ver_regra('atendimentos', 'c')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('atendimentos');
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('cliente', 'cliente', 'trim|required|numeric');
        $this->form_validation->set_rules('conteudo', 'conteudo', 'trim|required');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
            redirect('atendimentos/new');
        } else {
            $dados['id'] = 0;
            $dados['usuario'] = $this->session->userdata('auth')['id'];
            $dados['data'] = DatetimeNow();

            if (!$id = $this->atendimentos_model->update($dados)) {
                $this->session->set_flashdata('erro', 'erro ao cadastrar atendimento');
            } else {
                $this->session->set_flashdata('sucesso', 'atendimento cadastrado com sucesso');
            }

        }
        redirect('atendimentos');
    }

    public function relatorio()
    {
        $filtros = $this->input->post();
        if (!ver_regra('atendimentos', 'r') || !$filtros) {
            echo('Você não pode fazer esta acão');
        } else {
            $dados = $this->atendimentos_model->relatorio($filtros);
            if ($dados) {
                foreach ($dados as $dado) {
                    $dado->cliente = $this->clientes_model->find($dado->cliente)[0]->nome;
                    $dado->usuario = $this->usuarios_model->find($dado->usuario)[0]->nome;
                }
            }
            $saida = [
                /*Load*/
                'customcss' => true,
                /*Dados*/
                'titulo' => 'Relatório de Atendimento',
                'dados' => $dados,
            ];

            $this->load->vars($saida);
            $this->load->view('components/head');
            $this->load->view('atendimentos/relatorio');
        }
    }
}
