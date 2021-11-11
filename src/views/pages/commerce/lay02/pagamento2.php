<?php
if(!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0 || !isset($_SESSION['login_cliente_ecommerce'])){
    header("Location: /");

    //echo 'Entrei nesse if';exit;
}
if(isset($_SESSION['frete'])){
    $frete = str_replace(',','.',$_SESSION['frete']['preco']);
    $_SESSION['total'] = $_SESSION['subtotal'] + floatval($frete);
}else{
        $_SESSION['total'] = $_SESSION['subtotal'];
}
?>

<?php $render('commerce/lay02/header', ['title' => $dados['nome_fantasia'] . ' | Finalização da compra', 'layout' => $dados, 'carrinho' => $carrinho]); ?>

<section class="bg-img1 txt-center p-lr-15 p-tb-92"
    style="background-image: url('<?php echo BASE_ASS_C; ?>lay02/images/cardban.jpg');">
    <h2 class="ltext-105 cl0 txt-center">
        Finalização da compra 2/2
    </h2>
</section>
<br><br><br>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <center>
                <h1>Preencha os dados</h1>
            </center> <br><br><br>
        </div>

        <div class="col-md-4">
            <?php 
                if(isset($_SESSION['message'])){
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
            ?>

            <?php 
                require_once('fmr_gerencianet.php');
            ?>
            <button type="submit" class="flex-c-m stext-101 cl0 size-107 bgbutton bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10" id="finalizar" style="float: right;">Finalizar Compra</button> <br><br><br><br>

            <div id="loading"></div>
            <br><br>
        </div>

        <div class="col-md-1"></div>
        <div class="col-md-7">
            <h4>Produtos selecionados</h4><br>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Preço</th>
                            <th scope="col">Qtd</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  $_SESSION['subtotal'] = 0; ?>
                        <?php foreach($produtos as $p): ?>
                        <tr>
                            <td><a href="/visualizar/produto/<?php echo $p['0']; ?>"><?php echo $p['nome_pro']; ?></a>
                            </td>
                            <td><?php echo 'R$ '. number_format($p['preco'],2,',','.'); ?></td>
                            <td><?php echo $_SESSION['carrinho'][$p[0]]; ?></td>
                        </tr>

                        <?php 
                            $_SESSION['subtotal'] += floatval($p['preco']) * $_SESSION['carrinho'][$p[0]];
                        ?>

                        <?php endforeach; ?>

                        <tr>
                            <td colspan="3" style="text-align:right"><b>SUBTOTAL: <div id="subtot"
                                        style="display:inline;">
                                        <?php echo 'R$ '. number_format( $_SESSION['subtotal'],2,',','.'); ?></div></b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:right"><b>FRETE: <div id="calcfrete"
                                        style="display:inline;">
                                        <?php echo(isset($_SESSION['frete'])?'R$ '.$_SESSION['frete']['preco'].' Prazo: '.$_SESSION['frete']['data'].' dia(s) para o CEP: '.$_SESSION['frete']['cep']:'R$ 0,00') ?>
                                    </div></b></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:right"><b>TOTAL: <div id="totalfinal"
                                        style="display:inline;">
                                        <?php echo 'R$ '. number_format( $_SESSION['total'],2,',','.'); ?></div></b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p><b>Dados para a entrega:</b></p>
            <p>
                <b>Rua:</b>
                <?php echo $_SESSION['dados_entrega']['rua'].' - <b>N°: </b>'.$_SESSION['dados_entrega']['numero']; ?></br>
                <b>Bairro:</b> <?php echo $_SESSION['dados_entrega']['bairro']; ?></br>
                <b>CEP:</b> <?php echo $_SESSION['dados_entrega']['cep']; ?></br>
                <b>Cidade:</b>
                <?php echo $_SESSION['dados_entrega']['cidade'].' - '.$_SESSION['dados_entrega']['estado']; ?><br>
                <?php echo ($_SESSION['dados_entrega']['complemento']==''?'':'<b>Complemento: </b>'.$_SESSION['dados_entrega']['complemento']) ?>
            </p>
            <br>
            <input type="hidden" id="plan" value="<?php echo number_format($_SESSION['total'], 2, '.', ''); ?>">

        </div>
    </div>
</div>


<?php $render('commerce/lay02/footer', ['dados' => $dados]); ?>

<script type='text/javascript'>
    var s=document.createElement('script');s.type='text/javascript';var v=parseInt(Math.random()*1000000);s.src='https://sandbox.gerencianet.com.br/v1/cdn/4386237ea13697f289fe6b5504dd944a/'+v;s.async=false;s.id='4386237ea13697f289fe6b5504dd944a';if(!document.getElementById('4386237ea13697f289fe6b5504dd944a')){document.getElementsByTagName('head')[0].appendChild(s);};$gn={validForm:true,processed:false,done:{},ready:function(fn){$gn.done=fn;}};

    $gn.ready(function(checkout){
        $('#brand').change(function (){
            window.bandeira = $(this).val();
            checkout.getInstallments(<?php echo $_SESSION['total']*100; ?>, window.bandeira, function(error, response){
                if(error) {
                    // Trata o erro ocorrido
                    if(error.code == 3500006){
                        $("#message").html('<div class="alert alert-danger" role="alert">'+error.error_description+' Entre em contato com o '+
                                            'propritário da loja para mais informações, o valor total da compra deve ser menor ou igual a R$1.700,00!</div>')
                        alert(error.error_description+ ' Entre em contato com o propritário da loja para mais informações, o valor total da compra deve ser menor ou igual a R$1.700,00!');
                    }else{
                        $("#message").html('<div class="alert alert-danger" role="alert">'+error.error_description+' Entre em contato com o '+
                                            'propritário da loja para mais informações!</div>');
                        alert(error.error_description+ ' Entre em contato com o propritário da loja para mais informações!');

                    }
                    console.log(error);
                } else {
                    html = '';
                    parc = response.data.installments;

                    for(var i in parc){
                        optionValue = parc[i].installment+';'+parc[i].currency;

                        html += '<option value='+optionValue+'>'+parc[i].installment+' parcelas de R$'+parc[i].currency+'</option>'
                    }
                    $('select[name=parc]').html(html);
                }
            });
        });

        $("#finalizar").on('click', function(){         
            var callback = function(error, response) {
                if(error) {
                    $("#message").html('<div class="alert alert-danger" role="alert">'+error.error_description+'</div>')
                    console.error(error);
                } else {
                    $.ajax({
                        url: '/checkout_gere',
                        type: 'POST',
                        data:{
                            paymentToken: response.data.payment_token,
                            parcela:$("#parc option:selected").val()
                        },
                        dataType:'json',
                        beforeSend: function(){
                            $('#loading').html('<div class="d-flex justify-content-center"><div class="spinner-border" role="status"></div><span class="visually-hidden"> &nbsp;&nbsp; Finalizando pagamento...</span></div>');
                        },
                        success:function(json){
                            if(json.error == true){
                                console.log(json.calculo)
                                $('#loading').html('<div class="alert alert-danger" role="alert">001 - Houve erro durante o pagamento, tente novamente atualizando a pagina!<br>'+json.msg+'</div>');
                                return;
                            }
                            window.location.href = '/pagamento/concluido/'+json.id_compra;
                            //$('#loading').html('<div class="alert alert-success" role="alert">Pagamento finalizado com sucesso</div>');
                        },
                        error:function(json){
                            $('#loading').html('<div class="alert alert-danger" role="alert">002 - Houve erro durante o pagamento, tente novamente atualizando a pagina!</div>');
                        }
                    });
                    console.log(response);
                }
            };

            checkout.getPaymentToken({
                brand: window.bandeira, // bandeira do cartão
                number: $("#n_card").val(), // número do cartão
                cvv: $("#cd_seg").val(), // código de segurança
                expiration_month: $("#cartao_mes option:selected").val(), // mês de vencimento
                expiration_year: $("#cartao_ano option:selected").val() // ano de vencimento
            }, callback);
        })
    });        
</script>