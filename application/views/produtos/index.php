<section class="content" ng-controller="produto">
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
            <span>Lista de clientes</span>
            <button type="button" class="btn btn-success waves-effect right" data-toggle="modal" data-target="#incluir" ng-click="teste()">
                <i class="material-icons bottom">add</i>Novo
            </button>
            <button type="button" class="btn bg-blue-grey waves-effect right" data-toggle="modal" data-target="#relatorio">
                <i class="material-icons bottom">assignment</i>Relatório
            </button>
        </div>
        <div class="panel-body">
            <table class="table" id="table">
                <thead>
                <tr>
                    <th>id</th>
                    <th>produto</th>
                    <th>quantidade</th>
                    <th>preço</th>
                    <th>ação</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($produtos): foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?= $produto->id; ?></td>
                        <td><?= $produto->nome; ?></td>
                        <td><?= $produto->quantidade; ?></td>
                        <td><?= $produto->preco; ?></td>
                        <td>
                            <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#editar" ng-click="editar('<?= $produto->id; ?>')">
                                <i class="material-icons bottom">edit</i>Editar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="incluir" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="incluirTitle">Incluir Produto</h4>
                </div>
                <?= form_open(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <select class="form-control ms" name="tipo" ng-model="tipo" ng-value="tipo" ng-change="editor()">
                                <option value="0" disabled selected>Tipo de produto</option>
                                <option value="1">Unítario</option>
                                <option value="2">Metro Quadrado</option>
                                <option value="3">Metro Linear</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group" ng-if="tipo == 1">
                        <div class="form-line">
                            <label>Quantidade</label>
                            <input type="number" name="quantidade" class="form-control" min="0" required>
                        </div>
                    </div>
                    <div class="form-group" ng-if="tipo == 1">
                        <div class="form-line">
                            <label for="comentario">Descrição</label>
                            <textarea name="comentario" ck-editor></textarea>
                        </div>
                    </div>

                    <div class="form-group" ng-if="tipo == 2">
                        <div class="form-line">
                            <label>Altura</label>
                            <input type="number" name="altura" class="form-control" min="0" step="any" required>
                        </div>
                    </div>

                    <div class="form-group" ng-if="tipo == 2">
                        <div class="form-line">
                            <label>Largura</label>
                            <input type="number" name="largura" class="form-control" min="0" step="any" required>
                        </div>
                    </div>

                    <div class="form-group" ng-if="tipo == 3">
                        <div class="form-line">
                            <label>Comprimento</label>
                            <input type="number" name="comprimento" class="form-control" min="0" step="any" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-line">
                            <label>Preço</label>
                            <input type="number" name="preco" class="form-control" min="0" step="any" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-link waves-effect">Salvar</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Cancelar</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editar" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editTitle">Editar {{ nome }}</h4>
                </div>
                <?= form_open('produtos/edit'); ?>
                <input type="text" name="id" ng-model="id" hidden>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <select class="form-control ms" name="tipo" ng-model="tipo" ng-value="tipo" ng-change="editor()">
                                <option value="0" disabled selected>Tipo de produto</option>
                                <option value="1">Unitário</option>
                                <option value="2">Metro Quadrado</option>
                                <option value="3">Metro Linear</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="nome" class="form-control" placeholder="Nome" ng-model="nome" required>
                        </div>
                    </div>

                    <div class="form-group" ng-if="tipo == 1">
                        <div class="form-line">
                            <label>Quantidade</label>
                            <input type="number" name="quantidade" class="form-control" placeholder="Quantidade" min="0" ng-model="quantidade" required>
                        </div>
                    </div>
                    <div class="form-group" ng-if="tipo == 1">
                        <div class="form-line">
                            <label for="comentario">Descrição</label>
                            <textarea name="comentario" ck-editor ng-model="comentario"></textarea>
                        </div>
                    </div>

                    <div class="form-group" ng-if="tipo == 2">
                        <div class="form-line">
                            <label>Altura</label>
                            <input type="number" name="altura" class="form-control" min="0" step="any" ng-model="altura" required>
                        </div>
                    </div>

                    <div class="form-group" ng-if="tipo == 2">
                        <div class="form-line">
                            <label>Largura</label>
                            <input type="number" name="largura" class="form-control" min="0" step="any" ng-model="largura" required>
                        </div>
                    </div>

                    <div class="form-group" ng-if="tipo == 3">
                        <div class="form-line">
                            <label>Comprimento</label>
                            <input type="number" name="comprimento" class="form-control" min="0" step="any" ng-model="comprimento" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-line">
                            <label>Preço</label>
                            <input type="number" name="preco" class="form-control" min="0" step="any" ng-model="preco" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-link waves-effect">Salvar</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Cancelar</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="zerar" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-col-red">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteTitle">Zerar {{ nome }}</h4>
                </div>
                <?= form_open('produtos/zerar'); ?>
                <input type="text" name="id" ng-model="id" hidden>
                <input type="text" name="nome" ng-model="nome" hidden>
                <div class="modal-body">
                    Deseja realmente <strong>Zerar</strong> o produto {{ nome }}, após realizar ação produto não estará mais disponível para uso em produção!
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-link waves-effect">Confirmar</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Cancelar</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="relatorio" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>
                        Relatório de Produtos
                    </h1>
                </div>
                <?= form_open('produtos/relatorio', 'target="_blank"'); ?>
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label>Tipo</label>
                                <select name="tipo" class="ms sel w-auto">
                                    <option value="" selected>...</option>
                                    <option value="1">Unitário</option>
                                    <option value="2">Metro Quadrado</option>
                                    <option value="3">Metro Linear</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label>Produto Zerado</label>
                                <select name="zerado" class="ms sel w-auto">
                                    <option value="" selected>...</option>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-xs-6 col-md-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <div class="form-inline">
                                        <label>Quantidade de:</label>
                                        <input type="number" name="quantidadede" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <div class="form-inline">
                                        <label>até:</label>
                                        <input type="number" name="quantidadeate" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-6 col-md-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <div class="form-inline">
                                        <label>Altura de:</label>
                                        <input type="number" name="alturade" step="any" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <div class="form-inline">
                                        <label>até:</label>
                                        <input type="number" name="alturaate" step="any" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-6 col-md-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <div class="form-inline">
                                        <label>Largura de:</label>
                                        <input type="number" name="largurade" step="any" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <div class="form-inline">
                                        <label>até:</label>
                                        <input type="number" name="larguraate" step="any" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-6 col-md-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <div class="form-inline">
                                        <label>Comprimento de:</label>
                                        <input type="number" name="comprimentode" step="any" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <div class="form-inline">
                                        <label>até:</label>
                                        <input type="number" name="comprimentoate" step="any" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-6 col-md-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <div class="form-inline">
                                        <label>Preço de:</label>
                                        <input type="number" name="precode" step="any" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <div class="form-inline">
                                        <label>até:</label>
                                        <input type="number" name="precoate" step="any" class="form-control">
                                    </div>
                                </div>
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