<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars" style="display: none;"></a>
            <a class="navbar-brand p-t-0" href="<?= base_url('dashboard'); ?>" style="max-width: 250px;">
                <img src="<?= base_url('assets/imgs/logo.png'); ?>" alt="logo" class="img-responsive">
            </a>
        </div>
        <div class="navbar-collapse collapse" id="navbar-collapse" aria-expanded="false" style="height: 1px;">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?= base_url('perfil'); ?>"><i class="material-icons">person</i></a></li>
                <li><a href="<?= base_url('logout'); ?>"><i class="material-icons">input</i></a></li>
            </ul>
        </div>
    </div>
</nav>