<div class="container-fluid">
    <h1><?= $titulo; ?></h1>

    <table class="table text-center table-responsive table-striped table-condensed">
        <thead>
        <tr>
            <th>código</th>
            <th>tipo</th>
            <th>produto</th>
            <th>quantidade</th>
            <th>altura</th>
            <th>largura</th>
            <th>comprimento</th>
            <th>preco</th>
            <th>comentario</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($dados): foreach ($dados as $dado): ?>
            <tr>
                <td><?= $dado->id; ?></td>
                <td><?= ($dado->tipo == 1) ? 'Unítario' : (($dado->tipo == 2) ? 'Quadrado' : 'Linear') ; ?></td>
                <td><?= $dado->nome; ?></td>
                <td><?= ($dado->quantidade > 1) ? $dado->quantidade : null; ?></td>
                <td><?= ($dado->altura) ? $dado->altura . 'm': null; ?></td>
                <td><?= ($dado->largura) ? $dado->largura . 'm': null; ?></td>
                <td><?= ($dado->comprimento) ? $dado->comprimento . 'm': null; ?></td>
                <td><?= ($dado->preco) ? 'R$:' . $dado->preco : null; ?></td>
                <td><?= $dado->comentario; ?></td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>

    <h6 class="text-right">Retirado em <?= date('d/m/Y h:i:s', strtotime(DatetimeNow())); ?> por <?= $this->session->userdata('auth')['nome']; ?></h6>
</div>