<?php $render("commerce/header_painel", ['title'=>'Painel administrativo | Entenda o valor a receber']); ?>


<div class="content-wrapper" style="min-height: 1184.92px;">

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Valor dos juros referente a cada transacão</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <p>
                                        Em nossa plataforma usamos a operadora <a target="_blank" href="https://gerencianet.com.br/">Gerencianet</a> para fazer
                                        gerar as transações de cartão de crédito e boleto
                                    </p>
                                    <p>
                                        Para cada transação de cartão de crédito ou para cada boleto pago é cobrado uma
                                        taxa junto com uma porcentagem de juros, segue abaixo a tabela explicando:
                                    </p>
                                </div>
                            </div>
                            <br><br>
                            <div class="row">
                                <div class="col-12">
                                    <h3>Boleto</h3> <br>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td><b>Tarifa por boleto ou folha de carnê pagos</b></td>
                                                <td><b>$ 2,99</b></td>
                                            </tr>
                                            <tr>
                                                <td>Emissão e registro de boletos e carnês</td>
                                                <td>Grátis</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <br><br>
                            <div class="row">
                                <div class="col-12">
                                    <h3>Cartão de crédito</h3> <br>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Forma de Recebimento:</td>
                                                <td>À vista</td>
                                            </tr>
                                            <tr>
                                                <td>Disponibilização após confirmação do pagamento</td>
                                                <td>2 dias úteis</td>
                                            </tr>
                                            <tr>
                                                <td>Juros pago pelo cliente:(por parcela)</td>
                                                <td>1,99% a.m.</td>
                                            </tr>
                                            <tr>
                                                <td><b>Tarifa por recebimento no cartão de crédito:</b></td>
                                                <td><b>R$ 0,29 + 4,99%</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> <br><br>

                            <div class="row">
                                <div class="col-12">
                                    <h3>Outras tarifas e prazos</h3> <br>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Transferência com valores acima de R$ 300,00 para conta de mesma titularidade</td>
                                                <td>Grátis</td>
                                            </tr>
                                            <tr>
                                                <td>Transferência com valores abaixo de R$ 300,00 para conta de mesma titularidade</td>
                                                <td>R$ 5,00 por transferência</td>
                                            </tr>
                                            <tr>
                                                <td>Transferências de qualquer valor para contas de terceiros</td>
                                                <td>R$ 5,00 por transferência</td>
                                            </tr>
                                            <tr>
                                                <td>Transferências entre contas Gerencianet</td>
                                                <td>Grátis</td>
                                            </tr>
                                            <tr>
                                                <td>Prazo para transferência</td>
                                                <td>Até 3 dias úteis</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div> <br><br>

                            <div class="row">
                                <div class="col-12">
                                    <p>
                                        Então de acordo com essa tabela disponibilizada pela Gerencianet, é o valor que aparece calculado
                                        em seu painel de controle.
                                    </p>
                                    <p>
                                        Considere tambem o valor de "Outras tarifas e prazos", pois para que nós possamos transferir o dinheiro
                                        é cobrado um valor de R$5,00 para qualquer conta de terceiros.
                                    </p>
                                    <p>
                                        Futuramente iremos trocar a operadora com para que essas taxas possam ser menores.
                                    </p>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <br><br>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $render("commerce/footer_painel"); ?>

<script>
    $('#tran').click(function () {
        id = $('#idcompra').val();
        $.confirm({
            title: 'Marcar como transferido?',
            content: '',
            type: 'orange',
            buttons: {
                deleteUser: {
                    text: 'SIM',
                    action: function () {
                        $.ajax({
                            url: '/transferir/compra',
                            type: 'POST',
                            dataType: 'JSON',
                            data: {
                                tran: 1,
                                id: id,
                                idEco: '<?php echo $venda['
                                ecommerce_id ']; ?>',
                                valor: '<?php echo '
                                R$ '.number_format($venda['
                                total_compra '], 2, ',
                                ','.
                                ');?>'
                            },
                            success: function (r) {
                                if (r.ret == true) {
                                    $('#transferido').html('SIM');
                                    $.alert('Transferido!');
                                } else {
                                    $.alert('Ocorreu erro interno ao transferir!');
                                }
                            }
                        })
                    }
                },
                cancelar: {
                    btnClass: 'btn-red any-other-class', // multiple classes.
                },
            }
        });
    });

    $('#ntran').click(function () {
        id = $('#idcompra').val();
        $.confirm({
            title: 'Marcar como não transferido?',
            content: '',
            type: 'orange',
            buttons: {
                deleteUser: {
                    text: 'SIM',
                    action: function () {
                        $.ajax({
                            url: '/transferir/compra',
                            type: 'POST',
                            dataType: 'JSON',
                            data: {
                                tran: 0,
                                id: id
                            },
                            success: function (r) {
                                if (r.ret == true) {
                                    $('#transferido').html('NÃO');
                                    $.alert('Marcado como Não Transferido!');
                                } else {
                                    $.alert('Ocorreu erro interno ao transferir!');
                                }
                            }
                        })
                    }
                },
                cancelar: {
                    btnClass: 'btn-red any-other-class', // multiple classes.
                },
            }
        });
    });
</script>