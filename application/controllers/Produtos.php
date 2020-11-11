<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos extends CI_Controller
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
        if (!ver_regra('produtos', 'c')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('produtos');
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('nome', 'nome', 'trim|required|max_length[150]');
        $this->form_validation->set_rules('quantidade', 'quantidade', 'trim');
        $this->form_validation->set_rules('comentario', 'comentario', 'trim');
        $this->form_validation->set_rules('altura', 'altura', 'trim');
        $this->form_validation->set_rules('largura', 'largura', 'trim');
        $this->form_validation->set_rules('comprimento', 'comprimento', 'trim');
        $this->form_validation->set_rules('tipo', 'tipo', 'trim|required');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
        } else {
            $dados['id'] = 0;
            if (!$this->produtos_model->update($dados)) {
                $this->session->set_flashdata('erro', 'erro ao cadastrar produto');
            } else {
                $this->session->set_flashdata('sucesso', 'produto cadastrado com sucesso');
            }
        }
        redirect('produtos');
    }

    public function get($id)
    {
        if (!ver_regra('produtos', 'r')) {
            $this->output->set_status_header(401);
        } else {
            $produtos = (!$id) ? $this->produtos_model->find() : $this->produtos_model->find($id)[0];
            $this->output->set_content_type('application/json')->set_output(json_encode($produtos));
        }
    }

    public function update()
    {
        if (!ver_regra('produtos', 'u')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('produtos');
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        $this->form_validation->set_rules('nome', 'nome', 'trim|required|max_length[150]');
        $this->form_validation->set_rules('quantidade', 'quantidade', 'trim');
        $this->form_validation->set_rules('comentario', 'comentario', 'trim');
        $this->form_validation->set_rules('altura', 'altura', 'trim');
        $this->form_validation->set_rules('largura', 'largura', 'trim');
        $this->form_validation->set_rules('comprimento', 'comprimento', 'trim');
        $this->form_validation->set_rules('tipo', 'tipo', 'trim|required');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
        } else {
            if (!$this->produtos_model->update($dados)) {
                $this->session->set_flashdata('erro', 'erro ao atualizar produto');
            } else {
                $this->session->set_flashdata('sucesso', 'produto atualizado com sucesso');
            }
        }
        redirect('produtos');
    }

    public function zero()
    {
        if (!ver_regra('produtos', 'u')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('produtos');
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        $this->form_validation->set_rules('nome', 'nome', 'trim|required|max_length[150]');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
        } else {
            $dados['quantidade'] = 0;
            if (!$this->produtos_model->update($dados)) {
                $this->session->set_flashdata('erro', 'erro ao zerar produto');
            } else {
                $this->session->set_flashdata('sucesso', 'produto zerado com sucesso');
            }
        }
        redirect('produtos');
    }

    public function pedido($id)
    {
        if (!ver_regra('pedidos', 'r')) {
            $this->output->set_status_header(401);
        } else {
            $producao = ($id) ? $this->producao_model->getByPedido($id) : null;
            if ($producao) {
                foreach ($producao as $item) {
                    $produto = $this->produtos_model->find($item->produto)[0];
                    $item->nome = $produto->nome;
                    $item->preco = $produto->preco;
                    $item->tipo = $produto->tipo;
                    $item->id = $produto->id;
                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($producao));
        }
    }

    public function getpedido($id)
    {
        if (!ver_regra('pedidos', 'r')) {
            $this->output->set_status_header(401);
        } else {
            $produtos = [];
            $producao = ($id) ? $this->producao_model->getByPedido($id) : null;
            if ($producao) {
                foreach ($producao as $item) {
                    $produtos[] = $this->produtos_model->find($item->produto)[0];
                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($produtos));
        }
    }

    public function relatorio()
    {
        $filtros = $this->input->post();
        if (!ver_regra('produtos', 'r') || !$filtros) {
            echo('Você não pode fazer esta acão');
        } else {
            $dados = $this->produtos_model->relatorio($filtros);

            $saida = [
                /*Load*/
                'customcss' => true,
                /*Dados*/
                'titulo' => 'Relatório De Produtos',
                'dados' => $dados,
            ];

            $this->load->vars($saida);
            $this->load->view('components/head');
            $this->load->view('produtos/relatorio');
        }
    }
}
