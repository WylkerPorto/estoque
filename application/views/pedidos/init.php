<section class="content" ng-controller="pinit" ng-init="iniciar()">
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
            <span>Entrada de orçamento</span>
        </div>
        <?= form_open(); ?>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-4">
                    <div class="form-group">
                        <div class="form-line">
                            <label>Tipo de Entrada</label>
                            <select name="status" class="form-control" required>
                                <option value="1" selected>Orçamento</option>
                                <option value="2">Produção</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="col-xs-4">
                    <div class="form-group">
                        <div class="form-line">
                            <label>Data do pedido</label>
                            <input type="date" name="data_pedido" class="form-control" placeholder="Pedido" value="<?= date('Y-m-d'); ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-xs-4">
                    <div class="form-group">
                        <div class="form-line">
                            <label>Data de entrega</label>
                            <input type="date" name="data_entrega" class="form-control" placeholder="Entrega" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Cliente</label>
                <select class="form-control ms sel" name="cliente">
                    <option value="0" disabled selected>Cliente</option>
                    <?php if ($clientes): foreach ($clientes as $cliente): ?>
                        <option value="<?= $cliente->id; ?>"><?= $cliente->nome; ?></option>
                    <?php endforeach; endif; ?>
                </select>
            </div>

            <div class="form-group align-center">
                <button type="button" class="btn btn-success waves-effect" data-toggle="modal" data-target="#incluir" ng-click="add({id:0, nome:'teste', quantidade:3})">
                    <i class="material-icons bottom">add</i>Adicionar produto
                </button>
            </div>

            <table class="table" ng-show="produtos.length > 0">
                <thead>
                <tr>
                    <th>Cód</th>
                    <th>Uni</th>
                    <th>Tot</th>
                    <th>Item</th>
                    <th>Uso</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="6" class="align-center">
                        <i class="material-icons media-middle">add</i>Quantidade |
                        <i class="material-icons media-middle">format_line_spacing</i>Altura |
                        <i class="material-icons media-middle">developer_mode</i>Largura |
                        <i class="material-icons media-middle">straighten</i>Comprimento
                    </td>
                </tr>
                <tr ng-repeat="(chave,prod) in produtos">
                    <input type="hidden" name="id[{{ chave }}]" class="hidden" value="{{ prod.id }}" hidden readonly>
                    <td>{{ prod.id }}</td>
                    <td>{{ prod.preco | currency : 'R$:' : 2 }}</td>
                    <td>{{ prod.preco * (prod.quantidade * prod.altura * prod.largura * prod.comprimento) | currency : 'R$:' : 2 }}</td>
                    <td>{{ prod.nome }}</td>
                    <td>
                        <div class="form-inline">
                            <div class="input-group" ng-if="prod.tipo == 1">
                                <span class="input-group-addon">
                                    <i class="material-icons media-middle">add</i>
                                </span>
                                <div class="form-line">
                                    <input type="number" name="quantidade[{{ chave }}]" class="form-control p-0 h-20" min="1" ng-model="prod.quantidade" ng-change="soma()">
                                </div>
                            </div>
                            <div class="input-group" ng-if="prod.tipo == 2">
                                <span class="input-group-addon">
                                    <i class="material-icons media-middle">format_line_spacing</i>
                                </span>
                                <div class="form-line">
                                    <input type="number" name="altura[{{ chave }}]" class="form-control p-0 h-20" min="0.01" step="0.01" ng-model="prod.altura" ng-change="soma()">
                                </div>
                            </div>
                            <div class="input-group" ng-if="prod.tipo == 2">
                                <span class="input-group-addon">
                                    <i class="material-icons media-middle">developer_mode</i>
                                </span>
                                <div class="form-line">
                                    <input type="number" name="largura[{{ chave }}]" class="form-control p-0 h-20" min="0.01" step="0.01" ng-model="prod.largura" ng-change="soma()">
                                </div>
                            </div>
                            <div class="input-group" ng-if="prod.tipo == 3">
                                <span class="input-group-addon">
                                    <i class="material-icons media-middle">straighten</i>
                                </span>
                                <div class="form-line">
                                    <input type="number" name="comprimento[{{ chave }}]" class="form-control p-0 h-20" min="0.01" step="0.01" ng-model="prod.comprimento" ng-change="soma()">
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger" ng-click="delet(chave)">Remover</button>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="form-group h3 text-right">
                <input type="hidden" name="preco" class="hidden" ng-value="ptotal || '0.00'" hidden>
                <label>Total R$:</label>
                <span>{{ ptotal || '0.00' }}</span>
            </div>

            <div class="form-group">
                <div class="form-line">
                    <label>Observação</label>
                    <textarea name="obs" class="form-control auto-growth no-resize"></textarea>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <a type="button" class="btn btn-primary" href="<?= base_url('pedidos') ?>"><i class="material-icons">reply</i>Cancelar</a>
            <button class="btn btn-success right"><i class="material-icons">save</i>Salvar</button>
        </div>
        <?= form_close(); ?>
    </div>

    <div class="modal fade" id="incluir" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="incluirTitle">Incluir Produto</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover" id="table">
                        <thead>
                        <tr>
                            <th>Cód</th>
                            <th>Item</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-orange waves-effect" data-dismiss="modal" ng-click="selecionar()">Adicionar ao pedido</button>
                </div>
            </div>
        </div>
    </div>
</section>