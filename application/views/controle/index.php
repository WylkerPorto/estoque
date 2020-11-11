<section class="content" ng-controller="controle">
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
            <span>Lista de grupos</span>
            <button type="button" class="btn btn-success waves-effect right" data-toggle="modal" data-target="#incluir"><i class="material-icons bottom">add</i>Novo</button>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>id</th>
                <th>nome</th>
                <th>ação</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($grupos): foreach ($grupos as $grupo): ?>
                <tr>
                    <td><?= $grupo->id; ?></td>
                    <td><?= $grupo->nome; ?></td>
                    <td>
                        <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#editar" ng-click="editar('<?= $grupo->id; ?>')">
                            <i class="material-icons bottom">edit</i>Editar
                        </button>
                        <button type="button" class="btn btn-danger waves-effect" data-toggle="modal" data-target="#deletar" ng-click="remover('<?= $grupo->id; ?>')">
                            <i class="material-icons bottom">delete</i>Apagar
                        </button>
                    </td>
                </tr>
            <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="incluir" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="incluirTitle">Incluir Grupo</h4>
                </div>
                <?= form_open(); ?>
                <div class="modal-body">

                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="nome" class="form-control" placeholder="Nome" required>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped table-condensed">
                        <ul>
                            <li><strong>C: </strong>Cadastro</li>
                            <li><strong>R: </strong>Leitura</li>
                            <li><strong>U: </strong>Atualização</li>
                            <li><strong>D: </strong>Exclusão</li>
                        </ul>
                        <thead>
                        <tr>
                            <th>Regra</th>
                            <?php if ($regras): foreach ($regras as $regra): ?>
                                <th>
                                    <?= $regra->cadastrar ? 'C' : null; ?>
                                    <?= $regra->ler ? 'R' : null; ?>
                                    <?= $regra->atualizar ? 'U' : null; ?>
                                    <?= $regra->deletar ? 'D' : null; ?>
                                </th>
                            <?php endforeach; endif; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($acessos): foreach ($acessos as $acesso): ?>
                            <tr>
                                <td><?= $acesso->nome; ?></td>
                                <?php if ($regras): foreach ($regras as $regra): ?>
                                    <td style="padding: 0!important; vertical-align: bottom" class="text-center">
                                        <input name="<?= $acesso->id; ?>" type="radio" value="<?= $regra->id; ?>" id="c<?= $acesso->id . $regra->id; ?>" class="radio-col-red"
                                            <?= $regra->id == 1 ? 'checked' : null; ?>>
                                        <label for="c<?= $acesso->id . $regra->id; ?>" class="m-b-0"></label>
                                    </td>
                                <?php endforeach; endif; ?>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>

                    <div class="form-group">
                        <div class="form-line">
                            <textarea name="desc" class="form-control no-resize auto-growth" placeholder="Descrição" rows="1"></textarea>
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
                <?= form_open('grupos/edit'); ?>
                <input type="text" name="id" ng-model="id" hidden>
                <div class="modal-body">

                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="nome" class="form-control" placeholder="Nome" ng-model="nome" required>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped table-condensed">
                        <ul>
                            <li><strong>C: </strong>Cadastro</li>
                            <li><strong>R: </strong>Leitura</li>
                            <li><strong>U: </strong>Atualização</li>
                            <li><strong>D: </strong>Exclusão</li>
                        </ul>
                        <thead>
                        <tr>
                            <th>Regra</th>
                            <?php if ($regras): foreach ($regras as $regra): ?>
                                <th>
                                    <?= $regra->cadastrar ? 'C' : null; ?>
                                    <?= $regra->ler ? 'R' : null; ?>
                                    <?= $regra->atualizar ? 'U' : null; ?>
                                    <?= $regra->deletar ? 'D' : null; ?>
                                </th>
                            <?php endforeach; endif; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($acessos): foreach ($acessos as $acesso): ?>
                            <tr>
                                <td><?= $acesso->nome; ?></td>
                                <?php if ($regras): foreach ($regras as $regra): ?>
                                    <td style="padding: 0!important; vertical-align: bottom" class="text-center">
                                        <input name="<?= $acesso->id; ?>" type="radio" value="<?= $regra->id; ?>" id="e<?= $acesso->id . $regra->id; ?>" class="radio-col-red"
                                               ng-model="<?= preg_replace('/&([a-z])[a-z]+;/i', '$1',htmlentities(trim($acesso->nome)) ); ?>">
                                        <label for="e<?= $acesso->id . $regra->id; ?>" class="m-b-0"></label>
                                    </td>
                                <?php endforeach; endif; ?>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>

                    <div class="form-group">
                        <div class="form-line">
                            <textarea name="desc" class="form-control no-resize auto-growth" placeholder="Descrição" rows="1" ng-model="desc"></textarea>
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

    <div class="modal fade" id="deletar" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-col-red">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteTitle">Excluir {{ nome }}</h4>
                </div>
                <?= form_open('grupos/delet'); ?>
                <input type="text" name="id" ng-model="id" hidden>
                <input type="text" name="nome" ng-model="nome" hidden>
                <div class="modal-body">
                    Deseja realmente <strong>REMOVER</strong> o grupo {{ nome }}, após realizar ação todos os usuários vinculados ao grupo precisarão ser reconfigurados ou ficarão sem acesso!
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-link waves-effect">Confirmar</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Cancelar</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

</section>