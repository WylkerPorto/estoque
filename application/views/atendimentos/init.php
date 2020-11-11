<section class="content" ng-controller="ainit" ng-init="iniciar()">
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
            <span>Atendimento</span>
        </div>
        <?= form_open('', 'class="form-horizontal"'); ?>
        <div class="panel-body">
            <div class="row clearfix">
                <div class="col-xs-3">
                    <div class="form-group">
                        <div class="form-line m-l-15">
                            <label>Código</label>
                            <input type="number" class="form-control" ng-model="cliente" string-to-number min="1" ng-change="ver(cliente)" required>
                        </div>
                    </div>
                </div>
                <div class="col-xs-9">
                    <label>Cliente</label>
                    <select class="form-control ms sel" name="cliente" ng-model="cliente" ng-change="ver(cliente)" required>
                        <?php if ($clientes): foreach ($clientes as $cliente): ?>
                            <option value="<?= $cliente->id; ?>"><?= $cliente->nome; ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
            </div>

            <div class="row m-t-15 clearfix">
                <div class="col-xs-12">
                    <label>Observação</label>
                    <textarea name="conteudo" class="form-control auto-growth no-resize" required></textarea>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <a type="button" class="btn btn-primary" href="<?= base_url('atendimentos') ?>"><i class="material-icons">reply</i>Cancelar</a>
            <button class="btn btn-success right"><i class="material-icons">save</i>Salvar</button>
        </div>
        <?= form_close(); ?>
    </div>

    <div class="panel" ng-show="historicos">
        <div class="panel-heading"><h3>Histórico dos ultimos 10 registros</h3></div>
        <div class="panel-body">
            <div class="row card" ng-repeat="historico in historicos">
                <div class="col-xs-6">
                    <div class="form-group">
                        Cliente: {{ historico.cliente }}
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        Data: {{ historico.data }}
                    </div>
                </div>
                <div class="col-xs-12 border">
                    <div class="form-group">
                        <p>Detalhes</p>
                        {{ historico.conteudo }}
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-group">
                        Usuário: {{ historico.usuario }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>