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
                <label for="n_card" class="form-label">Número do cartão</label>
                <input type="number" class="form-control" name="n_card" id="n_card" placeholder="Número do cartão">
                <div id="brand"></div>
                <br>
                <label for="parc" class="form-label">Número de parcelas</label>
                <select name="parc" id="parc" class="form-control"></select>
                <br>
                <label for="cd_seg" class="form-label">Código de segurança</label>
                <input type="number" class="form-control" name="cd_seg" id="cd_seg" placeholder="Código de segurança">
                <br>
                <label for="formGroupExampleInput" class="form-label">Mês e ano do vencimento</label>
                <div class="row">
                    <div class="col-md-6">
                        <select name="cartao_mes" id="cartao_mes" class="form-control">
                            <?php for($q=1; $q<=12; $q++): ?>
                            <option><?php echo ($q<10)?'0'.$q:$q; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <select name="cartao_ano" id="cartao_ano" class="form-control">
                            <?php $ano = intval(date('Y')); ?>
                            <?php for($q=$ano; $q<=($ano+30); $q++): ?>
                            <option><?php echo $q; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div> <br>
                <label for="nome_card" class="form-label">Nome impresso no cartão</label>
                <input type="text" value="BRUNO C SILVA" class="form-control" name="nome_card" id="nome_card" placeholder="Nome impresso no cartão">
                <br>
                <label for="cpf_card" class="form-label">CPF do titular do cartão</label>
                <input type="text" value="38606845825" class="form-control" name="cpf_card" id="cpf_card" placeholder="CPF do titular do cartão">
                <br><hr>
                <input type="hidden" id="plan" value="<?php echo number_format($_SESSION['total'], 2, '.', ','); ?>">
                
                <button type="submit" class="finalizar" style="float: right;">Finalizar Compra</button> <br><br><br><br>
                
                <div id="loading"></div>
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