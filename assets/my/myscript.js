myapp = angular.module('APP', []);

header = {'Content-Type': 'application/x-www-form-urlencoded'};

myapp.controller('dashboard', function ($scope) {
    $(function () {
        $('.count-to').countTo();
    });

    $scope.iniciar = function (data) {
        new Chart(document.getElementById("chart").getContext('2d'), {
            type: 'line',
            data: {
                labels: data.dta,
                datasets: [{
                    label: 'Atendimentos',
                    data: data.qtd,
                    borderColor: 'rgba(0, 188, 212, 0.75)',
                    backgroundColor: 'rgba(0, 188, 212, 0.3)',
                    pointBorderColor: 'rgba(0, 188, 212, 0)',
                    pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
                    pointBorderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            stepSize: 1
                        }
                    }]
                }
            }
        });
    };
});

myapp.controller('controle', function ($scope, $http) {
    $scope.iniciar = function () {
        autosize($('textarea.auto-growth'));
    };

    $scope.editar = function (id) {
        $http({
            method: 'get',
            url: './grupos/' + id,
            headers: header
        }).then(function (retorno) {
            dados = retorno.data;
            $scope.id = id;
            $scope.nome = dados[0].nome;
            $scope.desc = dados[0].desc;
            if (dados['regras']) {
                dados['regras'].forEach(function (dados) {
                    $scope[dados.nome] = '1';
                });
            }
            if (dados['acoes']) {
                dados['acoes'].forEach(function (dados) {
                    $scope[dados['acesso']] = dados['regra'];
                });
            }
        });
    };

    $scope.remover = function (id) {
        $http({
            method: 'get',
            url: './grupos/' + id,
            headers: header
        }).then(function (retorno) {
            dados = retorno.data;
            $scope.id = id;
            $scope.nome = dados[0].nome;
            $scope.desc = dados[0].desc;
        });
    };
});

myapp.controller('usuario', function ($scope, $http) {
    $scope.editar = function (id) {
        $http({
            method: 'get',
            url: './usuarios/' + id,
            headers: header
        }).then(function (retorno) {
            dados = retorno.data;
            $scope.id = id;
            $scope.nome = dados.nome;
            $scope.email = dados.email;
            $scope.usuario = dados.usuario;
            $scope.grupo = dados.grupo;
        });
    };

    $scope.remover = function (id) {
        $http({
            method: 'get',
            url: './usuarios/' + id,
            headers: header
        }).then(function (retorno) {
            dados = retorno.data;
            $scope.id = id;
            $scope.nome = dados.nome;
        });
    };

    $scope.ativar = function (id) {
        $http({
            method: 'get',
            url: './usuarios/' + id,
            headers: header
        }).then(function (retorno) {
            dados = retorno.data;
            $scope.id = id;
            $scope.nome = dados.nome;
            if (dados.status == 0) {
                $scope.titulo = 'Ativar';
            } else {
                $scope.titulo = 'Desativar';
            }
            $scope.status = (dados.status == 0 ? 1 : 0);
        });
    };
});

myapp.controller('cliente', function ($scope, $http) {
    $scope.iniciar = function () {
        $(document).ready(function () {
            $('.sel').select2({ dropdownParent: $("#relatorio") });

            $('#table').dataTable({
                responsive: true,
                paging: true,
                lengthChange: true,
                info: false,
                autoWidth: true,
                language: {
                    'lengthMenu': 'mostrar _MENU_ itens',
                    'search': 'buscar',
                    'zeroRecords': '0',
                    'paginate': {
                        'first': '<<',
                        'last': '>>',
                        'previous': 'Anterior',
                        'next': 'Próximo'
                    }
                }
            });

            $('.fone').inputmask('(99) [9] 9999-9999', {placeholder: '(__) _ ____-____'});
            $('.cpf').inputmask('999.999.999-99', {placeholder: '___.___.___-__'});
            $('.rg').inputmask('99.999.999-*', {placeholder: '__.___.___-_'});
            $('.cnpj').inputmask('99.999.999/9999-99', {placeholder: '__.___.___/____-__'});
        });
    };

    $scope.mask = function () {
        $('.fone').inputmask('(99) [9] 9999-9999', {placeholder: '(__) _ ____-____'});
        $('.cpf').inputmask('999.999.999-99', {placeholder: '___.___.___-__'});
        $('.rg').inputmask('99.999.999-*', {placeholder: '__.___.___-_'});
        $('.cnpj').inputmask('99.999.999/9999-99', {placeholder: '__.___.___/____-__'});
    };

    $scope.editar = function (id) {
        $http({
            method: 'get',
            url: './clientes/' + id,
            headers: header
        }).then(function (retorno) {
            dados = retorno.data;
            dados.nascimento = new Date(dados.nascimento);
            $scope.char = dados;
        });
    };

    $scope.remover = function (id) {
        $http({
            method: 'get',
            url: './clientes/' + id,
            headers: header
        }).then(function (retorno) {
            dados = retorno.data;
            $scope.id = id;
            $scope.nome = dados.nome;
        });
    };

    $scope.ativar = function (id) {
        $http({
            method: 'get',
            url: './clientes/' + id,
            headers: header
        }).then(function (retorno) {
            dados = retorno.data;
            $scope.id = id;
            $scope.nome = dados.nome;
            if (dados.status == 0) {
                $scope.titulo = 'Ativar';
            } else {
                $scope.titulo = 'Desativar';
            }
            $scope.status = (dados.status == 0 ? 1 : 0);
        });
    };
});

