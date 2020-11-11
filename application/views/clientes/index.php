<section class="content" ng-controller="cliente">
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
            <button type="button" class="btn btn-success waves-effect right" data-toggle="modal" data-target="#incluir"><i class="material-icons bottom">add</i>Novo</button>
            <button type="button" class="btn bg-blue-grey waves-effect right" data-toggle="modal" data-target="#relatorio">
                <i class="material-icons bottom">assignment</i>Relatório
            </button>
        </div>
        <div class="panel-body">
            <table class="table" id="table">
                <thead>
                <tr>
                    <th>id</th>
                    <th>nome</th>
                    <th>email</th>
                    <th>telefone</th>
                    <th>ação</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($clientes): foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?= $cliente->id; ?></td>
                        <td><?= $cliente->nome; ?></td>
                        <td><?= $cliente->email; ?></td>
                        <td><?= $cliente->telefone; ?></td>
                        <td>
                            <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#editar" ng-click="editar('<?= $cliente->id; ?>')">
                                <i class="material-icons bottom">edit</i>Editar
                            </button>
                            <?php if (!$cliente->status) : ?>
                                <button type="button" class="btn btn-success waves-effect" data-toggle="modal" data-target="#status" ng-click="ativar('<?= $cliente->id; ?>')">
                                    <i class="material-icons bottom">check</i>Ativar
                                </button>
                            <?php else : ?>
                                <button type="button" class="btn btn-warning waves-effect" data-toggle="modal" data-target="#status" ng-click="ativar('<?= $cliente->id; ?>')">
                                    <i class="material-icons bottom">block</i>Desativar
                                </button>
                            <?php endif; ?>
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
                    <h4 class="modal-title" id="incluirTitle">Incluir Cliente</h4>
                </div>
                <?= form_open(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <label>Tipo de Cliente</label>
                            <select name="tipo" class="ms form-control" ng-model="tipo" ng-blur="mask()">
                                <option value="1">Pessoa Física</option>
                                <option value="2">Pessoa Juridica</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row" ng-if="tipo == 1">
                        <div class="col-xs-8">
                            <div class="form-line">
                                <label>Nome</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-xs-4">
                            <div class="form-line">
                                <label>Nascimento</label>
                                <input type="date" name="nascimento" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" ng-if="tipo == 2">
                        <div class="form-line">
                            <label>Nome Fantasia</label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row" ng-if="tipo == 2">
                        <div class="col-xs-6">
                            <div class="form-line">
                                <label>CNPJ</label>
                                <input type="text" name="cnpj" class="form-control cnpj" required>
                            </div>
                        </div>

                        <div class="col-xs-6">
                            <div class="form-line">
                                <label>IE</label>
                                <input type="text" name="ie" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row" ng-if="tipo == 1">
                        <div class="col-xs-6">
                            <div class="form-line">
                                <label>CPF</label>
                                <input type="text" name="cpf" class="form-control cpf">
                            </div>
                        </div>

                        <div class="col-xs-6">
                            <div class="form-line">
                                <label>RG</label>
                                <input type="text" name="rg" class="form-control rg">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-xs-6">
                            <div class="form-line">
                                <label>Telefone</label>
                                <input type="tel" name="telefone" class="form-control fone" >
                            </div>
                        </div>

                        <div class="col-xs-6">
                            <div class="form-line">
                                <label>Telefone 2</label>
                                <input type="tel" name="telefone2" class="form-control fone">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-line">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-xs-6">
                            <div class="form-line">
                                <label>CEP</label>
                                <input type="number" name="cep" class="form-control">
                            </div>
                        </div>

                        <div class="col-xs-6">
                            <div class="form-line">
                                <label>Endereço</label>
                                <input type="text" name="endereco" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg waves-effect pull-left btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-lg waves-effect btn-success">Salvar</button>
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
                <?= form_open('clientes/edit'); ?>
                <input type="text" name="id" ng-model="char.id" hidden>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-line">
                            <label>Tipo de Cliente</label>
                            <select name="tipo" class="ms form-control" ng-model="char.tipo" ng-blur="mask()">
                                <option value="1">Pessoa Física</option>
                                <option value="2">Pessoa Juridica</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row" ng-if="char.tipo == 1">
                        <div class="col-xs-8">
                            <div class="form-line">
                                <label>Nome</label>
                                <input type="text" name="nome" class="form-control" ng-model="char.nome" required>
                            </div>
                        </div>

                        <div class="col-xs-4">
                            <div class="form-line">
                                <label>Nascimento</label>
                                <input type="date" name="nascimento" class="form-control" ng-model="char.nascimento" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" ng-if="char.tipo == 2">
                        <div class="form-line">
                            <label>Nome Fantasia</label>
                            <input type="text" name="nome" class="form-control" ng-model="char.nome" required>
                        </div>
                    </div>

                    <div class="form-group row" ng-if="char.tipo == 2">
                        <div class="col-xs-6">
                            <div class="form-line">
                                <label>CNPJ</label>
                                <input type="text" name="cnpj" class="form-control cnpj" ng-model="char.cnpj" required>
                            </div>
                        </div>

                        <div class="col-xs-6">
                            <div class="form-line">
                                <label>IE</label>
                                <input type="text" name="ie" class="form-control" ng-model="char.ie">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row" ng-if="char.tipo == 1">
                        <div class="col-xs-6">
                            <div class="form-line">
                                <label>CPF</label>
                                <input type="text" name="cpf" class="form-control cpf" ng-model="char.cpf" required>
                            </div>
                        </div>

                        <div class="col-xs-6">
                            <div class="form-line">
                                <label>RG</label>
                                <input type="text" name="rg" class="form-control rg" ng-model="char.rg">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-xs-6">
                            <div class="form-line">
                                <label>Telefone</label>
                                <input type="tel" name="telefone" class="form-control fone" ng-model="char.telefone" required>
                            </div>
                        </div>

                        <div class="col-xs-6">
                            <div class="form-line">
                                <label>Telefone 2</label>
                                <input type="tel" name="telefone2" class="form-control fone" ng-model="char.telefone2">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-line">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" ng-model="char.email" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-xs-6">
                            <div class="form-line">
                                <label>CEP</label>
                                <input type="number" name="cep" class="form-control" ng-model="char.cep" string-to-number="" required>
                            </div>
                        </div>

                        <div class="col-xs-6">
                            <div class="form-line">
                                <label>Endereço</label>
                                <input type="text" name="endereco" class="form-control" ng-model="char.endereco" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg waves-effect pull-left btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-lg waves-effect btn-success">Salvar</button>
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
                <?= form_open('clientes/status'); ?>
                <input type="text" name="id" ng-model="id" hidden>
                <input type="text" name="nome" ng-model="nome" hidden>
                <input type="text" name="status" ng-model="status" hidden>
                <div class="modal-body">
                    Deseja realmente <strong class="text-uppercase">{{ titulo }} O STATUS</strong> do usuário {{ nome }}?!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg waves-effect pull-left btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-lg waves-effect btn-success">Confirmar</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletar" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-col-deep-orange">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteTitle">Excluir {{ nome }}</h4>
                </div>
                <?= form_open('clientes/delet'); ?>
                <input type="text" name="id" ng-model="id" hidden>
                <input type="text" name="nome" ng-model="nome" hidden>
                <div class="modal-body">
                    Deseja realmente <strong>REMOVER</strong> o grupo {{ nome }}, após realizar ação todos os usuários vinculados ao grupo precisarão ser reconfigurados ou ficarão sem
                    acesso!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg waves-effect pull-left btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-lg waves-effect btn-success">Confirmar</button>
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
                        Relatório de Clientes
                    </h1>
                </div>
                <?= form_open('clientes/relatorio', 'target="_blank"'); ?>
                <div class="modal-body">
                    <div class="row cleafix">
                        <div class="col-xs-3 col-md-3">
                            <div class="form-group">
                                <label>Tipo</label>
                                <select name="tipo" class="ms sel w-100">
                                    <option value="" selected>...</option>
                                    <option value="1">Pessoa Física</option>
                                    <option value="2">Pessoa Juridica</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-9 col-md-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <label>Nome</label>
                                    <input type="text" name="nome" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-2">
                            <div class="form-group">
                                <label>Ativos</label>
                                <select name="status" class="ms sel w-100">
                                    <option value="" selected>...</option>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <label>CEP</label>
                                    <input type="number" name="cep" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-7">
                            <div class="form-inline">
                                <label>Nascimento de:</label>
                                <input type="date" name="nascimentode" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-5">
                            <div class="form-inline">
                                <label>até:</label>
                                <input type="date" name="nascimentoate" class="form-control">
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