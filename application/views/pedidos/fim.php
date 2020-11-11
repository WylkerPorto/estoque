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
            <span>Finalização de pedido</span>
        </div>
        <?= form_open('pedidos/finish'); ?>
        <input type="hidden" name="id" class="hidden" value="<?= $pedido->id; ?>" readonly hidden>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label>Data do pedido</label>
                        <?= date('d/m/Y', strtotime($pedido->data_pedido)); ?>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label>Data de entrega</label>
                        <?= date('d/m/Y', strtotime($pedido->data_entrega)); ?>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label>Cliente</label>
                        <?php if ($clientes): foreach ($clientes as $cliente): ?>
                            <?= ($pedido->cliente == $cliente->id) ? $cliente->nome : null; ?>
                        <?php endforeach; endif; ?>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label>Preço</label> <?= $pedido->preco; ?>
                    </div>
                </div>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th>Cód</th>
                    <th>Item</th>
                    <th>Uso</th>
                    <th>Sobra</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="4" class="align-center">
                        <i class="material-icons media-middle">add</i>Quantidade |
                        <i class="material-icons media-middle">format_line_spacing</i>Altura |
                        <i class="material-icons media-middle">developer_mode</i>Largura |
                        <i class="material-icons media-middle">straighten</i>Comprimento
                    </td>
                </tr>
                <?php foreach ($producao as $k => $produto): ?>
                    <tr>
                        <td><input type="number" name="produto[<?= $k; ?>]" class="bootstrap-tagsinput" value="<?= $produto->produto->id; ?>" readonly>
                        <td><?= $produto->produto->nome; ?></td>
                        <td>
                            <?= ($produto->quantidade) ? '<i class="material-icons media-middle">add</i>' . $produto->quantidade : null; ?>
                            <?= ($produto->altura) ? '<i class="material-icons media-middle">format_line_spacing</i>' . $produto->altura : null; ?>
                            <?= ($produto->largura) ? '<i class="material-icons media-middle">developer_mode</i>' . $produto->largura : null; ?>
                            <?= ($produto->comprimento) ? '<i class="material-icons media-middle">straighten</i>' . $produto->comprimento : null; ?>
                        </td>
                        <td>
                            <div class="form-inline">
                                <?php if($produto->produto->tipo == 1): ?>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons media-middle">add</i>
                                    </span>
                                    <div class="form-line">
                                        <input type="number" name="quantidade[<?= $k; ?>]" class="form-control p-0 h-20" value="0" min="0" max="<?= $produto->quantidade; ?>">
                                    </div>
                                </div>
                                <?php elseif($produto->produto->tipo == 2): ?>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons media-middle">format_line_spacing</i>
                                    </span>
                                    <div class="form-line">
                                        <input type="number" name="altura[<?= $k; ?>]" class="form-control p-0 h-20" value="0" min="0" step="0.01" max="<?= $produto->altura; ?>">
                                    </div>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons media-middle">developer_mode</i>
                                    </span>
                                    <div class="form-line">
                                        <input type="number" name="largura[<?= $k; ?>]" class="form-control p-0 h-20" value="0" min="0" step="0.01" max="<?= $produto->largura; ?>">
                                    </div>
                                </div>
                                <?php elseif($produto->produto->tipo == 3): ?>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="material-icons media-middle">straighten</i>
                                    </span>
                                    <div class="form-line">
                                        <input type="number" name="comprimento[<?= $k; ?>]" class="form-control p-0 h-20" value="0" min="0" step="0.01" max="<?= $produto->comprimento; ?>">
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <div class="form-group">
                <div class="form-line">
                    <label>Observação</label>
                    <textarea name="obs" class="form-control auto-growth no-resize"><?= $pedido->obs; ?></textarea>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <a type="button" class="btn btn-primary" href="<?= base_url('pedidos') ?>"><i class="material-icons">reply</i>Cancelar</a>
            <button class="btn btn-success right"><i class="material-icons">save</i>Salvar</button>
        </div>
        <?= form_close(); ?>
    </div>
</section>