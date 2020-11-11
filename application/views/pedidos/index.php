<section class="content" ng-controller="pedido">
    <?php if ($msg = $this->session->flashdata('erro')): ?>
        <div class="alert bg-red alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <?= $msg; ?>
        </div>
    <?php endif; ?>
    <?php if ($msg = $this->session->flashdata('sucesso')): ?>
        <div class="alert bg-green alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <?= $msg; ?>
        </div>
    <?php endif; ?>

    <div class="panel" ng-init="iniciar()">
        <div class="panel-heading">
            <span>Lista de pedidos</span>
            <a type="button" class="btn btn-success waves-effect right" href="<?= base_url('pedidos/novo') ?>"><i class="material-icons bottom">add</i>Novo</a>
            <button type="button" class="btn bg-blue-grey waves-effect right" data-toggle="modal" data-target="#relatorio">
                <i class="material-icons bottom">assignment</i>Relatório
            </button>
        </div>
        <div class="panel-body">

            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#orcamento" data-toggle="tab" aria-expanded="true">Orçamentos</a></li>
                <li role="presentation" class=""><a href="#pedido" data-toggle="tab" aria-expanded="false">Pedidos</a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="orcamento">
                    <table class="table dataTable">
                        <thead>
                        <tr>
                            <th>Número</th>
                            <th>Pedido</th>
                            <th>Entrega</th>
                            <th>Cliente</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($orcamentos): foreach ($orcamentos as $orcamento): ?>
                            <tr>
                                <td><?= $orcamento->id; ?></td>
                                <td><?= date('d/m/Y', strtotime($orcamento->data_pedido)); ?></td>
                                <td><?= date('d/m/Y', strtotime($orcamento->data_entrega)); ?></td>
                                <td><?= $orcamento->cliente; ?></td>
                                <td id="stt<?= $orcamento->id; ?>"><?= $orcamento->status_nome; ?></td>
                                <td>
                                    <?php if ($orcamento->status == 1): ?>
                                        <a role="button" id="bte<?= $orcamento->id; ?>" class="btn btn-primary waves-effect" href="<?= base_url('pedidos/edit/' . $orcamento->id); ?>">
                                            <i class="material-icons bottom m-r-5">edit</i>Editar
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($orcamento->status == 1 || $orcamento->status == 3): ?>
                                        <button type="button" id="btp<?= $orcamento->id; ?>" class="btn btn-success waves-effect" ng-click="play('<?= $orcamento->id; ?>')">
                                            <i class="material-icons bottom m-r-5">play_circle_outline</i>Iniciar
                                        </button>
                                    <?php endif; ?>
                                    <?php if ($orcamento->status < 4): ?>
                                        <button type="button" id="btc<?= $orcamento->id; ?>" class="btn btn-danger waves-effect" ng-click="cancel('<?= $orcamento->id; ?>')">
                                            <i class="material-icons bottom m-r-5">cancel_presentation</i>Cancelar
                                        </button>
                                    <?php endif; ?>

                                    <button type="button" class="btn btn-info waves-effect" ng-click="ver('<?= $orcamento->id; ?>')" data-toggle="modal" data-target="#view">
                                        <i class="material-icons bottom m-r-5">remove_red_eye</i>ver
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="pedido">
                    <table class="table dataTable">
                        <thead>
                        <tr>
                            <th>Número</th>
                            <th>Pedido</th>
                            <th>Entrega</th>
                            <th>Cliente</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($pedidos): foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td><?= $pedido->id; ?></td>
                                <td><?= date('d/m/Y', strtotime($pedido->data_pedido)); ?></td>
                                <td><?= date('d/m/Y', strtotime($pedido->data_entrega)); ?></td>
                                <td><?= $pedido->cliente; ?></td>
                                <td id="stt<?= $pedido->id; ?>"><?= $pedido->status_nome; ?></td>
                                <td>
                                    <?php if ($pedido->status == 1): ?>
                                        <a role="button" id="bte<?= $pedido->id; ?>" class="btn btn-primary waves-effect" href="<?= base_url('pedidos/edit/' . $pedido->id); ?>">
                                            <i class="material-icons bottom m-r-5">edit</i>Editar
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($pedido->status == 1 || $pedido->status == 3): ?>
                                        <button type="button" id="btp<?= $pedido->id; ?>" class="btn btn-success waves-effect" ng-click="play('<?= $pedido->id; ?>')">
                                            <i class="material-icons bottom m-r-5">play_circle_outline</i>Iniciar
                                        </button>
                                    <?php elseif ($pedido->status == 2): ?>
                                        <button type="button" id="bts<?= $pedido->id; ?>" class="btn btn-danger waves-effect" ng-click="stop('<?= $pedido->id; ?>')">
                                            <i class="material-icons bottom m-r-5">new_releases</i>Parar
                                        </button>
                                    <?php endif; ?>
                                    <?php if ($pedido->status < 4): ?>
                                        <a role="button" id="btf<?= $pedido->id; ?>" class="btn btn-success waves-effect" href="<?= base_url('pedidos/finalizar/' . $pedido->id); ?>">
                                            <i class="material-icons bottom m-r-5">unarchive</i>Finalizar
                                        </a>
                                        <button type="button" id="btc<?= $pedido->id; ?>" class="btn btn-danger waves-effect" ng-click="cancel('<?= $pedido->id; ?>')">
                                            <i class="material-icons bottom m-r-5">cancel_presentation</i>Cancelar
                                        </button>
                                    <?php endif; ?>

                                    <button type="button" class="btn btn-info waves-effect" ng-click="ver('<?= $pedido->id; ?>')" data-toggle="modal" data-target="#view">
                                        <i class="material-icons bottom m-r-5">remove_red_eye</i>ver
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="view" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-col-light-blue">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteTitle">pré visualização do pedido {{ id }}</h4>
                </div>
                <div class="modal-body">
                    <p><strong class="text-capitalize">Data do Pedido</strong> {{ pedido }}</p>
                    <p><strong class="text-capitalize">Data de Entrega</strong> {{ entrega }}</p>
                    <p><strong class="text-capitalize">Data de Finalização</strong> {{ finalizado }}</p>
                    <p><strong class="text-capitalize">Status</strong> {{ status }}</p>
                    <p><strong class="text-capitalize">Cliente</strong> {{ cliente }}</p>
                    <p><strong class="text-capitalize">Preço</strong> {{ preco }}</p>
                    <p ng-repeat="produto in produtos">
                        <strong class="text-capitalize">Produto</strong> {{ produto.nome }}
                        <strong ng-show="produto.quantidade" class="text-capitalize">Quantidade</strong> {{ produto.quantidade }}
                        <strong ng-show="produto.altura" class="text-capitalize">Altura</strong> {{ produto.altura }}
                        <strong ng-show="produto.largura" class="text-capitalize">Largura</strong> {{ produto.largura }}
                        <strong ng-show="produto.comprimento" class="text-capitalize">Comprimento</strong> {{ produto.comprimento }}
                    </p>
                    <p><strong class="text-capitalize">Observação</strong> {{ obs }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="relatorio" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>
                        Relatório de Pedidos
                    </h1>
                </div>
                <?= form_open('pedidos/relatorio', 'target="_blank"'); ?>
                <div class="modal-body">
                    <div class="row cleafix">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Cliente</label>
                                <select name="cliente" class="ms sel w-100">
                                    <option value="" selected>...</option>
                                    <?php foreach ($clientes as $cliente): ?>
                                        <option value="<?= $cliente->id; ?>"><?= $cliente->nome; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="ms sel w-100">
                                    <option value="" selected>...</option>
                                    <?php foreach ($status as $stat): ?>
                                        <option value="<?= $stat->id; ?>"><?= $stat->nome; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group m-t-25">
                                <input type="checkbox" name="produtos" id="md_checkbox_10" class="chk-col-green" value="1">
                                <label for="md_checkbox_10">Listar Produtos</label>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-xs-7 col-md-3">
                            <div class="form-inline">
                                <label>Preço de:</label>
                                <input type="number" name="precode" class="form-control w-auto">
                            </div>
                        </div>
                        <div class="col-xs-5 col-md-3">
                            <div class="form-inline">
                                <label>até:</label>
                                <input type="number" name="precoate" class="form-control w-auto">
                            </div>
                        </div>

                        <div class="col-xs-7 col-md-3">
                            <div class="form-inline">
                                <label>Pedido de:</label>
                                <input type="date" name="data_pedidode" class="form-control w-auto">
                            </div>
                        </div>
                        <div class="col-xs-5 col-md-3">
                            <div class="form-inline">
                                <label>até:</label>
                                <input type="date" name="data_pedidoate" class="form-control w-auto">
                            </div>
                        </div>

                        <div class="col-xs-7 col-md-3">
                            <div class="form-inline">
                                <label>Entrega de:</label>
                                <input type="date" name="data_entregade" class="form-control w-auto">
                            </div>
                        </div>
                        <div class="col-xs-5 col-md-3">
                            <div class="form-inline">
                                <label>até:</label>
                                <input type="date" name="data_entregaate" class="form-control w-auto">
                            </div>
                        </div>

                        <div class="col-xs-7 col-md-3">
                            <div class="form-inline">
                                <label>Finalizado de:</label>
                                <input type="date" name="data_finalizadode" class="form-control w-auto">
                            </div>
                        </div>
                        <div class="col-xs-5 col-md-3">
                            <div class="form-inline">
                                <label>até:</label>
                                <input type="date" name="data_finalizadoate" class="form-control w-auto">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg waves-effect pull-left btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-lg waves-effect btn-success">Gerar</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</section>