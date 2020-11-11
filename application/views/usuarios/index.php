<section class="content" ng-controller="usuario">
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
            <span>Lista de usuários</span>
            <button type="button" class="btn btn-success waves-effect right" data-toggle="modal" data-target="#incluir"><i class="material-icons bottom">add</i>Novo</button>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>id</th>
                <th>nome</th>
                <th>email</th>
                <th>ação</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($usuarios): foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario->id; ?></td>
                    <td><?= $usuario->nome; ?></td>
                    <td><?= $usuario->email; ?></td>
                    <td>
                        <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#editar" ng-click="editar('<?= $usuario->id; ?>')">
                            <i class="material-icons bottom">edit</i>Editar
                        </button>
                        <?php if ($usuario->status):  ?>
                        <button type="button" class="btn btn-warning waves-effect" data-toggle="modal" data-target="#status" ng-click="ativar('<?= $usuario->id; ?>')">
                            <i class="material-icons bottom">block</i>Desativar
                        </button>
                        <?php else: ?>
                        <button type="button" class="btn btn-success waves-effect" data-toggle="modal" data-target="#status" ng-click="ativar('<?= $usuario->id; ?>')">
                            <i class="material-icons bottom">check</i>Ativar
                        </button>
                        <?php endif; ?>
                        <button type="button" class="btn btn-danger waves-effect" data-toggle="modal" data-target="#deletar" ng-click="remover('<?= $usuario->id; ?>')">
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

                    <div class="form-group">
                        <div class="form-line">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="usuario" class="form-control" placeholder="Usuário" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-line">
                            <input type="password" name="senha" class="form-control" placeholder="Senha" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-line">
                            <select name="grupo" class="form-control show-tick">
                                <?php if ($grupos): foreach ($grupos as $grupo): ?>
                                    <option value="<?= $grupo->id; ?>"><?= $grupo->nome; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editTitle">Editar {{ nome }}</h4>
                </div>
                <?= form_open('usuarios/edit'); ?>
                <input type="text" name="id" ng-model="id" hidden>
                <div class="modal-body">

                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="nome" class="form-control" placeholder="Nome" ng-model="nome" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-line">
                            <input type="email" name="email" class="form-control" placeholder="Email" ng-model="email" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" name="usuario" class="form-control" placeholder="Usuário" ng-model="usuario" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-line">
                            <input type="password" name="senha" class="form-control" placeholder="Senha">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-line">
                            <select name="grupo" class="form-control ms" ng-model="grupo">
                                <?php if ($grupos): foreach ($grupos as $grupo): ?>
                                    <option value="<?= $grupo->id; ?>"><?= $grupo->nome; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-col-red">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteTitle">Excluir {{ nome }}</h4>
                </div>
                <?= form_open('usuarios/delet'); ?>
                <input type="text" name="id" ng-model="id" hidden>
                <input type="text" name="nome" ng-model="nome" hidden>
                <div class="modal-body">
                    Deseja realmente <strong>REMOVER</strong> o usuário {{ nome }}, após realizar ação o usuário ficará sem acesso ao sistema!
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-link waves-effect">Confirmar</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Cancelar</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="status" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-col-deep-orange">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteTitle">{{ titulo }} {{ nome }}</h4>
                </div>
                <?= form_open('usuarios/status'); ?>
                <input type="text" name="id" ng-model="id" hidden>
                <input type="text" name="nome" ng-model="nome" hidden>
                <input type="text" name="status" ng-model="status" hidden>
                <div class="modal-body">
                    Deseja realmente <strong class="text-uppercase">{{ titulo }} O STATUS</strong> do usuário {{ nome }}?!
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