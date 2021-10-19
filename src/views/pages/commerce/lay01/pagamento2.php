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
<?php $render('commerce/lay01/header', ['title' => $dados['nome_fantasia'] . ' | Finalização da compra', 'layout' => $dados]); ?>

<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Finalização da compra 2/2</h2>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="single-product-area" style="padding: 40px 0 130px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <center><h1>Preencha os dados</h1></center> <br><br>
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
                <button type="submit" id="finalizar" style="float: right;">Finalizar Compra</button> <br><br><br><br>
                <br>
                <div id="loading"></div>

                <br><br>
            </div>

            <div class="col-md-1"></div>
            <div class="col-md-7">
                <h4>Produtos selecionados</h4>
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
                                    <td><a href="/visualizar/produto/<?php echo $p['0']; ?>"><?php echo $p['nome_pro']; ?></a></td>
                                    <td><?php echo 'R$ '. number_format($p['preco'],2,',','.'); ?></td>
                                    <td><?php echo $_SESSION['carrinho'][$p[0]]; ?></td>
                                </tr>

                                <?php 
                                $_SESSION['subtotal'] += floatval($p['preco']) * $_SESSION['carrinho'][$p[0]];
                                ?>

                            <?php endforeach; ?>
                            
                            <tr>
                                <td colspan="3" style="text-align:right"><b>SUBTOTAL: <div id="subtot" style="display:inline;"><?php echo 'R$ '. number_format( $_SESSION['subtotal'],2,',','.'); ?></div></b></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right"><b>FRETE: <div id="calcfrete" style="display:inline;"><?php echo(isset($_SESSION['frete'])?'R$ '.$_SESSION['frete']['preco'].' Prazo: '.$_SESSION['frete']['data'].' dia(s) para o CEP: '.$_SESSION['frete']['cep']:'R$ 0,00') ?></div></b></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right"><b>TOTAL: <div id="totalfinal" style="display:inline;"><?php echo 'R$ '. number_format( $_SESSION['total'],2,',','.'); ?></div></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p><b>Dados para a entrega:</b></p>
                <p>
                    <b>Rua:</b> <?php echo $_SESSION['dados_entrega']['rua'].' - <b>N°: </b>'.$_SESSION['dados_entrega']['numero']; ?></br>
                    <b>Bairro:</b> <?php echo $_SESSION['dados_entrega']['bairro']; ?></br>
                    <b>CEP:</b> <?php echo $_SESSION['dados_entrega']['cep']; ?></br>
                    <b>Cidade:</b> <?php echo $_SESSION['dados_entrega']['cidade'].' - '.$_SESSION['dados_entrega']['estado']; ?><br>
                    <?php echo ($_SESSION['dados_entrega']['complemento']==''?'':'<b>Complemento: </b>'.$_SESSION['dados_entrega']['complemento']) ?>
                </p>
                <br>
                <input type="hidden" id="plan" value="<?php echo number_format($_SESSION['total'], 2, '.', ''); ?>">

            </div>
        </div>
    </div>
</div>

<?php 

?>

<?php $render('commerce/lay01/footer', ['dados' => $dados]); ?>

<?php if($dados['tp_recebimento'] == 'pagseguro'): ?>
    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script src="<?php echo BASE_ASS_C; ?>js/psckttransparente.js"></script>
    <script type="text/javascript">
        PagSeguroDirectPayment.setSessionId("<?php echo $sessionCode; ?>");
    </script>
