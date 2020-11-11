<div class="container-fluid">
    <h1><?= $titulo; ?></h1>

    <table class="table table-responsive table-striped table-condensed">
        <thead>
        <tr>
            <th>pedido</th>
            <th>cliente</th>
            <th>preco</th>
            <th>pedido</th>
            <th>entrega</th>
            <th>finalizado</th>
            <th>status</th>
            <th>obs</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($dados): foreach ($dados as $dado): ?>
            <tr>
                <td><?= $dado->id; ?></td>
                <td><?= $dado->cliente; ?></td>
                <td><?= 'R$:' . $dado->preco; ?></td>
                <td><?= ($dado->data_pedido) ? date('d/m/Y', strtotime($dado->data_pedido)) : null; ?></td>
                <td><?= ($dado->data_entrega) ? date('d/m/Y', strtotime($dado->data_entrega)) : null; ?></td>
                <td><?= ($dado->data_finalizado) ? date('d/m/Y', strtotime($dado->data_finalizado)) : null; ?></td>
                <td><?= $dado->status; ?></td>
                <td><?= $dado->obs; ?></td>
            </tr>
            <?php if (isset($dado->produtos)): ?>
                <tr class="bold">
                    <th colspan="2">produto</th>
                    <th>altura</th>
                    <th>largura</th>
                    <th>comprimento</th>
                    <th>quantidade</th>
                    <th colspan="2"></th>
                </tr>
                <?php foreach ($dado->produtos as $produto): ?>
                <tr>
                    <td colspan="2"><?= $produto['produto']; ?></td>
                    <td><?= $produto['altura']; ?></td>
                    <td><?= $produto['largura']; ?></td>
                    <td><?= $produto['comprimento']; ?></td>
                    <td><?= $produto['quantidade']; ?></td>
                    <td colspan="2"></td>
                </tr>
            <?php endforeach; ?>
                <tr>
                    <th>pedido</th>
                    <th>cliente</th>
                    <th>preco</th>
                    <th>pedido</th>
                    <th>entrega</th>
                    <th>finalizado</th>
                    <th>status</th>
                    <th>obs</th>
                </tr>
            <?php endif; ?>
        <?php endforeach; endif; ?>
        </tbody>
        <tfoot>
        <tr class="bg-grey">
            <td colspan="2">Total</td>
            <td class="<?= ($preco > 0) ? 'bg-green' : 'bg-red'; ?>"><?= $preco; ?></td>
            <td colspan="5"></td>
        </tr>
        </tfoot>
    </table>

    <h6 class="text-right">Retirado em <?= date('d/m/Y h:i:s', strtotime(DatetimeNow())); ?> por <?= $this->session->userdata('auth')['nome']; ?></h6>
</div>