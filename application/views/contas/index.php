<section class="content" ng-controller="contas" ng-init="iniciar()">
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

    <div class="panel">
        <div class="panel-heading">
            <span>Lista de titulos</span>
            <a role="button" class="btn btn-success waves-effect right" href="<?= base_url('financeiro/new'); ?>"><i class="material-icons bottom">add</i>Novo</a>
            <button type="button" class="btn btn-info waves-effect right" data-toggle="modal" data-target="#buscar">
                <i class="material-icons bottom">visibility</i>Busca exclusiva
            </button>
            <button type="button" class="btn bg-blue-grey waves-effect right" data-toggle="modal" data-target="#relatorio">
                <i class="material-icons bottom">assignment</i>Relatório
            </button>
        </div>

        <div class="panel-body">

            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#pagar" data-toggle="tab" aria-expanded="true">Títulos a Pagar</a></li>
                <li role="presentation" class=""><a href="#receber" data-toggle="tab" aria-expanded="false">Títulos a Receber</a></li>
                <li role="presentation" class=""><a href="#gerar" data-toggle="tab" aria-expanded="false">Títulos a Gerar</a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="pagar">
                    <b>Títulos a Pagar</b>
                    <table class="table dataTable">
                        <thead>
                        <tr>
                            <th>titulo</th>
                            <th>parcela</th>
                            <th>tipo</th>
                            <th>valor</th>
                            <th>vencimento</th>
                            <th>ação</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($pagar): foreach ($pagar as $titulo): ?>
                            <tr>
                                <td><?= $titulo->id; ?></td>
                                <td><?= $titulo->parcela; ?></td>
                                <td><?= $titulo->motivo; ?></td>
                                <td><?= $titulo->valor_parcela; ?></td>
                                <td><?= date('d/m/Y', strtotime($titulo->vencimento)); ?></td>
                                <td>
                                    <a href="<?= base_url('financeiro/fatura/' . $titulo->id); ?>" class="btn btn-success">
                                        <i class="material-icons bottom">attach_money</i>Pagar</a>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="receber">
                    <b>Títulos a Receber</b>
                    <table class="table dataTable">
                        <thead>
                        <tr>
                            <th>titulo</th>
                            <th>parcela</th>
                            <th>tipo</th>
                            <th>valor</th>
                            <th>vencimento</th>
                            <th>ação</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($receber): foreach ($receber as $titulo): ?>
                            <tr>
                                <td><?= $titulo->id; ?></td>
                                <td><?= $titulo->parcela; ?></td>
                                <td><?= $titulo->motivo; ?></td>
                                <td><?= $titulo->valor_parcela; ?></td>
                                <td><?= date('d/m/Y', strtotime($titulo->vencimento)); ?></td>
                                <td>
                                    <a href="<?= base_url('financeiro/fatura/' . $titulo->id); ?>" class="btn btn-success">
                                        <i class="material-icons bottom">attach_money</i>faturar</a>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="gerar">
                    <b>Títulos a Gerar</b>
                    <table class="table dataTable">
                        <thead>
                        <tr>
                            <th>N. Pedido</th>
                            <th>Abertura</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($gerar): foreach ($gerar as $titulo): ?>
                            <tr>
                                <td><?= $titulo->id; ?></td>
                                <td><?= date('d/m/Y', strtotime($titulo->data_pedido)); ?></td>
                                <td><?= $titulo->preco; ?></td>
                                <td><?= $titulo->status; ?></td>
                                <td>
                                    <a href="<?= base_url('financeiro/new?id=' . $titulo->id); ?>" class="btn btn-success">
                                        <i class="material-icons bottom">attach_money</i>Gerar</a>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="buscar" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-inline">
                        <label>Titulo n:</label>
                        <input type="number" class="form-control" ng-model="tit" ng-change="localiza(tit, pac)">
                        <label>parcela n:</label>
                        <input type="number" class="form-control" ng-model="pac" ng-change="localiza(tit, pac)">
                    </div>
                </div>
                <div class="panel-footer">
                    <p class="col-xs-6"><b>cliente : </b>{{ esclusiva.cliente }}</p>
                    <p class="col-xs-6"><b>pedido : </b>{{ esclusiva.pedido }}</p>
                    <p class="col-xs-6"><b>tipo : </b>{{ esclusiva.tipo }}</p>
                    <p class="col-xs-6"><b>motivo : </b>{{ esclusiva.motivo }}</p>
                    <p class="col-xs-6"><b>valor total : </b>{{ esclusiva.valor_total }}</p>
                    <p class="col-xs-6"><b>total de parcelas : </b>{{ esclusiva.total_parcelas }}</p>
                    <p class="col-xs-6"><b>valor da parcela : </b>{{ esclusiva.valor_parcela }}</p>
                    <p class="col-xs-6"><b>pagamento : </b>{{ esclusiva.pagamento }}</p>
                    <p class="col-xs-6"><b>vencimento : </b>{{ esclusiva.vencimento }}</p>
                    <p class="col-xs-6"><b>data do pagamento : </b>{{ esclusiva.data_pagamento }}</p>
                    <p class="col-xs-6"><b>juros : </b>{{ esclusiva.juros }}</p>
                    <p class="col-xs-6"><b>desconto : </b>{{ esclusiva.desconto }}</p>
                    <p class="col-xs-6"><b>mutas : </b>{{ esclusiva.mutas }}</p>
                    <p class="col-xs-6"><b>usuário : </b>{{ esclusiva.usuario }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="relatorio" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>
                        Relatório Financeiro
                    </h1>
                </div>
                <?= form_open('financeiro/relatorio', 'target="_blank"'); ?>
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
                                <label>Usúario</label>
                                <select name="usuario" class="ms sel w-100">
                                    <option value="" selected>...</option>
                                    <?php foreach ($usuarios as $usuario): ?>
                                        <option value="<?= $usuario->id; ?>"><?= $usuario->nome; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Categoria</label>
                                <select name="motivo" class="ms sel w-100">
                                    <option value="" selected>...</option>
                                    <?php foreach ($motivos as $motivo): ?>
                                        <option value="<?= $motivo->id; ?>"><?= $motivo->nome; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <label>Título</label>
                                    <input type="number" name="titulo" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Pagos</label>
                                <select name="baixado" class="ms sel w-100">
                                    <option value="" selected>...</option>
                                    <option value="1">sim</option>
                                    <option value="0">não</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>I/O</label>
                                <select name="io" class="ms sel w-100">
                                    <option value="" selected>...</option>
                                    <option value="1">entrada</option>
                                    <option value="2">saida</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-xs-7">
                            <div class="form-inline">
                                <label>Vencimento de:</label>
                                <input type="date" name="vencimentode" class="form-control w-auto">
                            </div>
                        </div>
                        <div class="col-xs-5">
                            <div class="form-inline">
                                <label>até:</label>
                                <input type="date" name="vencimentoate" class="form-control w-auto">
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-xs-7">
                            <div class="form-inline">
                                <label>Pago de:</label>
                                <input type="date" name="pagamentode" class="form-control w-auto">
                            </div>
                        </div>
                        <div class="col-xs-5">
                            <div class="form-inline">
                                <label>até:</label>
                                <input type="date" name="pagamentoate" class="form-control w-auto">
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