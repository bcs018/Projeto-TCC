<?php
if(!isset($_SESSION['login_cliente_ecommerce']) || $produtos == false){
    header("Location: /");
}
?> 
<?php $render('commerce/lay01/header', ['title' => $dados['nome_fantasia'] . ' | Finalização da compra', 'layout' => $dados]); ?>

<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Obrigado!</h2>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="single-product-area" style="padding: 40px 0 130px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <center><h1><?php echo $_SESSION['log_admin_c']['fantasia']; ?> agradeçe a sua compra!</h1></center> <br><br>
            </div>
            
            <div class="col-md-4">
                <?php 
                if(isset($_SESSION['message'])){
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                ?>
            </div>
            <h4>Agradecemos por sua compra, segue abaixo os detalhes:</h4>

            <h5>
                <b>Compra número: </b><?php echo $compra['compra_id']; ?><br>
                <b>Pagamento: </b><?php echo $compra['parcela']; ?><br>
                <b>Tipo de Pagamento: </b><?php echo ($compra['tipo_pagamento']=='cartao'?'Cartão de crédito':'Boleto'); ?>
            </h5>
            <br>
            <hr>
            <br>
            <h5><b>Dados de entrega</b></h5>
            <p>
                <b>Rua:</b> <?php echo $compra['rua_entrega'].' - <b>N°: </b>'.$compra['numero_entrega']; ?></br>
                <b>Bairro:</b> <?php echo $compra['bairro_entrega']; ?></br>
                <b>CEP:</b> <?php echo $compra['cep_entrega']; ?></br>
                <b>Cidade:</b> <?php echo $compra['cidade_entrega'].' - '.$compra['estado_entrega']; ?><br>
                <?php echo ($compra['complemento_entrega']==''?'':'<b>Complemento: </b>'.$compra['complemento_entrega']) ?>
            </p>
            <br><br>
            
            <div class="col-md-12"></div>
            <div class="col-md-12"><h3>Itens</h3>
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
                            <?php  //$_SESSION['subtotal'] = 0; ?>
                            <?php foreach($produtos as $p): ?>
                                <tr>
                                    <td><a href="/visualizar/produto/<?php echo $p['0']; ?>"><?php echo $p['nome_pro']; ?></a></td>
                                    <td><?php echo 'R$ '. number_format($p['preco'],2,',','.'); ?></td>
                                    <td><?php echo $p['quantidade']; ?></td>
                                </tr>

                                <?php 
                                //$_SESSION['subtotal'] += floatval($p['preco']) * $_SESSION['carrinho'][$p[0]];
                                ?>

                            <?php endforeach; ?>
                            
                            <tr>
                                <td colspan="3" style="text-align:right"><b>SUBTOTAL: <div id="subtot" style="display:inline;"><?php echo 'R$ '. number_format( $compra['subtotal_compra'],2,',','.'); ?></div></b></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right"><b>FRETE: <div id="calcfrete" style="display:inline;"><?php echo $compra['frete']; ?></div></b></td>
                            </tr>
                            <tr>
                                <?php 
                                // if(isset($_SESSION['frete'])){
                                //     $frete = str_replace(',','.',$_SESSION['frete']['preco']);
                                //     $_SESSION['total'] = $_SESSION['subtotal'] + floatval($frete);
                                // }else{
                                //     $_SESSION['total'] = $_SESSION['subtotal'];
                                // }
                                ?>
                                <td colspan="3" style="text-align:right"><b>TOTAL: <div id="totalfinal" style="display:inline;"><?php echo 'R$ '. number_format( $compra['total_compra'],2,',','.'); ?></div></b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>

            </div>
        </div>
    </div>
</div>

<?php 
echo'<pre>';print_r($_SESSION);
?>

<?php $render('commerce/lay01/footer', ['dados' => $dados]); ?>

<?php if(isset($sessionCode)): ?>
    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script src="<?php echo BASE_ASS_C; ?>js/psckttransparente.js"></script>
    <script type="text/javascript">
        PagSeguroDirectPayment.setSessionId("<?php echo $sessionCode; ?>");
    </script>
<?php endif; ?>


<script type="text/javascript">
    $('#cepCalc').mask("00000000");
    $('#cep').mask("00000-000");
    $('#cpf').mask("00000000000");
</script>