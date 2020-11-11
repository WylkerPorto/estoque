<section class="content">
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
            <span>Faturamento de titulo</span>
        </div>
        <div class="panel-body">
            <div class="row clearfix">
                <div class="col-xs-6 col-md-3">
                    <label>Tipo</label>
                    <?php if ($tipos): foreach ($tipos as $tipo): ?>
                        <span><?= ($tipo->id == $dado->tipo) ? $tipo->nome : null; ?></span>
                    <?php endforeach; endif; ?>
                </div>
                <div class="col-xs-6 col-md-3">
                    <label>Motivo</label>
                    <?php if ($motivos): foreach ($motivos as $motivo): ?>
                        <span><?= ($motivo->id == $dado->motivo) ? $motivo->nome : null; ?></span>
                    <?php endforeach; endif; ?>
                </div>

                <div class="col-xs-6 col-md-3">
                    <label>Cliente</label>
                    <?php if ($clientes): foreach ($clientes as $cliente): ?>
                        <span><?= ($cliente->id == $dado->cliente) ? $cliente->nome : null; ?></span>
                    <?php endforeach; endif; ?>
                </div>
                <div class="col-xs-6 col-md-3">
                    <label>Pedido</label>
                    <span type="number"><?= $dado->pedido; ?></span>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-xs-6 col-md-3">
                    <label>Valor da parcela</label>
                    <span><?= $dado->valor_parcela; ?></span>
                </div>

                <div class="col-xs-6 col-md-3">
                    <label>Valor do título</label>
                    <span><?= $dado->valor_total; ?></span>
                </div>

                <div class="col-xs-6 col-md-3">
                    <label>Parcela</label>
                    <span><?= $dado->parcela; ?></span>
                    <label>de</label>
                    <span><?= $dado->total_parcelas; ?></span>
                </div>

                <div class="col-xs-6 col-md-3">
                    <label>Vencimento</label>
                    <span><?= date('d/m/Y', strtotime($dado->vencimento)); ?></span>
                </div>
            </div>
            <?= form_open(); ?>
            <div class="row m-t-15 clearfix">
                <div class="col-xs-6 col-sm-3">
                    <label>Pagamento</label>
                    <input type="number" name="pagamento" ng-model="pagamento" ng-value="<?= $dado->valor_parcela; ?> - desconto + juros + multa" class="form-control" min="1" step="any" required>
                </div>
                <div class="col-xs-6 col-sm-3">
                    <label>Desconto</label>
                    <input type="number" name="desconto" ng-model="desconto" class="form-control">
                </div>
                <div class="col-xs-6 col-sm-3">
                    <label>Juros</label>
                    <input type="number" name="juros" ng-model="juros" class="form-control">
                </div>
                <div class="col-xs-6 col-sm-3">
                    <label>Multa</label>
                    <input type="number" name="multa" ng-model="multa" class="form-control">
                </div>
            </div>
            <div class="row m-t-15 clearfix">
                <div class="col-xs-12">
                    <label>Observações</label>
                    <textarea name="obs" cols="30" rows="10" class="form-control no-resize"></textarea>
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