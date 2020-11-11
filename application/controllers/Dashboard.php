<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$auth = $this->session->userdata('auth')) {
            redirect();
        } else {
            if (!$acoes = $this->acoes_model->getByGrupo($auth['grupo'])) {
                $this->acessos = null;
            }
        }

        $orcamentos = $this->pedidos_model->findOrcamento();
        if ($orcamentos) {
            foreach ($orcamentos as $orcamento) {
                if ($orcamento->data_pedido < date('Y-m-d', strtotime("-14 day"))) {
                    $orcamento->status = 6;
                    $this->pedidos_model->update((array)$orcamento);
                }
            }
        }
    }

    public function index()
    {
        $clientes = ($this->clientes_model->getClient()) ? count((array)$this->clientes_model->getClient()) : 0;
        $produtos = ($this->produtos_model->find()) ? count((array)$this->produtos_model->find()) : 0;
        $tres = ($this->pedidos_model->findOrcamento(date('Y-m-d', strtotime("-3 day")))) ? count((array)$this->pedidos_model->findOrcamento(date('Y-m-d', strtotime("-3 day")))) : 0;
        $sete = ($this->pedidos_model->findOrcamento(date('Y-m-d', strtotime("-7 day")))) ? count((array)$this->pedidos_model->findOrcamento(date('Y-m-d', strtotime("-7 day")))) : 0;
        $expirado = ($this->pedidos_model->findByStatus(6)) ? count((array)$this->pedidos_model->findByStatus(6)) : 0;
        $pedidos = ($this->pedidos_model->findPedido()) ? count((array)$this->pedidos_model->findPedido()) : 0;
        $graficos = $this->atendimentos_model->findByData(date('Y-m-d', strtotime("-30 day")));
        $grafico = [];
        if ($graficos) {
            foreach ($graficos as $k => $item) {
                $grafico['dta'][$k] = $item->data;
                $grafico['qtd'][$k] = $item->qtd;
            }
        }
        $valores = ['clientes' => $clientes, 'produtos' => $produtos, 'tres' => $tres, 'sete' => $sete, 'expirado' => $expirado, 'pedidos' => $pedidos, 'grafico' => $grafico];
        $dados = [
            /* Loads */
            'waves' => true, 'anima' => true, 'customcss' => true, 'customjs' => true, 'alltheme' => true, 'count' => true, 'angular' => true, 'mycss' => true, 'myjs' => true,
            'chart' => true,
            /* Gera menu lateral */
            'left_menu' => left_menu(),
            /* Dados */
            'titulo' => 'dashboard',
            'valores' => $valores,
        ];
        $this->load->vars($dados);
        $this->load->view('components/head');
        $this->load->view('components/navbar');
        $this->load->view('components/left_menu');
        $this->load->view('dashboard');
        $this->load->view('components/footer');
    }

    /* Lista de usuario */
    public function usuario()
    {
        if (!ver_regra('usuarios', 'r')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('dashboard');
        }
        $users = $this->usuarios_model->find();
        $grupos = $this->grupos_model->find();

        $dados = [
            /*Load*/
            'waves' => true, 'anima' => true, 'customcss' => true, 'customjs' => true, 'alltheme' => true, 'angular' => true, 'myjs' => true,
            /* Gera menu lateral */
            'left_menu' => left_menu(),
            /*Dados*/
            'titulo' => 'Usuários',
            'usuarios' => $users,
            'grupos' => $grupos,
        ];
        $this->load->vars($dados);
        $this->load->view('components/head');
        $this->load->view('components/navbar');
        $this->load->view('components/left_menu');
        $this->load->view('usuarios/index');
        $this->load->view('components/footer');
    }

    /* Lista de grupos */
    public function controle()
    {
        if (!ver_regra('controles', 'r')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('dashboard');
        }
        $grupos = $this->grupos_model->find();
        $acessos = $this->acessos_model->find();
        $regras = $this->regras_model->find();

        $dados = [
            /*Load*/
            'waves' => true, 'anima' => true, 'customcss' => true, 'customjs' => true, 'alltheme' => true, 'angular' => true, 'myjs' => true, 'autosize' => true,
            /* Gera menu lateral */
            'left_menu' => left_menu(),
            /*Dados*/
            'titulo' => 'Permissões',
            'grupos' => $grupos,
            'acessos' => $acessos,
            'regras' => $regras,
        ];
        $this->load->vars($dados);
        $this->load->view('components/head');
        $this->load->view('components/navbar');
        $this->load->view('components/left_menu');
        $this->load->view('controle/index');
        $this->load->view('components/footer');
    }

    /* Lista de clientes */
    public function cliente()
    {
        if (!ver_regra('clientes', 'r')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('dashboard');
        }
        $dados = [
            /*Load*/
            'waves' => true, 'anima' => true, 'customcss' => true, 'customjs' => true, 'alltheme' => true, 'datatable' => true, 'angular' => true, 'myjs' => true, 'mycss' => true,
            'mask' => true, 'select2' => true,
            /* Gera menu lateral */
            'left_menu' => left_menu(),
            /*Dados*/
            'titulo' => 'Clientes',
            'clientes' => $this->clientes_model->find(),
        ];
        $this->load->vars($dados);
        $this->load->view('components/head');
        $this->load->view('components/navbar');
        $this->load->view('components/left_menu');
        $this->load->view('clientes/index');
        $this->load->view('components/footer');
    }

    /* Lista de produção */
    public function pedidos()
    {
        if (!ver_regra('pedidos', 'r')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('dashboard');
        }

        $pedidos = $this->pedidos_model->findPedido();
        if ($pedidos) {
            foreach ($pedidos as $pedido) {
                $pedido->cliente = $this->clientes_model->find($pedido->cliente)[0]->nome;
                $pedido->status_nome = $this->status_model->find($pedido->status)[0]->nome;
            }
        }

        $orcamentos = $this->pedidos_model->findOrcamento();
        if ($orcamentos) {
            foreach ($orcamentos as $orcamento) {
                $orcamento->cliente = $this->clientes_model->find($orcamento->cliente)[0]->nome;
                $orcamento->status_nome = $this->status_model->find($orcamento->status)[0]->nome;
            }
        }

        $dados = [
            /*Load*/
            'waves' => true, 'anima' => true, 'customcss' => true, 'customjs' => true, 'alltheme' => true, 'datatable' => true, 'angular' => true, 'select2' => true, 'myjs' => true,
            'ckeditor' => true, 'mycss' => true,
            /* Gera menu lateral */
            'left_menu' => left_menu(),
            /*Dados*/
            'titulo' => 'Pedidos',
            'pedidos' => $pedidos,
            'orcamentos' => $orcamentos,
            'clientes' => $this->clientes_model->find(),
            'status' => $this->status_model->find(),
        ];
        $this->load->vars($dados);
        $this->load->view('components/head');
        $this->load->view('components/navbar');
        $this->load->view('components/left_menu');
        $this->load->view('pedidos/index');
        $this->load->view('components/footer');
    }

    public function pinit()
    {
        if (!ver_regra('pedidos', 'c')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('pedidos');
        }
        $dados = [
            /*Load*/
            'waves' => true, 'anima' => true, 'customcss' => true, 'customjs' => true, 'alltheme' => true, 'datatable' => true, 'angular' => true, 'myjs' => true, 'select2' => true,
            'autosize' => true, 'mycss' => true,
            /* Gera menu lateral */
            'left_menu' => left_menu(),
            /*Dados*/
            'titulo' => 'Entrada de pedido',
            'status' => $this->status_model->find(),
            'clientes' => $this->clientes_model->getClient(),
        ];
        $this->load->vars($dados);
        $this->load->view('components/head');
        $this->load->view('components/navbar');
        $this->load->view('components/left_menu');
        $this->load->view('pedidos/init');
        $this->load->view('components/footer');
    }

    public function pedit($id)
    {
        if (!ver_regra('pedidos', 'c') || !ver_regra('pedidos', 'u')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('pedidos');
        }
        $pedido = $this->pedidos_model->find($id)[0];

        $dados = [
            /*Load*/
            'waves' => true, 'anima' => true, 'customcss' => true, 'customjs' => true, 'alltheme' => true, 'datatable' => true, 'angular' => true, 'myjs' => true, 'select2' => true,
            'autosize' => true, 'mycss' => true,
            /* Gera menu lateral */
            'left_menu' => left_menu(),
            /*Dados*/
            'titulo' => 'Edição de Pedidos',
            'status' => $this->status_model->find(),
            'clientes' => $this->clientes_model->getClient(),
            'pedido' => $pedido,
        ];
        $this->load->vars($dados);
        $this->load->view('components/head');
        $this->load->view('components/navbar');
        $this->load->view('components/left_menu');
        $this->load->view('pedidos/edit');
        $this->load->view('components/footer');
    }

    public function pfim($id)
    {
        if (!ver_regra('pedidos', 'c') || !ver_regra('pedidos', 'u')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('pedidos');
        }
        $pedido = $this->pedidos_model->find($id)[0];
        $producao = $this->producao_model->getByPedido($id);
        foreach ($producao as $item) {
            $item->produto = $this->produtos_model->find($item->produto)[0];
        }

        $dados = [
            /*Load*/
            'waves' => true, 'anima' => true, 'customcss' => true, 'customjs' => true, 'alltheme' => true, 'angular' => true, 'myjs' => true, 'autosize' => true, 'mycss' => true,
            /* Gera menu lateral */
            'left_menu' => left_menu(),
            /*Dados*/
            'titulo' => 'Finalização de pedido',
            'status' => $this->status_model->find(),
            'clientes' => $this->clientes_model->getClient(),
            'pedido' => $pedido,
            'producao' => $producao,
        ];
        $this->load->vars($dados);
        $this->load->view('components/head');
        $this->load->view('components/navbar');
        $this->load->view('components/left_menu');
        $this->load->view('pedidos/fim');
        $this->load->view('components/footer');
    }

    /* Lista de produtos */
    public function produtos()
    {
        if (!ver_regra('produtos', 'r')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('dashboard');
        }
        $dados = [
            /*Load*/
            'waves' => true, 'anima' => true, 'customcss' => true, 'customjs' => true, 'alltheme' => true, 'datatable' => true, 'angular' => true, 'select2' => true, 'myjs' => true,
            'ckeditor' => true, 'mycss' => true,
            /* Gera menu lateral */
            'left_menu' => left_menu(),
            /*Dados*/
            'titulo' => 'Produtos',
            'produtos' => $this->produtos_model->find(),
        ];
        $this->load->vars($dados);
        $this->load->view('components/head');
        $this->load->view('components/navbar');
        $this->load->view('components/left_menu');
        $this->load->view('produtos/index');
        $this->load->view('components/footer');
    }

    /* Lista de atendimentos */
    public function atendimentos()
    {
        if (!ver_regra('atendimentos', 'r')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('dashboard');
        }

        $atendimentos = $this->atendimentos_model->find();
        if ($atendimentos) {
            foreach ($atendimentos as $atendimento) {
                $atendimento->cliente = $this->clientes_model->find($atendimento->cliente)[0]->nome;
                $atendimento->usuario = $this->usuarios_model->find($atendimento->usuario)[0]->nome;
            }
        }

        $dados = [
            /*Load*/
            'waves' => true, 'anima' => true, 'customcss' => true, 'customjs' => true, 'alltheme' => true, 'datatable' => true, 'angular' => true, 'select2' => true, 'myjs' => true,
            'mycss' => true,
            /* Gera menu lateral */
            'left_menu' => left_menu(),
            /*Dados*/
            'titulo' => 'Atendimentos',
            'atendimentos' => $atendimentos,
            'clientes' => $this->clientes_model->find(),
            'usuarios' => $this->usuarios_model->find(),
        ];
        $this->load->vars($dados);
        $this->load->view('components/head');
        $this->load->view('components/navbar');
        $this->load->view('components/left_menu');
        $this->load->view('atendimentos/index');
        $this->load->view('components/footer');
    }

    public function ainit()
    {
        if (!ver_regra('atendimentos', 'c')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('dashboard');
        }

        $clientes = $this->clientes_model->find();

        $dados = [
            /*Load*/
            'waves' => true, 'anima' => true, 'customcss' => true, 'customjs' => true, 'alltheme' => true, 'angular' => true, 'myjs' => true, 'autosize' => true,
            /* Gera menu lateral */
            'left_menu' => left_menu(),
            /*Dados*/
            'titulo' => 'Atendimentos',
            'clientes' => $clientes,
        ];
        $this->load->vars($dados);
        $this->load->view('components/head');
        $this->load->view('components/navbar');
        $this->load->view('components/left_menu');
        $this->load->view('atendimentos/init');
        $this->load->view('components/footer');
    }

    /* Lista de contas */
    public function contas()
    {
        if (!ver_regra('financeiro', 'r')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('dashboard');
        }

        $receber = $this->titulos_model->getReceber();
        if ($receber) {
            foreach ($receber as $item) {
                $item->tipo = $this->tipos_model->find($item->tipo)[0]->nome;
                $item->motivo = $this->motivos_model->find($item->motivo)[0]->nome;
            }
        }

        $pagar = $this->titulos_model->getPagar();;
        if ($pagar) {
            foreach ($pagar as $item) {
                $item->tipo = $this->tipos_model->find($item->tipo)[0]->nome;
                $item->motivo = $this->motivos_model->find($item->motivo)[0]->nome;
            }
        }

        $first = date('d/m/Y h:i:s', mktime(0, 0, 1, 1, 1, date("Y")));
        $last = date('d/m/Y h:i:s', mktime(23, 59, 59, 12, 31, date("Y")));

        $geral = $this->titulos_model->findBetween($first, $last);
        $final = ['receita' => 0, 'despesa' => 0, 'total' => 0];
        if ($geral) {
            foreach ($geral as $item) {
                $item->cliente = $this->clientes_model->find($item->cliente)[0]->nome;
                $item->motivo = $this->motivos_model->find($item->motivo)[0]->nome;
                if ($item->tipo == 1) {
                    $final['receita'] += $item->valor_parcela;
                    $final['total'] += $item->valor_parcela;
                } elseif ($item->tipo == 2) {
                    $final['despesa'] += $item->valor_parcela;
                    $final['total'] -= $item->valor_parcela;
                }
            }
        }

        $gerar = $this->pedidos_model->findFatura();

        $dados = [
            /*Load*/
            'waves' => true, 'anima' => true, 'customcss' => true, 'customjs' => true, 'alltheme' => true, 'datatable' => true, 'angular' => true, 'myjs' => true, 'datapicker' => true,
            'select2' => true, 'mycss' => true,
            /* Gera menu lateral */
            'left_menu' => left_menu(),
            /*Dados*/
            'titulo' => 'Lista de títulos',
            'receber' => $receber,
            'pagar' => $pagar,
            'geral' => $geral,
            'final' => $final,
            'gerar' => $gerar,
            'clientes' => $this->clientes_model->find(),
            'usuarios' => $this->usuarios_model->find(),
            'motivos' => $this->motivos_model->find(),
        ];
        $this->load->vars($dados);
        $this->load->view('components/head');
        $this->load->view('components/navbar');
        $this->load->view('components/left_menu');
        $this->load->view('contas/index');
        $this->load->view('components/footer');
    }

    public function cinit()
    {
        if (!ver_regra('financeiro', 'c')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('financeiro');
        }

        $gerar = ($this->input->get('id')) ? $this->pedidos_model->find($this->input->get('id'))[0] : null;

        $dados = [
            /*Load*/
            'waves' => true, 'anima' => true, 'customcss' => true, 'customjs' => true, 'alltheme' => true, 'datatable' => true, 'angular' => true, 'myjs' => true,
            /* Gera menu lateral */
            'left_menu' => left_menu(),
            /*Dados*/
            'titulo' => 'Entrada de título',
            'clientes' => $this->clientes_model->find(),
            'pedidos' => $this->pedidos_model->getOpen(),
            'motivos' => $this->motivos_model->find(),
            'tipos' => $this->tipos_model->find(),
            'gerar' => $gerar,
        ];
        $this->load->vars($dados);
        $this->load->view('components/head');
        $this->load->view('components/navbar');
        $this->load->view('components/left_menu');
        $this->load->view('contas/init');
        $this->load->view('components/footer');
    }

    public function cfim($id)
    {
        if (!ver_regra('financeiro', 'r') || !ver_regra('financeiro', 'u')) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('financeiro');
        }

        $dado = $this->titulos_model->getFatura($id)[0];
        if (!$dado) {
            $this->session->set_flashdata('erro', 'título já faturado');
            redirect('financeiro');
        }

        $dados = [
            /*Load*/
            'waves' => true, 'anima' => true, 'customcss' => true, 'customjs' => true, 'alltheme' => true, 'datatable' => true, 'angular' => true, 'myjs' => true,
            /* Gera menu lateral */
            'left_menu' => left_menu(),
            /*Dados*/
            'titulo' => 'Faturar título ' . $id,
            'dado' => $dado,
            'clientes' => $this->clientes_model->find(),
            'pedidos' => $this->pedidos_model->getOpen(),
            'motivos' => $this->motivos_model->find(),
            'tipos' => $this->tipos_model->find(),
        ];

        $this->load->vars($dados);
        $this->load->view('components/head');
        $this->load->view('components/navbar');
        $this->load->view('components/left_menu');
        $this->load->view('contas/fatura');
        $this->load->view('components/footer');
    }

    /* Acesso ao perfil */
    public function perfil()
    {
        $perfil = $this->usuarios_model->find($this->session->userdata('auth')['id'])[0];
        if (!$perfil) {
            $this->session->set_flashdata('erro', 'voce não pode fazer essa ação');
            redirect('dashboard');
        }

        unset($perfil->senha);

        $dados = [
            /*Load*/
            'waves' => true, 'anima' => true, 'customcss' => true, 'customjs' => true, 'alltheme' => true, 'datatable' => true, 'angular' => true, 'myjs' => true,
            /* Gera menu lateral */
            'left_menu' => left_menu(),
            /*Dados*/
            'titulo' => 'Perfil',
            'perfil' => $perfil,
        ];
        $this->load->vars($dados);
        $this->load->view('components/head');
        $this->load->view('components/navbar');
        $this->load->view('components/left_menu');
        $this->load->view('usuarios/perfil');
        $this->load->view('components/footer');
    }

}
