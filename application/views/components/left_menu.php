<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- Menu -->
        <div class="menu">
            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto;">
                <ul class="list" style="overflow: hidden; width: auto;">
                    <?php if ($left_menu): foreach ($left_menu as $menu): ?>
                        <li>
                            <a href="<?= base_url($menu->link); ?>" class="toggled waves-effect waves-block">
                                <i class="material-icons"><?= $menu->icone ?></i>
                                <span class="text-capitalize"><?= $menu->nome ?></span>
                            </a>
                        </li>
                    <?php endforeach; endif; ?>
                </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                © 2018 <a href="javascript:void(0);">Domínio Global</a>.
            </div>
            <div class="version">
                <b>Version: </b> 1.0
            </div>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
</section>