myapp.controller('produto', function ($scope, $http) {
    $scope.teste = function () {
        $scope.tipo = 0;
    };

    $scope.iniciar = function () {
        $(document).ready(function () {
            $('.sel').select2({ dropdownParent: $("#relatorio") });

            $('#table').dataTable({
                responsive: true,
                paging: true,
                lengthChange: true,
                info: false,
                autoWidth: true,
                language: {
                    'lengthMenu': 'mostrar _MENU_ itens',
                    'search': 'buscar',
                    'zeroRecords': '0',
                    'paginate': {
                        'first': '<<',
                        'last': '>>',
                        'previous': 'Anterior',
                        'next': 'Próximo'
                    }
                }
            });
        });
    };

    $scope.editar = function (id) {
        $http({
            method: 'get',
            url: './produtos/' + id,
            headers: header
        }).then(function (retorno) {
            dados = retorno.data;
            $scope.id = id;
            $scope.nome = dados.nome;
            $scope.quantidade = parseInt(dados.quantidade);
            $scope.comentario = dados.comentario;
            $scope.altura = parseFloat(dados.altura);
            $scope.largura = parseFloat(dados.largura);
            $scope.comprimento = parseFloat(dados.comprimento);
            $scope.preco = parseFloat(dados.preco);
            $scope.tipo = dados.tipo;
        });
    };

    $scope.zerar = function (id) {
        $http({
            method: 'get',
            url: './produtos/' + id,
            headers: header
        }).then(function (retorno) {
            dados = retorno.data;
            $scope.id = id;
            $scope.nome = dados.nome;
        });
    };
});

myapp.controller('pedido', function ($scope, $http) {
    $scope.iniciar = function () {
        $(document).ready(function () {
            $('.sel').select2({ dropdownParent: $("#relatorio") });

            $('.dataTable').dataTable({
                responsive: true,
                paging: true,
                lengthChange: true,
                info: false,
                autoWidth: true,
                language: {
                    'lengthMenu': 'mostrar _MENU_ itens',
                    'search': 'buscar',
                    'zeroRecords': '0',
                    'paginate': {
                        'first': '<<',
                        'last': '>>',
                        'previous': 'Anterior',
                        'next': 'Próximo'
                    }
                }
            });
        });
    };

    $scope.play = function (id) {
        $http({
            method: 'post',
            url: '/pedidos/iniciar',
            data: $.param({id: id}),
            headers: header
        }).then(function () {
            $('#bte' + id).remove();
            $('#btp' + id).remove();
        });
    };

    $scope.stop = function (id) {
        $http({
            method: 'post',
            url: '/pedidos/parar',
            data: $.param({id: id}),
            headers: header
        }).then(function () {
            $('#bts' + id).remove();
        });
    };

    $scope.cancel = function (id) {
        $http({
            method: 'post',
            url: '/pedidos/cancelar',
            data: $.param({id: id}),
            headers: header
        }).then(function () {
            $('#stt' + id).html('Cancelado');
            $('#bte' + id).remove();
            $('#btp' + id).remove();
            $('#bts' + id).remove();
            $('#btf' + id).remove();
            $('#btc' + id).remove();
        });
    };

    $scope.ver = function (id) {
        $http({
            method: 'get',
            url: '/pedidos/get/' + id,
            headers: header
        }).then(function (retorno) {
            dados = retorno.data;
            $scope.id = dados.id;
            $scope.pedido = dados.data_pedido;
            $scope.entrega = dados.data_entrega;
            $scope.finalizado = dados.data_finalizado;
            $scope.status = dados.status;
            $scope.cliente = dados.cliente.nome;
            $scope.preco = dados.preco;
            $scope.obs = dados.obs;
            $scope.produtos = dados.produtos;
        }, function (retorno) {
            $scope.id = null;
            $scope.pedido = null;
            $scope.entrega = null;
            $scope.finalizado = null;
            $scope.status = null;
            $scope.cliente = null;
            $scope.preco = null;
            $scope.obs = null;
            $scope.produtos = null;
        });
    };
});

