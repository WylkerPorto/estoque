<div class="container-fluid">
    <h1><?= $titulo; ?></h1>

    <table class="table text-center table-responsive table-striped table-condensed">
        <thead>
        <tr>
            <th>registro</th>
            <th>nome</th>
            <th>tipo</th>
            <th>nascimento</th>
            <th>cnpj</th>
            <th>ie</th>
            <th>cpf</th>
            <th>rg</th>
            <th>telefone</th>
            <th>telefone</th>
            <th>email</th>
            <th>cep</th>
            <th>endereço</th>
            <th>status</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($dados): foreach ($dados as $dado): ?>
            <tr>
                <td><?= $dado->id; ?></td>
                <td><?= $dado->nome; ?></td>
                <td><?= $dado->tipo; ?></td>
                <td><?= date('d/m/Y', strtotime($dado->nascimento)); ?></td>
                <td><?= ($dado->cnpj) ? $dado->cnpj : null; ?></td>
                <td><?= ($dado->ie) ? $dado->ie : null; ?></td>
                <td><?= ($dado->cpf) ? $dado->cpf: null; ?></td>
                <td><?= ($dado->rg) ? $dado->rg : null; ?></td>
                <td><?= ($dado->telefone) ? $dado->telefone : null; ?></td>
                <td><?= ($dado->telefone2) ? $dado->telefone2 : null; ?></td>
                <td><?= ($dado->email) ? $dado->email : null; ?></td>
                <td><?= ($dado->cep) ? $dado->cep : null; ?></td>
                <td><?= ($dado->endereco) ? $dado->endereco : null; ?></td>
                <td><?= ($dado->status) ? 'ativo' : 'inativo'; ?></td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>

    <h6 class="text-right">Retirado em <?= date('d/m/Y h:i:s', strtotime(DatetimeNow())); ?> por <?= $this->session->userdata('auth')['nome']; ?></h6>
</div>