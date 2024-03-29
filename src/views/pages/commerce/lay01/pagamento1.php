<?php
if(!isset($_SESSION['login_cliente_ecommerce'])){
    header("Location: /");
}
?> 
<?php $render('commerce/lay01/header', ['title' => $dados['nome_fantasia'] . ' | Finalização da compra', 'layout' => $dados]); ?>

<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Finalização da compra 1/2</h2>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="single-product-area" style="padding: 40px 0 130px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <center><h1>Calcule o frete e informe o endereço de entrega</h1></center> <br><br>
                <?php
                if(isset($_SESSION['message'])){
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                ?>
            </div>

            <div class="col-md-4">
                <form id="frete">
                    <label for="cep" class="form-label">Cálculo do frete</label>
                    <input type="text" class="form-control" id="cepCalc" name="cepCalc" placeholder="Insira o CEP de entrega">
                    <br><button type="submit">Calcular</button>
                </form>
                <br><br>
                <form action="/pagamento/action/0" method="POST">
                <h4>Dados para entrega</h4>
                <small>Campos marcados com asterisco (*) são obrigatórios</small><br><br>

                <label for="cep" class="form-label">* CEP</label>
                <input type="text" class="form-control" name="cep" id="cep" placeholder="CEP" readonly>
                <br>

                <label for="rua" class="form-label">* Rua</label>
                <input type="text" class="form-control" name="rua" id="rua"  placeholder="Rua" readonly>
                <br>

                <label for="bairro" class="form-label">* Bairro</label>
                <input type="text" class="form-control" name="bairro" id="bairro" placeholder="Bairro" readonly>
                <br>

                <label for="numero" class="form-label">* Número</label>
                <input type="text" class="form-control" name="numero" id="numero" name="numero" placeholder="Informe seu número">
                <br>

                <label for="estado" class="form-label">* Estado</label>
                <select class="form-select form-select-sm form-control" aria-label=".form-select-sm example" name="estado" id="estado" readonly>
                    <?php foreach($estados as $estado): ?>
                        <option value="<?php echo $estado['estado_id']; ?>"><?php echo $estado['nome_estado']; ?></option>
                    <?php endforeach; ?>
                </select>
                <br>

                <label for="cidade" class="form-label">* Cidade</label>
                <input type="text" class="form-control" name="cidade" id="cidade" placeholder="Cidade" readonly>
                <br>
                <input type="hidden" id="plan" value="<?php echo number_format($_SESSION['total'], 2, '.', ','); ?>">

                <label for="formGroupExampleInput" class="form-label">Complemento</label>
                <input type="text" class="form-control" name="complemento" id="formGroupExampleInput" placeholder="Informe o complemento">
                <br>

                <button type="submit" class="finalizar" style="float: right;">Avançar</button> <br><br><br><br>
                </form>
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
//echo'<pre>';print_r($_SESSION);
?>

<?php $render('commerce/lay01/footer', ['dados' => $dados]); ?>

<script type="text/javascript">
    $('#cepCalc').mask("00000000");
    $('#cep').mask("00000-000");
    $('#cpf').mask("00000000000");
</script>