myapp.controller('pinit', function ($scope) {
    $scope.iniciar = function () {
        $(document).ready(function () {
            $('.sel').select2();

            autosize($('textarea.auto-growth'));
        });
        $('#table').dataTable({
            responsive: true,
            paging: true,
            lengthChange: true,
            info: false,
            autoWidth: false,
            language: {
                'lengthMenu': 'mostrar _MENU_ itens',
                'search': 'buscar',
                'zeroRecords': 'Sem dados',
                'paginate': {
                    'first': '<<',
                    'last': '>>',
                    'previous': 'Anterior',
                    'next': 'Próximo'
                }
            },
            ajax: {
                "url": "../produtos/0",
                "dataSrc": ''
            },
            columns: [
                {"data": "id"},
                {"data": "nome"},
                {
                    'data': null,
                    'render': function (data, type, row) {
                        btn = "<button type='button' id='btn" + row.id + "' class='btn btn-success' onclick='angular.element(this).scope().adds(" + JSON.stringify(row) + ",this)'>" +
                            "<i class='material-icons'>add</i>Selecionar" +
                            "</button>";
                        bt = "<button type='button' id='bt" + row.id + "' class='btn btn-danger hidden' onclick='angular.element(this).scope().rem(" + JSON.stringify(row) + ",this)'>" +
                            "<i class='material-icons'>remove</i>Remover" +
                            "</button>";
                        return (btn + bt);
                    }
                }
            ]
        });

    };

    prod = [];

    $scope.adds = function (i, el) {
        i.altura = 1;
        i.comprimento = 1;
        i.largura = 1;
        i.preco = (i.preco) ? parseFloat(i.preco) : 0;
        i.quantidade = 1;
        prod.push(i);
        el.classList.add('hidden');
        $('#bt' + i.id).removeClass('hidden');
    };

    $scope.selecionar = function () {
        $scope.produtos = prod;
        total();
    };

    $scope.delet = function (id) {
        temp = null;
        if (prod.length > 1) {
            temp = prod.splice(id, 1);
        } else {
            temp = prod;
            prod = [];
        }
        $scope.produtos = prod;
        total();
        $('#btn' + temp[0].id).removeClass('hidden');
        $('#bt' + temp[0].id).addClass('hidden');
    };

    $scope.rem = function (id, el) {
        if (prod.length > 1) {
            prod.forEach(function (k, i) {
                if (k.id == id.id) {
                    temp = prod.splice(i, 1);
                }
            });
        }else {
            prod = [];
        }
        $scope.produtos = prod;
        total();
        $('#btn' + id.id).removeClass('hidden');
        el.classList.add('hidden');
    };

    $scope.soma = total;

    function total() {
        tot = 0;
        prod.forEach(function (el) {
            switch (el.tipo) {
                case '1' :
                    tot += (el.preco * el.quantidade);
                    break;
                case '2' :
                    tot += (el.preco * ( el.altura * el.largura));
                    break;
                case '3' :
                    tot += (el.preco * el.comprimento);
                    break;
            }
        });
        $scope.ptotal = tot.toFixed(2);
    }
});

