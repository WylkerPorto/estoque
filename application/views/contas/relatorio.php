<div class="container-fluid">
    <h1><?= $titulo; ?></h1>

    <table class="table text-center table-responsive table-striped table-condensed">
        <thead>
        <tr>
            <th>titulo</th>
            <th>cliente</th>
            <th>pedido</th>
            <th>parcela</th>
            <th>valor da parcela</th>
            <th>valor total</th>
            <th>vencimento</th>
            <th>pagamento</th>
            <th>juros</th>
            <th>desconto</th>
            <th>multa</th>
            <th>pago</th>
            <th>tipo</th>
            <th>categoria</th>
            <th>status</th>
            <th>usuario</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($dados): foreach ($dados as $dado): ?>
            <tr>
                <td><?= $dado->id; ?></td>
                <td><?= $dado->cliente; ?></td>
                <td><?= $dado->pedido; ?></td>
                <td><?= $dado->parcela . '/' . $dado->total_parcelas; ?></td>
                <td><?= ($dado->valor_parcela) ? 'R$:' . $dado->valor_parcela : null; ?></td>
                <td><?= ($dado->valor_total) ? 'R$:' . $dado->valor_total : null; ?></td>
                <td><?= ($dado->vencimento) ? date('d/m/Y', strtotime($dado->vencimento)) : null; ?></td>
                <td><?= ($dado->pagamento) ? 'R$:' . $dado->pagamento : null; ?></td>
                <td><?= ($dado->juros) ? 'R$:' . $dado->juros : null; ?></td>
                <td><?= ($dado->desconto) ? 'R$:' . $dado->desconto : null; ?></td>
                <td><?= ($dado->multa) ? 'R$:' . $dado->multa : null; ?></td>
                <td><?= ($dado->data_pagamento) ? date('d/m/Y', strtotime($dado->data_pagamento)) : null; ?></td>
                <td><?= $dado->motivo; ?></td>
                <td><?= $dado->tipo; ?></td>
                <td><?= ($dado->status) ? 'pago' : 'aberto'; ?></td>
                <td><?= $dado->usuario; ?></td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
        <tfoot>
        <tr class="bg-grey">
            <td colspan="4">Totais</td>
            <td class="<?= ($valores['parcela'] > 0) ? 'bg-green' : 'bg-red'; ?>"><?= $valores['parcela']; ?></td>
            <td class="<?= ($valores['total'] > 0) ? 'bg-green' : 'bg-red'; ?>"><?= $valores['total']; ?></td>
            <td></td>
            <td class="<?= ($valores['pago'] > 0) ? 'bg-green' : 'bg-red'; ?>"><?= $valores['pago']; ?></td>
            <td class="<?= ($valores['juros'] > 0) ? 'bg-green' : 'bg-red'; ?>"><?= $valores['juros']; ?></td>
            <td class="<?= ($valores['desconto'] > 0) ? 'bg-green' : 'bg-red'; ?>"><?= $valores['desconto']; ?></td>
            <td class="<?= ($valores['multa'] > 0) ? 'bg-green' : 'bg-red'; ?>"><?= $valores['multa']; ?></td>
            <td colspan="5"></td>
        </tr>
        </tfoot>
    </table>

    <h6 class="text-right">Retirado em <?= date('d/m/Y h:i:s', strtotime(DatetimeNow())); ?> por <?= $this->session->userdata('auth')['nome']; ?></h6>
</div>