<?php elseif($dados['tp_recebimento'] == 'mercadopago'): ?>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script src="<?php echo BASE_ASS_C; ?>js/mpckttransparente.js"></script>
    <script>
        const mp = new MercadoPago('<?php echo $dados['mp_public_key'] ?>', {
            locale: 'pt-BR'
        })

        const cardForm = mp.cardForm({
            amount: $('#plan').val(),
            autoMount: true,
            processingMode: 'aggregator',
            form: {
                id: 'form-checkout',
                cardholderName: {
                    id: 'form-checkout__cardholderName',
                    placeholder: 'Nome impresso no cartão',
                },
                cardholderEmail: {
                    id: 'form-checkout__cardholderEmail',
                    placeholder: 'Email',
                },
                cardNumber: {
                    id: 'form-checkout__cardNumber',
                    placeholder: 'Número do cartão',
                },
                cardExpirationMonth: {
                    id: 'form-checkout__cardExpirationMonth',
                    placeholder: 'MM'
                },
                cardExpirationYear: {
                    id: 'form-checkout__cardExpirationYear',
                    placeholder: 'AAAA'
                },
                securityCode: {
                    id: 'form-checkout__securityCode',
                    placeholder: 'CVV',
                },
                installments: {
                    id: 'form-checkout__installments',
                    placeholder: 'Parcelas'
                },
                identificationType: {
                    id: 'form-checkout__identificationType',
                    placeholder: 'Tipo do documento'
                },
                identificationNumber: {
                    id: 'form-checkout__identificationNumber',
                    placeholder: 'Número do documento'
                },
                issuer: {
                    id: 'form-checkout__issuer',
                    placeholder: ''
                }
            },
            callbacks: {
                onFormMounted: error => {
                    if (error) return console.warn('Form Mounted handling error: ', error)
                    console.log('Form mounted')
                },
                onFormUnmounted: error => {
                    if (error) return console.warn('Form Unmounted handling error: ', error)
                    console.log('Form unmounted')
                },
                onIdentificationTypesReceived: (error, identificationTypes) => {
                    if (error) return console.warn('identificationTypes handling error: ', error)
                    console.log('Identification types available: ', identificationTypes)
                },
                onPaymentMethodsReceived: (error, paymentMethods) => {
                    if (error) return console.warn('paymentMethods handling error: ', error)
                    console.log('Payment Methods available: ', paymentMethods)
                },
                onIssuersReceived: (error, issuers) => {
                    if (error) return console.warn('issuers handling error: ', error)
                    console.log('Issuers available: ', issuers)
                },
                onInstallmentsReceived: (error, installments) => {
                    if (error) return console.warn('installments handling error: ', error)
                    console.log('Installments available: ', installments)
                },
                onCardTokenReceived: (error, token) => {
                    if (error){
                        html = '';
                        for(i = 0; i < error.length; i++){
                            if(error[i].code == '205'){
                                html += '<div class="alert alert-danger" role="alert"> Número do cartão em branco </div>';
                            }else if(error[i].code == '208'){
                                html += '<div class="alert alert-danger" role="alert">Mês em branco </div>';
                            }else if(error[i].code == '209'){
                                html += '<div class="alert alert-danger" role="alert">Ano em branco </div>';  
                            }else if(error[i].code == '316'){
                                html += '<div class="alert alert-danger" role="alert">Por favor, digite um nome válido.</div>';  
                            }else if(error[i].code == '212' || error[i].code == '213' || error[i].code == '214'){
                                html += '<div class="alert alert-danger" role="alert">Informe seu documento..</div>';  
                            }else if(error[i].code == '221'){
                                html += '<div class="alert alert-danger" role="alert">Por favor, digite o nome e sobrenome.</div>';  
                            }else if(error[i].code == '224'){
                                html += '<div class="alert alert-danger" role="alert">Por favor, digite o código de segurança.</div>';  
                            }else if(error[i].code == 'E301'){
                                html += '<div class="alert alert-danger" role="alert">Há algo de errado com esse número de cartão. Digite novamente.</div>';  
                            }else if(error[i].code == 'E302'){
                                html += '<div class="alert alert-danger" role="alert">Confira o código de segurança.</div>';  
                            }else if(error[i].code == '322' || error[i].code == '323' || error[i].code == '324'){
                                html += '<div class="alert alert-danger" role="alert">Confira seu documento.</div>';  
                            }else if(error[i].code == '325' || error[i].code == '326'){
                                html += '<div class="alert alert-danger" role="alert">Confira a data.</div>';  
                            }else{
                                html += '<div class="alert alert-danger" role="alert">Confira os dados.</div>';  
                            }
                        }

                        $('#message').html(html);

                        return console.log('Token handling error: ', error)
                    } 
                    console.log('Token available: ', token)
                },
                onSubmit: (event) => {
                    event.preventDefault();

                    const {
                        paymentMethodId: payment_method_id,
                        issuerId: issuer_id,
                        cardholderEmail: email,
                        amount,
                        token,
                        installments,
                        identificationNumber,
                        identificationType,
                    } = cardForm.getCardFormData();
                    const cardData = cardForm.getCardFormData();
                    //console.log('Dados do formulario ', cardData)
                    
                    $.ajax({
                        url: '/checkout_mp',
                        dataType: 'JSON',
                        type: 'POST',
                        data: {
                            cardData,
                            parc: $('#form-checkout__installments').find('option:selected').text()
                        },
                        success:function(r){
                            if(r.error == true){
                                $('#message').html(r.message);
                                return;
                            }else{
                                window.location.href = '/pagamento/concluido/'+r.id_compra;
                            }
                            //console.log(r)
                        } 

                    });

                    return;
                },
                onFetching: (resource) => {
                    console.log('Fetching resource: ', resource)

                    // Animate progress bar
                    const progressBar = document.querySelector('.progress-bar')
                    progressBar.removeAttribute('value')

                    return () => {
                        progressBar.setAttribute('value', '0')
                    }
                },
            }
        })
    </script>
<?php else: ?>
    <script type='text/javascript'>
        var s=document.createElement('script');s.type='text/javascript';var v=parseInt(Math.random()*1000000);s.src='https://sandbox.gerencianet.com.br/v1/cdn/4386237ea13697f289fe6b5504dd944a/'+v;s.async=false;s.id='4386237ea13697f289fe6b5504dd944a';if(!document.getElementById('4386237ea13697f289fe6b5504dd944a')){document.getElementsByTagName('head')[0].appendChild(s);};$gn={validForm:true,processed:false,done:{},ready:function(fn){$gn.done=fn;}};

        $gn.ready(function(checkout){
            $('#brand').change(function (){
                window.bandeira = $(this).val();
                checkout.getInstallments(<?php echo $_SESSION['total']*100; ?>, window.bandeira, function(error, response){
                    if(error) {
                        // Trata o erro ocorrido
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

<?php endif; ?>

<script type="text/javascript">
    $('#cepCalc').mask("00000000");
    $('#cep').mask("00000-000");
    $('#cpf').mask("00000000000");

    $('#form-checkout__cardExpirationMonth').mask("00");
    $('#form-checkout__cardExpirationYear').mask("0000");
</script>