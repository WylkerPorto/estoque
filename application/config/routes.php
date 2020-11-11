<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'publico';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/* Rotas de autenticação */
$route['login']['POST'] = 'publico/login';
$route['logout']['GET'] = 'publico/logout';
//$route['recuperar']['GET'] = 'publico/recupera';
//$route['recuperar']['POST'] = 'publico/reseta';

/* Rota de acesso ao dashboard */
$route['dashboard']['GET'] = 'dashboard';

/* Rotas de Grupos e permissões (Crud) */
$route['grupos']['GET'] = 'dashboard/controle';
$route['grupos']['POST'] = 'grupos/create';
$route['grupos/edit']['POST'] = 'grupos/update';
$route['grupos/delet']['POST'] = 'grupos/delete';
$route['grupos/(:num)']['GET'] = 'grupos/get/$1';

/* Rotas de Usuarios (Crud) */
$route['usuarios']['GET'] = 'dashboard/usuario';
$route['usuarios']['POST'] = 'usuarios/create';
$route['usuarios/edit']['POST'] = 'usuarios/update';
$route['usuarios/status']['POST'] = 'usuarios/stats';
$route['usuarios/delet']['POST'] = 'usuarios/delete';
$route['usuarios/(:num)']['GET'] = 'usuarios/get/$1';

/* Rotas de Clientes (Crud) */
$route['clientes']['GET'] = 'dashboard/cliente';
$route['clientes']['POST'] = 'clientes/create';
$route['clientes/edit']['POST'] = 'clientes/update';
$route['clientes/status']['POST'] = 'clientes/stats';
$route['clientes/delet']['POST'] = 'clientes/delete';
$route['clientes/(:num)']['GET'] = 'clientes/get/$1';

/* Rotas de Produtos (Crud) */
$route['produtos']['GET'] = 'dashboard/produtos';
$route['produtos']['POST'] = 'produtos/create';
$route['produtos/edit']['POST'] = 'produtos/update';
$route['produtos/zerar']['POST'] = 'produtos/zero';
$route['produtos/(:num)']['GET'] = 'produtos/get/$1';

/* Rotas de Pedidos (Crud) */
$route['pedidos']['GET'] = 'dashboard/pedidos';
$route['pedidos/(:num)']['GET'] = 'produtos/pedido/$1'; //retorna produtos do pedido
$route['pedidos/get/(:num)']['GET'] = 'pedidos/get/$1'; //retorno dados do pedido
$route['pedidos/novo']['GET'] = 'dashboard/pinit';
$route['pedidos/novo']['POST'] = 'pedidos/create';
$route['pedidos/edit/(:num)']['GET'] = 'dashboard/pedit/$1';
$route['pedidos/edit']['POST'] = 'pedidos/update';
$route['pedidos/iniciar']['POST'] = 'pedidos/iniciar';
$route['pedidos/parar']['POST'] = 'pedidos/parar';
$route['pedidos/cancelar']['POST'] = 'pedidos/cancelar';
$route['pedidos/finalizar/(:num)']['GET'] = 'dashboard/pfim/$1';
$route['pedidos/finish']['POST'] = 'pedidos/finalizar';
$route['pedidos/getprod/(:num)']['GET'] = 'produtos/getpedido/$1';

/* Rotas de Atendimenos (Crud) */
$route['atendimentos']['GET'] = 'dashboard/atendimentos';
$route['atendimentos/new']['GET'] = 'dashboard/ainit';
$route['atendimentos/new']['POST'] = 'atendimentos/create';
$route['atendimentos/new/(:num)']['GET'] = 'atendimentos/history/$1';
$route['atendimentos/(:num)']['GET'] = 'atendimentos/get/$1';

/* Rotas de Contas (Crud) */
$route['financeiro']['GET'] = 'dashboard/contas';
$route['financeiro/new']['GET'] = 'dashboard/cinit';
$route['financeiro/new']['POST'] = 'financeiro/create';
$route['financeiro/(:num)']['GET'] = 'financeiro/get/$1';
$route['financeiro/rec']['GET'] = 'financeiro/receitas';
$route['financeiro/fatura/(:num)']['GET'] = 'dashboard/cfim/$1';
$route['financeiro/fatura/(:num)']['POST'] = 'financeiro/fecha/$1';

/* Rota de acesso ao perfil */
$route['perfil']['GET'] = 'dashboard/perfil';
$route['perfil']['POST'] = 'usuarios/perfil';

/* Rotas de relatorios */
$route['financeiro/relatorio']['POST'] = 'financeiro/relatorio';
$route['atendimento/relatorio']['POST'] = 'atendimento/relatorio';
$route['pedido/relatorio']['POST'] = 'pedido/relatorio';
$route['produto/relatorio']['POST'] = 'produto/relatorio';
$route['cliente/relatorio']['POST'] = 'cliente/relatorio';
$route['usuario/relatorio']['POST'] = 'usuario/relatorio';
$route['grupo/relatorio']['POST'] = 'grupo/relatorio';
