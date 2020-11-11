<div class="container-fluid">
    <h1><?= $titulo; ?></h1>

    <table class="table text-center table-responsive table-striped table-condensed">
        <thead>
        <tr>
            <th>atendimento</th>
            <th>cliente</th>
            <th>usuario</th>
            <th>data</th>
            <th>conteudo</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($dados): foreach ($dados as $dado): ?>
            <tr>
                <td><?= $dado->id; ?></td>
                <td><?= $dado->cliente; ?></td>
                <td><?= $dado->usuario; ?></td>
                <td><?= date('d/m/Y', strtotime($dado->data)); ?></td>
                <td><?= $dado->conteudo; ?></td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>

    <h6 class="text-right">Retirado em <?= date('d/m/Y h:i:s', strtotime(DatetimeNow())); ?> por <?= $this->session->userdata('auth')['nome']; ?></h6>
</div>