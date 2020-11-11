<section class="content" ng-controller="usuario">
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
            <span>Edição de perfil</span>
        </div>
        <?= form_open(); ?>
        <div class="panel-body">
            <div class="form-group">
                <div class="form-line">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control" value="<?= $perfil->nome; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <div class="form-line">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $perfil->email; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <div class="form-line">
                    <label>Usuário</label>
                    <input type="text" name="usuario" class="form-control" value="<?= $perfil->usuario; ?>" readonly>
                </div>
            </div>

            <div class="form-group">
                <div class="form-line">
                    <label>Senha</label>
                    <input type="password" name="senha" class="form-control">
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