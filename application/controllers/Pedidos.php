<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends CI_Controller
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
        if (!ver_regra('pedidos', 'r')) {
            $this->output->set_status_header(401);
        } elseif (!$id) {
            $this->output->set_status_header(401);
        } else {
            if (!$pedidos = $this->pedidos_model->detalhe($id)){
                $this->output->set_status_header(401);
            } else {
                $saida = [];
                foreach ($pedidos as $k => $pedido) {
                    $saida['preco'] = $pedido->preco;
                    $saida['data_pedido'] = ($pedido->data_pedido) ? date('d/m/Y', strtotime($pedido->data_pedido)) : null;
                    $saida['data_entrega'] = ($pedido->data_entrega) ? date('d/m/Y', strtotime($pedido->data_entrega)) : null;
                    $saida['data_finalizado'] = ($pedido->data_finalizado) ? date('d/m/Y', strtotime($pedido->data_finalizado)) : null;
                    $saida['status'] = $this->status_model->find($pedido->status)[0]->nome;
                    $saida['cliente'] = $this->clientes_model->find($pedido->cliente)[0];
                    $saida['produtos'][$k]['nome'] = $pedido->nome;
                    $saida['produtos'][$k]['quantidade'] = $pedido->quantidade;
                    $saida['produtos'][$k]['altura'] = $pedido->altura;
                    $saida['produtos'][$k]['largura'] = $pedido->largura;
                    $saida['produtos'][$k]['comprimento'] = $pedido->comprimento;
                }
                $this->output->set_content_type('application/json')->set_output(json_encode($saida));
            }
        }
    }

    public function create()
    {
        if (!ver_regra('pedidos', 'c')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('pedidos');
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('data_pedido', 'data_pedido', 'trim|required');
        $this->form_validation->set_rules('data_entrega', 'data_entrega', 'trim|required');
        $this->form_validation->set_rules('cliente', 'cliente', 'trim|required');
        $this->form_validation->set_rules('preco', 'preco', 'trim|required');
        $this->form_validation->set_rules('obs', 'obs', 'trim');

        $this->form_validation->set_rules('id[]', 'id', 'trim|required');
        $this->form_validation->set_rules('altura[]', 'altura', 'trim');
        $this->form_validation->set_rules('largura[]', 'largura', 'trim');
        $this->form_validation->set_rules('comprimento[]', 'comprimento', 'trim');
        $this->form_validation->set_rules('quantidade[]', 'quantidade', 'trim');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
        } else {
            $producao['produto'] = $dados['id'];
            $producao['quantidade'] = isset($dados['quantidade']) ? $dados['quantidade'] : null;
            $producao['altura'] = isset($dados['altura']) ? $dados['altura'] : null;
            $producao['largura'] = isset($dados['largura']) ? $dados['largura'] : null;
            $producao['comprimento'] = isset($dados['comprimento']) ? $dados['comprimento'] : null;

            $dados['id'] = 0;
            unset($dados['quantidade']);
            unset($dados['altura']);
            unset($dados['largura']);
            unset($dados['comprimento']);

            if (!$id = $this->pedidos_model->update($dados)) {
                $this->session->set_flashdata('erro', 'erro ao cadastrar pedido');
            } else {
                foreach ($producao['produto'] as $k => $item) {
                    $prod = $this->produtos_model->find($item)[0];
                    if(isset($producao['quantidade'][$k])) $prod->quantidade -= $producao['quantidade'][$k];
                    if(isset($producao['altura'][$k])) $prod->altura -= $producao['altura'][$k];
                    if(isset($producao['largura'][$k])) $prod->largura -= $producao['largura'][$k];
                    if(isset($producao['comprimento'][$k])) $prod->comprimento -= $producao['comprimento'][$k];

                    $pd['pedido'] = $id;
                    $pd['produto'] = $item;
                    $pd['quantidade'] = isset($producao['quantidade'][$k]) ? $producao['quantidade'][$k] : null;
                    $pd['altura'] = isset($producao['altura'][$k]) ? $producao['altura'][$k] : null;
                    $pd['largura'] = isset($producao['largura'][$k]) ? $producao['largura'][$k] : null;
                    $pd['comprimento'] = isset($producao['comprimento'][$k]) ? $producao['comprimento'][$k] : null;
                    if (!$this->produtos_model->update((array)$prod)) {
                        $this->session->set_flashdata('erro', 'erro ao atualizar produto');
                    }
                    if (!$this->producao_model->update((array)$pd)) {
                        $this->session->set_flashdata('erro', 'erro ao atualizar produção');
                    }
                }
                $this->session->set_flashdata('sucesso', 'pedido cadastrado com sucesso');
            }

        }
        redirect('pedidos');
    }

    public function update()
    {
        if (!ver_regra('pedidos', 'u')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('pedidos');
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('preco', 'preco', 'trim|required');
        $this->form_validation->set_rules('obs', 'obs', 'trim');

        $this->form_validation->set_rules('id[]', 'id', 'trim|required');
        $this->form_validation->set_rules('altura[]', 'altura', 'trim');
        $this->form_validation->set_rules('largura[]', 'largura', 'trim');
        $this->form_validation->set_rules('comprimento[]', 'comprimento', 'trim');
        $this->form_validation->set_rules('quantidade[]', 'quantidade', 'trim');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
        } else {
            $pedido = $this->pedidos_model->find($dados['pedido'])[0];
            $oldproducao = $this->producao_model->getByPedido($dados['pedido']);

            $pedido->preco = $dados['preco'];
            $pedido->obs = $dados['obs'];
            $pedido->status = $dados['status'];

            if (!$this->pedidos_model->update((array)$pedido)) {
                $this->session->set_flashdata('erro', 'erro ao atualizar pedido');
            } else {
                foreach ($oldproducao as $item) {
                    $prod = $this->produtos_model->find($item->produto)[0];
                    if(isset($item->quantidade)) $prod->quantidade += $item->quantidade;
                    if(isset($item->altura)) $prod->altura += $item->altura;
                    if(isset($item->largura)) $prod->largura += $item->largura;
                    if(isset($item->comprimento)) $prod->comprimento += $item->comprimento;
                    if (!$this->produtos_model->update((array)$prod)) {
                        $this->session->set_flashdata('erro', 'erro ao atualizar produto');
                    }
                }
                $this->producao_model->delByPedido($dados['pedido']);
                foreach ($dados['id'] as $k => $item) {
                    $prod = $this->produtos_model->find($item)[0];
                    if(isset($dados['quantidade'][$k])) $prod->quantidade -= $dados['quantidade'][$k];
                    if(isset($dados['altura'][$k])) $prod->altura -= $dados['altura'][$k];
                    if(isset($dados['largura'][$k])) $prod->largura -= $dados['largura'][$k];
                    if(isset($dados['comprimento'][$k])) $prod->comprimento -= $dados['comprimento'][$k];
                    if (!$this->produtos_model->update((array)$prod)) {
                        $this->session->set_flashdata('erro', 'erro ao atualizar produto');
                    }

                    $pd['pedido'] = $dados['pedido'];
                    $pd['produto'] = $item;
                    if(isset($dados['quantidade'][$k])) $pd['quantidade'] = $dados['quantidade'][$k];
                    if(isset($dados['altura'][$k])) $pd['altura'] =  $dados['altura'][$k];
                    if(isset($dados['largura'][$k])) $pd['largura'] =  $dados['largura'][$k];
                    if(isset($dados['comprimento'][$k])) $pd['comprimento'] =  $dados['comprimento'][$k];
                    if (!$this->producao_model->update((array)$pd)) {
                        $this->session->set_flashdata('erro', 'erro ao atualizar produção');
                    }
                }
                $this->session->set_flashdata('sucesso', 'pedido atualizado com sucesso');
                redirect('pedidos');
            }
        }
        redirect('pedidos/edit/' . $dados['pedido']);
    }

    public function iniciar()
    {
        if (!ver_regra('pedidos', 'u')) {
            $this->output->set_status_header(401);
            $this->output->set_content_type('application/json')->set_output(json_encode('voce não pode fazer essa ação'));
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        if (!$this->form_validation->run($dados)) {
            $this->output->set_status_header(401);
            $this->output->set_content_type('application/json')->set_output(json_encode(validation_errors('<p>', '</p>')));
        } else {
            $dados['status'] = 2;
            if (!$st = $this->pedidos_model->update($dados)) {
                $this->output->set_status_header(401);
                $this->output->set_content_type('application/json')->set_output(json_encode('erro ao iniciar produção'));
            } else {
                $this->output->set_status_header(200);
            }
        }
    }

    public function parar()
    {
        if (!ver_regra('pedidos', 'u')) {
            $this->output->set_status_header(401);
            $this->output->set_content_type('application/json')->set_output(json_encode('voce não pode fazer essa ação'));
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        if (!$this->form_validation->run($dados)) {
            $this->output->set_status_header(401);
            $this->output->set_content_type('application/json')->set_output(json_encode(validation_errors('<p>', '</p>')));
        } else {
            $dados['status'] = 3;
            if (!$st = $this->pedidos_model->update($dados)) {
                $this->output->set_status_header(401);
                $this->output->set_content_type('application/json')->set_output(json_encode('erro ao iniciar produção'));
            } else {
                $this->output->set_status_header(200);
            }
        }
    }

    public function cancelar()
    {
        if (!ver_regra('pedidos', 'u')) {
            $this->output->set_status_header(401);
            $this->output->set_content_type('application/json')->set_output(json_encode('voce não pode fazer essa ação'));
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        if (!$this->form_validation->run($dados)) {
            $this->output->set_status_header(401);
            $this->output->set_content_type('application/json')->set_output(json_encode(validation_errors('<p>', '</p>')));
        } else {
            $dados['status'] = 5;
            $dados['data_finalizado'] = DatetimeNow();
            if (!$this->pedidos_model->update($dados)) {
                $this->output->set_status_header(401);
                $this->output->set_content_type('application/json')->set_output(json_encode('erro ao cancelar produção'));
            } else {
                $producao = $this->producao_model->getByPedido($dados['id']);
                $rest = true;
                foreach ($producao as $item) {
                    $prod = $this->produtos_model->find($item->produto)[0];
                    if(isset($item->quantidade)) $prod->quantidade += $item->quantidade;
                    if(isset($item->altura)) $prod->altura += $item->altura;
                    if(isset($item->largura)) $prod->largura += $item->largura;
                    if(isset($item->comprimento)) $prod->comprimento += $item->comprimento;
                    if (!$this->produtos_model->update((array)$prod)) {
                        $this->output->set_status_header(401);
                        $this->output->set_content_type('application/json')->set_output(json_encode('erro ao atualizar produto'));
                        $rest = false;
                    }
                }
                ($rest) ? $this->output->set_status_header(200) : null;
            }
        }
    }

    public function finalizar()
    {
        if (!ver_regra('pedidos', 'u')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('pedidos');
        }
        $dados = $this->input->post();
        $this->form_validation->set_rules('id', 'id', 'trim|required');
        $this->form_validation->set_rules('produto[]', 'item', 'trim|required');
        if (!$this->form_validation->run($dados)) {
            $this->session->set_flashdata('erro', validation_errors('<p>', '</p>'));
        } else {
            $pedido = $this->pedidos_model->find($dados['id'])[0];
            $pedido->status = 4;
            $pedido->data_finalizado = DatetimeNow();
            $pedido->obs .= $dados['obs'];
            if (!$this->pedidos_model->update((array)$pedido)) {
                $this->session->set_flashdata('erro', 'erro ao finalizar produção');
                redirect('pedidos/finalizar/' . $pedido['id']);
            } else {
                foreach ($dados['produto'] as $k => $item) {
                    $prod = $this->produtos_model->find($item)[0];
                    if(isset($dados['quantidade'][$k])) $prod->quantidade += $dados['quantidade'][$k];
                    if(isset($dados['altura'][$k])) $prod->altura += $dados['altura'][$k];
                    if(isset($dados['largura'][$k])) $prod->largura += $dados['largura'][$k];
                    if(isset($dados['comprimento'][$k])) $prod->comprimento += $dados['comprimento'][$k];
                    if (!$this->produtos_model->update((array)$prod)) {
                        $this->session->set_flashdata('erro', 'erro ao registrar sobras');
                        redirect('pedidos/finalizar/' . $pedido['id']);
                    }
                }
                $this->session->set_flashdata('sucesso', 'pedido finalizado com sucesso');
            }
        }
        redirect('pedidos');
    }

    public function relatorio()
    {
        $filtros = $this->input->post();
        if (!ver_regra('pedidos', 'r') || !$filtros) {
            echo('Você não pode fazer esta acão');
        } else {
            $dados = $this->pedidos_model->relatorio($filtros);
            $preco = 0;
            if ($dados) {
                foreach ($dados as $dado) {
                    $dado->cliente = $this->clientes_model->find($dado->cliente)[0]->nome;
                    $dado->status = $this->status_model->find($dado->status)[0]->nome;
                    $preco += $dado->preco;
                    if (isset($filtros['produtos'])) {
                        $producao = $this->producao_model->getByPedido($dado->id);
                        if ($producao) {
                            $produtos = [];
                            foreach ($producao as $k => $item) {
                                $produtos[$k]['produto'] = $this->produtos_model->find($item->produto)[0]->nome;
                                $produtos[$k]['altura'] = $item->altura;
                                $produtos[$k]['largura'] = $item->largura;
                                $produtos[$k]['comprimento'] = $item->comprimento;
                                $produtos[$k]['quantidade'] = $item->quantidade;
                            }
                        }
                        $dado->produtos = $produtos;
                    }
                }
            }
            $saida = [
                /*Load*/
                'customcss' => true,
                /*Dados*/
                'titulo' => 'Relatório de Pedidos',
                'dados' => $dados,
                'preco' => $preco,
            ];

            $this->load->vars($saida);
            $this->load->view('components/head');
            $this->load->view('pedidos/relatorio');
        }
    }
}
