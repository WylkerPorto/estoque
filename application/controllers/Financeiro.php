<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Financeiro extends CI_Controller
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
        if (!ver_regra('financeiro', 'r')) {
            $this->output->set_status_header(401);
        } elseif (!$id) {
            $this->output->set_status_header(401);
        } else {
            $titulo = $this->titulos_model->find($id, $this->input->get('parcela'))[0];
            if ($titulo) {
                $titulo->data_pagamento = date('d/m/Y', strtotime($titulo->data_pagamento));
                $titulo->vencimento = date('d/m/Y', strtotime($titulo->vencimento));
                $titulo->cliente = ($titulo->cliente) ? $this->clientes_model->find($titulo->cliente)[0]->nome : null;
                $titulo->usuario = ($titulo->usuario) ? $this->usuarios_model->find($titulo->usuario)[0]->nome : null;
                $titulo->motivo = ($titulo->motivo) ? $this->motivos_model->find($titulo->motivo)[0]->nome : null;
                $titulo->tipo = ($titulo->tipo) ? $this->tipos_model->find($titulo->tipo)[0]->nome : null;
                $this->output->set_content_type('application/json')->set_output(json_encode($titulo));
            } else
                $this->output->set_status_header(401);
        }
    }

    public function fecha($id)
    {
        if (!ver_regra('financeiro', 'u')) {
            $this->output->set_status_header(401);
        } elseif (!$id) {
            $this->output->set_status_header(401);
        } else {
            $att = $this->input->post();
            $titulo = $this->titulos_model->getFatura($id)[0];

            if (!$titulo) {
                $this->session->set_flashdata('erro', 'título já faturado');
                redirect('titulos');
            } else {
                foreach ($att as $k => $item) {
                    $titulo->$k = $item;
                }

                $titulo->data_pagamento = DatetimeNow();
                $titulo->status = 1;

                if (!$this->titulos_model->update((array)$titulo)) {
                    $this->session->set_flashdata('erro', 'erro ao faturar título');
                    redirect('titulos/fatura/' . $id);
                }
            }

            $this->session->set_flashdata('sucesso', 'titulo faturado com sucesso');
            redirect('titulos');
        }
    }

    public function create()
    {
        if (!ver_regra('financeiro', 'c')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('financeiro');
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('valor_total', 'total', 'trim|required|numeric');
        $this->form_validation->set_rules('total_parcelas', 'parcela', 'trim|required|numeric');
        $this->form_validation->set_rules('vencimento', 'vencimento', 'trim|required');
        $this->form_validation->set_rules('valor_parcelas[]', 'val parcela', 'trim|required|numeric');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
            redirect('financeiro/new');
        } else {
            foreach ($dados as $k => $dado) {
                if ($dado[0] == '?') {
                    unset($dados[$k]);
                }
            }
            $dados['status'] = 0;
            $dados['usuario'] = $this->session->userdata('auth')['id'];
            $dados['id'] = 0;

            $outros['parcelas'] = $dados['valor_parcelas'];
            $outros['vencimentos'] = $dados['vencimentos'];
            unset($dados['valor_parcelas']);
            unset($dados['vencimentos']);

            foreach ($outros['parcelas'] as $k => $parcela) {
                $dados['parcela'] = $k + 1;
                $dados['valor_parcela'] = $parcela;
                $dados['vencimento'] = $outros['vencimentos'][$k];
                if (!$dados['id'] = $this->titulos_model->update($dados)) {
                    $this->session->set_flashdata('erro', 'Erro ao inserir titulo');
                    redirect('financeiro/new');
                }
            }
        }

        $this->session->set_flashdata('sucesso', 'titulo criado com sucesso');
        redirect('financeiro');
    }

    public function receitas()
    {
        if (!ver_regra('financeiro', 'r')) {
            $this->output->set_status_header(401);
        } elseif (!$data = $this->input->post()) {
            $this->output->set_status_header(401);
        } else {
            if ($data->is_date_search == 'yes') {
            }
            if (isset($data->search->value)) {
            }
            $geral = $this->titulos_model->find();
            if ($geral) {
                foreach ($geral as $item) {
                    $item->cliente = $this->clientes_model->find($item->cliente)[0]->nome;
                    $item->motivo = $this->motivos_model->find($item->motivo)[0]->nome;
                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($geral));
        }
    }

    public function relatorio()
    {
        $filtros = $this->input->post();
        if (!ver_regra('financeiro', 'r') || !$filtros) {
            echo('Você não pode fazer esta acão');
        } else {
            $dados = $this->titulos_model->relatorio($filtros);
            $valores = ['parcela' => 0, 'total' => 0, 'pago' => 0, 'juros' => 0, 'desconto' => 0, 'multa' => 0,];
            if ($dados) {
                foreach ($dados as $dado) {
                    if ($dado->tipo == 1) {
//                        Entrada
                        $valores['parcela'] += $dado->valor_parcela;
                        $valores['total'] += $dado->valor_total;
                        $valores['pago'] += $dado->pagamento;
                        $valores['juros'] += $dado->juros;
                        $valores['desconto'] += $dado->desconto;
                        $valores['multa'] += $dado->multa;
                    } else {
//                        Saída
                        $valores['parcela'] -= $dado->valor_parcela;
                        $valores['total'] -= $dado->valor_total;
                        $valores['pago'] -= $dado->pagamento;
                        $valores['juros'] -= $dado->juros;
                        $valores['desconto'] -= $dado->desconto;
                        $valores['multa'] -= $dado->multa;
                        $dado->valor_parcela = -$dado->valor_parcela;
                        $dado->valor_total = -$dado->valor_total;
                        $dado->pagamento = -$dado->pagamento;
                        $dado->juros = -$dado->juros;
                        $dado->desconto = -$dado->desconto;
                        $dado->multa = -$dado->multa;
                    }
                    $dado->cliente = $this->clientes_model->find($dado->cliente)[0]->nome;
                    $dado->usuario = $this->usuarios_model->find($dado->usuario)[0]->nome;
                    $dado->motivo = $this->motivos_model->find($dado->motivo)[0]->nome;
                    $dado->tipo = $this->tipos_model->find($dado->tipo)[0]->nome;
                }
            }
            $saida = [
                /*Load*/
                'customcss' => true,
                /*Dados*/
                'titulo' => 'Relatório Financeiro',
                'dados' => $dados,
                'valores' => $valores,
            ];

            $this->load->vars($saida);
            $this->load->view('components/head');
            $this->load->view('contas/relatorio');
        }
    }
}
