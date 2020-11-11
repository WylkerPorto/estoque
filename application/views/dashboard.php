<section class="content" ng-controller="dashboard">
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD</h2>
        </div>

        <div class="row clearfix">
            <div class="col-lg-4 col-sm-6 col-xs-12 m-b-10">
                <div class="info-box bg-blue hover-expand-effect hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">wc</i>
                    </div>
                    <div class="content">
                        <div class="text">Clientes</div>
                        <div class="number count-to" data-from="0" data-to="<?= $valores['clientes']; ?>" data-speed="1000"></div>
                    </div>
                </div>
                <div class="m-t--30 bg-white text-right">
                    <a href="<?= base_url('clientes'); ?>">Mais<i class="material-icons va-bottom">play_circle_outline</i></a>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-xs-12 m-b-10">
                <div class="info-box bg-green hover-expand-effect hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">widgets</i>
                    </div>
                    <div class="content">
                        <div class="text">Produtos</div>
                        <div class="number count-to" data-from="0" data-to="<?= $valores['produtos']; ?>" data-speed="1000"></div>
                    </div>
                </div>
                <div class="m-t--30 bg-white text-right">
                    <a href="<?= base_url('produtos'); ?>">Mais<i class="material-icons va-bottom">play_circle_outline</i></a>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-xs-12 m-b-10">
                <div class="info-box bg-amber hover-expand-effect hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">ballot</i>
                    </div>
                    <div class="content">
                        <div class="text">Orçamentos 3 dias</div>
                        <div class="number count-to" data-from="0" data-to="<?= $valores['tres']; ?>" data-speed="1000"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-4 col-sm-6 col-xs-12 m-b-10">
                <div class="info-box bg-orange hover-expand-effect hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">ballot</i>
                    </div>
                    <div class="content">
                        <div class="text">Orçamentos 7 dias</div>
                        <div class="number count-to" data-from="0" data-to="<?= $valores['sete']; ?>" data-speed="1000"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-xs-12 m-b-10">
                <div class="info-box bg-red hover-expand-effect hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">ballot</i>
                    </div>
                    <div class="content">
                        <div class="text">Orçamentos expirados</div>
                        <div class="number count-to" data-from="0" data-to="<?= $valores['expirado']; ?>" data-speed="1000"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-xs-12 m-b-10">
                <div class="info-box bg-green hover-expand-effect hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">devices_other</i>
                    </div>
                    <div class="content">
                        <div class="text">Pedidos</div>
                        <div class="number count-to" data-from="0" data-to="<?= $valores['pedidos']; ?>" data-speed="1000"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix" ng-init='iniciar(<?= json_encode($valores['grafico']); ?>)'>
            <div class="card">
                <div class="header">
                    <h2>Atendimentos</h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="<?= base_url('atendimentos'); ?>">Mais<i class="material-icons va-bottom">play_circle_outline</i></a>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <canvas id="chart" height="370" width="740" style="display: block; width: 740px; height: 370px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>