myapp.controller('pedit', function ($scope, $http) {
    prod = [];

    $scope.iniciar = function (id) {
        $(document).ready(function () {
            $('.sel').select2();

            autosize($('textarea.auto-growth'));
        });

        $('#table').dataTable({
            responsive: true,
            paging: true,
            lengthChange: true,
            info: false,
            autoWidth: false,
            language: {
                'lengthMenu': 'mostrar _MENU_ itens',
                'search': 'buscar',
                'zeroRecords': 'Sem dados',
                'paginate': {
                    'first': '<<',
                    'last': '>>',
                    'previous': 'Anterior',
                    'next': 'Próximo'
                }
            },
            ajax: {
                "url": "../../produtos/0",
                "dataSrc": ''
            },
            columns: [
                {"data": "id"},
                {"data": "nome"},
                {
                    'data': null,
                    'render': function (data, type, row) {
                        btn = "<button type='button' id='btn" + row.id + "' class='btn btn-success' onclick='angular.element(this).scope().adds(" + JSON.stringify(row) + ",this)'>" +
                            "<i class='material-icons'>add</i>Selecionar" +
                            "</button>";
                        bt = "<button type='button' id='bt" + row.id + "' class='btn btn-danger hidden' onclick='angular.element(this).scope().rem(" + JSON.stringify(row) + ",this)'>" +
                            "<i class='material-icons'>remove</i>Remover" +
                            "</button>";
                        return (btn + bt);
                    }
                }
            ]
        });

        $http({
            method: 'get',
            url: '../' + id,
            headers: header
        }).then(function (retorno) {
            dados = retorno.data;
            $.each(dados, function (k, i) {
                i.altura = (i.altura) ? parseFloat(i.altura) : 0;
                i.comprimento = (i.comprimento) ? parseFloat(i.comprimento) : 0;
                i.largura = (i.largura) ? parseFloat(i.largura) : 0;
                i.preco = (i.preco) ? parseFloat(i.preco) : 0;
                i.quantidade = (i.quantidade) ? parseInt(i.quantidade) : 0;
                $('#btn' + i.produto).addClass('hidden');
                $('#bt' + i.produto).removeClass('hidden');
            });
            prod = dados;
            $scope.produtos = prod;
            total();
        });
    };

    $scope.adds = function (i, el) {
        i.altura = 1;
        i.comprimento = 1;
        i.largura = 1;
        i.preco = (i.preco) ? parseFloat(i.preco) : 0;
        i.quantidade = 1;
        prod.push(i);
        el.classList.add('hidden');
        $('#bt' + i.id).removeClass('hidden');
    };

    $scope.selecionar = function () {
        $scope.produtos = prod;
        total();
    };

    $scope.delet = function (id) {
        temp = null;
        if (prod.length > 1) {
            temp = prod.splice(id, 1);
        } else {
            temp = prod;
            prod = [];
        }
        $scope.produtos = prod;
        total();
        $('#btn' + temp[0].id).removeClass('hidden');
        $('#bt' + temp[0].id).addClass('hidden');
    };

    $scope.rem = function (id, el) {
        if (prod.length > 1) {
            prod.forEach(function (k, i) {
                if (k.id == id.id) {
                    temp = prod.splice(i, 1);
                }
            });
        }else {
            prod = [];
        }
        $scope.produtos = prod;
        total();
        $('#btn' + id.id).removeClass('hidden');
        el.classList.add('hidden');
    };

    $scope.soma = total;

    function total() {
        tot = 0;
        prod.forEach(function (el) {
            switch (el.tipo) {
                case '1' :
                    tot += (el.preco * el.quantidade);
                    break;
                case '2' :
                    tot += (el.preco * ( el.altura * el.largura));
                    break;
                case '3' :
                    tot += (el.preco * el.comprimento);
                    break;
            }
        });
        $scope.ptotal = tot.toFixed(2);
    }
});

myapp.controller('atendimento', function ($scope) {
    $scope.iniciar = function () {
        $(document).ready(function () {
            $('.sel').select2({ dropdownParent: $("#relatorio") });

            $('#table').dataTable({
                order: [0, 'desc'],
                responsive: true,
                paging: true,
                lengthChange: true,
                info: false,
                autoWidth: true,
                language: {
                    'lengthMenu': 'mostrar _MENU_ itens',
                    'search': 'buscar',
                    'zeroRecords': '0',
                    'paginate': {
                        'first': '<<',
                        'last': '>>',
                        'previous': 'Anterior',
                        'next': 'Próximo'
                    }
                }
            });
        });
    };

    $scope.ver = function (dados) {
        $scope.id = dados.id;
        $scope.cliente = dados.cliente;
        $scope.usuario = dados.usuario;
        $scope.detalhes = dados.conteudo;
        $scope.data = dados.data;
    };
});

