<section class="content" ng-controller="atendimento">
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
            <span>Lista de atendimentos</span>
            <a role="button" class="btn btn-success waves-effect right" href="<?= base_url('atendimentos/new'); ?>"><i class="material-icons bottom">add</i>Novo</a>
            <button type="button" class="btn bg-blue-grey waves-effect right" data-toggle="modal" data-target="#relatorio">
                <i class="material-icons bottom">assignment</i>Relatório
            </button>
        </div>
        <div class="panel-body">
            <table class="table" id="table">
                <thead>
                <tr>
                    <th>id</th>
                    <th>cliente</th>
                    <th>usuario</th>
                    <th>data</th>
                    <th>ações</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($atendimentos): foreach ($atendimentos as $atendimento): ?>
                    <tr>
                        <td><?= $atendimento->id; ?></td>
                        <td><?= $atendimento->cliente; ?></td>
                        <td><?= $atendimento->usuario; ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($atendimento->data)); ?></td>
                        <td>
                            <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#ver" ng-click='ver(<?= json_encode($atendimento); ?>)'>
                                <i class="material-icons bottom">visibility</i> Ver
                            </button>
                        </td>
                    </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="ver" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="incluirTitle">Detalhes do atendimento {{ id }}</h4>
                </div>
                <div class="modal-body">
                    <div class="col-xs-6">
                        <div class="form-group">
                            Cliente: {{ cliente }}
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            Data: {{ data }}
                        </div>
                    </div>
                    <div class="col-xs-12 border">
                        <div class="form-group">
                            <p>Detalhes</p>
                            {{ detalhes }}
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            Usuário: {{ usuario }}
                        </div>
                    </div>
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
                        Relatório de Atendimentos
                    </h1>
                </div>
                <?= form_open('atendimentos/relatorio', 'target="_blank"'); ?>
                <div class="modal-body">
                    <div class="row cleafix">
                        <div class="col-xs-6 col-md-4">
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
                        <div class="col-xs-6 col-md-4">
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
                    </div>
                    <div class="row cleafix">
                        <div class="col-xs-7 col-md-4">
                            <div class="form-inline">
                                <label>Data de:</label>
                                <input type="date" name="datade" class="form-control w-auto">
                            </div>
                        </div>
                        <div class="col-xs-5 col-md-4">
                            <div class="form-inline">
                                <label>até:</label>
                                <input type="date" name="dataate" class="form-control w-auto">
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