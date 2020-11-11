<section class="content" ng-controller="cinit">
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
            <span>Cadastro de titulos</span>
        </div>
        <?= form_open('', 'class="form-horizontal"'); ?>
        <div class="panel-body">
            <div class="row clearfix">
                <div class="col-xs-3 col-md-2 m-b-5">
                    <div class="form-group">
                        <div class="form-line m-l-15">
                            <label>Código</label>
                            <input type="number" class="form-control" ng-model="tipos" string-to-number min="1" required>
                        </div>
                    </div>
                </div>
                <div class="col-xs-9 col-md-4 m-b-10">
                    <label>Tipo</label>
                    <select class="form-control ms sel" name="tipo" ng-model="tipos" required>
                        <?php if ($tipos): foreach ($tipos as $tipo): ?>
                            <option value="<?= $tipo->id; ?>"><?= $tipo->nome; ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="col-xs-3 col-md-2">
                    <div class="form-group">
                        <div class="form-line m-l-15">
                            <label>Código</label>
                            <input type="number" class="form-control" ng-model="motivos" string-to-number min="1" required>
                        </div>
                    </div>
                </div>
                <div class="col-xs-9 col-md-4">
                    <label>Categoria</label>
                    <select class="form-control ms sel" name="motivo" ng-model="motivos" required>
                        <?php if ($motivos): foreach ($motivos as $motivo): ?>
                            <option value="<?= $motivo->id; ?>"><?= $motivo->nome; ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-xs-3 col-md-2">
                    <div class="form-group">
                        <div class="form-line m-l-15">
                            <label>Código do Pedido</label>
                            <input type="number" name="pedido" class="form-control" ng-model="pedido" string-to-number min="1" ng-change="ver(pedido)"
                                   ng-init="seta(<?= ($this->input->get('id')) ? $this->input->get('id') : null ?>)">
                        </div>
                    </div>
                </div>
                <div class="col-xs-3 col-md-2 col-md-offset-2 m-b-5">
                    <div class="form-group">
                        <div class="form-line m-l-15">
                            <label>Código do Cliente</label>
                            <input type="number" class="form-control" ng-model="cliente" string-to-number min="1">
                        </div>
                    </div>
                </div>
                <div class="col-xs-9 col-md-4 m-b-10">
                    <label>Cliente</label>
                    <select class="form-control ms sel" name="cliente" ng-model="cliente">
                        <?php if ($clientes): foreach ($clientes as $cliente): ?>
                            <option value="<?= $cliente->id; ?>"><?= $cliente->nome; ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
            </div>

            <div class="row m-t-15 clearfix">
                <div class="col-xs-4">
                    <label>Total</label>
                    <input type="number" name="valor_total" ng-model="total" ng-change="divide(parcela)" class="form-control" min="1" step="any" required>
                </div>
                <div class="col-xs-4">
                    <label>total de parcelas</label>
                    <input type="number" name="total_parcelas" ng-change="divide(parcela)" ng-model="parcela" class="form-control" min="1" required>
                </div>
                <div class="col-xs-4">
                    <label>vencimento</label>
                    <input type="date" name="vencimento" ng-model="vencimento" ng-change="divide(parcela)" class="form-control" required>
                </div>
            </div>

            <p class="h4">Detalhes das parcelas:</p>
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                <tr>
                    <th>Parcela</th>
                    <th>Valor</th>
                    <th>Vencimentos</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="(k, vezes) in parcelas">
                    <td>
                        {{ k + 1 }}
                    </td>
                    <td>
                        <input type="number" name="valor_parcelas[]" ng-model="vezes.valor" ng-change="tot(parcelas)" class="form-control" min="1" step="any" required>
                    </td>
                    <td>
                        <input type="date" name="vencimentos[]" ng-model="vezes.vencimento" class="form-control" required>
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="row m-t-15 clearfix">
                <div class="col-xs-12">
                    <h3>Total das parcelas: {{ conftotal }} - Total de parcelas: {{ parcelas.length }}</h3>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <a type="button" class="btn btn-primary" href="<?= base_url('financeiro') ?>"><i class="material-icons">reply</i>Cancelar</a>
            <button class="btn btn-success right"><i class="material-icons">save</i>Salvar</button>
        </div>
        <?= form_close(); ?>
    </div>
</section>