myapp.controller('ainit', function ($scope, $http) {
    $scope.iniciar = function () {
        $(document).ready(function () {
            autosize($('textarea.auto-growth'));
        });

    };

    $scope.ver = function (id) {
        if (id > 0) {
            $http({
                method: 'get',
                url: './new/' + id,
                headers: header
            }).then(function (retorno) {
                dados = retorno.data;
                $scope.historicos = dados;
            }, function () {
                $scope.historicos = null;
            });
        }
    };
});

myapp.controller('contas', function ($scope, $http) {
    $scope.iniciar = function () {
        $(document).ready(function () {
            $('.sel').select2({ dropdownParent: $("#relatorio") });

            $('.dataTable').dataTable({
                responsive: true,
                paging: true,
                lengthChange: true,
                info: false,
                autoWidth: true,
                language: {
                    'lengthMenu': 'mostrar _MENU_ itens',
                    'search': 'buscar',
                    'zeroRecords': '0',
                    'paginate': {
                        'first': '<<',
                        'last': '>>',
                        'previous': 'Anterior',
                        'next': 'Próximo'
                    }
                }
            });
        });
    };

    $scope.localiza = function (titulo, parcela) {
        if (titulo > 0 && parcela > 0) {
            $http({
                method: 'get',
                url: '../financeiro/' + titulo,
                params: {parcela: parcela},
                headers: header
            }).then(function (retorno) {
                dados = retorno.data;
                $scope.esclusiva = dados;
            }, function () {
                $scope.esclusiva = null;
            });
        }
    };

    $scope.ver = function (dados) {
        $scope.id = dados.id;
        $scope.cliente = dados.cliente;
        $scope.usuario = dados.usuario;
        $scope.detalhes = dados.conteudo;
        $scope.data = dados.data;
    };
});

myapp.controller('cinit', function ($scope, $http) {
    function divide(parc) {
        retorno = [];
        for (i = 0; i < parc; i++) {
            dt = new Date($scope.vencimento);
            dt.setMonth(dt.getMonth() + i);
            retorno.push({valor: parseFloat(($scope.total / parc).toFixed(2)), vencimento: dt});
        }
        $scope.parcelas = retorno;
        tot(retorno);
    };

    function tot(valores) {
        tott = 0;
        if (valores) {
            tott = 0;
            valores.forEach(function (el) {
                tott += el.valor;
            });
        }
        $scope.conftotal = tott.toFixed(2);
    };

    $scope.tot = tot;
    $scope.divide = divide;

    $scope.ver = ver;

    function ver (id) {
        if (id > 0) {
            $http({
                method: 'get',
                url: '../pedidos/get/' + id,
                headers: header
            }).then(function (retorno) {
                dados = retorno.data;
                $scope.total = parseInt(dados.preco);
                $scope.parcela = 1;
                $scope.vencimento = new Date();
                $scope.cliente = dados.cliente.id;
                divide(1);
            }, function () {
                $scope.total = 0;
                $scope.parcela = 1;
                $scope.vencimento = new Date();
                $scope.cliente = null;
                divide(1);
            });
        }
    };

    $scope.seta = function (val) {
        if (val) {
            $scope.pedido = val;
            $scope.tipos = '1';
            $scope.motivos = '3';
            ver(val);
        }
    }
});

myapp.directive('ckEditor', function () {
    return {
        require: '?ngModel',
        link: function (scope, elm, attr, ngModel) {
            var ck = CKEDITOR.replace(elm[0]);

            if (!ngModel) return;

            ck.on('pasteState', function () {
                scope.$apply(function () {
                    ngModel.$setViewValue(ck.getData());
                });
            });

            ngModel.$render = function (value) {
                ck.setData(ngModel.$viewValue);
            };
        }
    };
});

myapp.directive('stringToNumber', function () {
    return {
        require: 'ngModel',
        link: function (scope, element, attrs, ngModel) {
            ngModel.$parsers.push(function (value) {
                return '' + value;
            });
            ngModel.$formatters.push(function (value) {
                return parseFloat(value);
            });
        }
    };
});