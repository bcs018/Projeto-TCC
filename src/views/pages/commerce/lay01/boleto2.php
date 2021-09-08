<?php
if(!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0 || !isset($_SESSION['login_cliente_ecommerce'])){
    header("Location: /");
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
                <center><h1>Você está prestes a finalizar, clique no botão "Gerar boleto" para concluir sua compra</h1></center> <br><br>
                <?php
                if(isset($_SESSION['message'])){
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                ?>
            </div>

            <div class="col-md-4">
                <br>
                <button type="submit" class="finalizar" style="float: left;">Gerar boleto</button> <br><br><br>
                <div id="loading"></div>
            </div>
            <div id="teste"></div>

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
                                <?php 
                                if(isset($_SESSION['frete'])){
                                    $frete = str_replace(',','.',$_SESSION['frete']['preco']);
                                    $_SESSION['total'] = $_SESSION['subtotal'] + floatval($frete);
                                }else{
                                    $_SESSION['total'] = $_SESSION['subtotal'];
                                }
                                ?>
                                <td colspan="3" style="text-align:right"><b>TOTAL: <div id="totalfinal" style="display:inline;"><?php echo 'R$ '. number_format( $_SESSION['total'],2,',','.'); ?></div></b></td>
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

<?php
echo '<pre>';print_r($dados);
?>

<?php if($dados['tp_recebimento'] == 'pagseguro'): ?>
    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script src="<?php echo BASE_ASS_C; ?>js/psckttransparenteBol.js"></script>
    <script type="text/javascript">
        PagSeguroDirectPayment.setSessionId("<?php echo $sessionCode; ?>");
    </script>
<?php else: ?>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
   <script>
       const mp = new MercadoPago("<?php echo $dados['mp_token'] ?>");
       // Add step #3
   </script>
<?php endif; ?>