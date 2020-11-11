<div class="login-box">
        <div class="logo">
            <img src="<?= base_url('assets/imgs/logo-dg.png') ?>" alt="logo" class="img-responsive">
        </div>
        <div class="card">
            <div class="body">
                <div class="msg">Inicie sua sessão</div>
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
                <?= form_open('login', 'novalidate="novalidate"') ?>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line <?= ($this->session->flashdata('usuario')) ? 'error' : null; ?>"">
                            <input type="text" class="form-control" name="usuario" placeholder="Usuário" required autofocus>
                        </div>
                        <?php if ($msg = $this->session->flashdata('usuario')): ?>
                            <small class="col-red"><?= $msg; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line <?= ($this->session->flashdata('senha')) ? 'error' : null; ?>">
                            <input type="password" class="form-control" name="senha" placeholder="Senha" required>
                        </div>
                        <?php if ($msg = $this->session->flashdata('senha')): ?>
                            <small class="col-red"><?= $msg; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button class="btn btn-block bg-green waves-effect" type="submit">Entrar</button>
                        </div>
                    </div>
                <?= form_close(); ?>
            </div>
        </div>
    <div class="logo">
        <small class="col-black">Domínio Global <strong>&copy; 2018</strong></small>
    </div>
    </div>
