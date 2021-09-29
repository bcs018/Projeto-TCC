<?php
if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0 || !isset($_SESSION['login_cliente_ecommerce'])) {
    header("Location: /");
}
?>

<?php $render('commerce/lay02/header', ['title' => $dados['nome_fantasia'] . ' | Finalização da compra', 'layout' => $dados, 'carrinho' => $carrinho]); ?>

<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('<?php echo BASE_ASS_C; ?>lay02/images/boletoban.png');">
    <h2 class="ltext-105 cl0 txt-center">
        Finalização da compra 1/2
    </h2>
</section>
<br><br><br>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <center>
                <h1>Calcule o frete e informe o endereço de entrega</h1>
            </center> <br><br><br><br><br>
            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
            ?>
        </div>

        <div class="col-md-4">
            <form action="/pagamento/action/1" method="POST">
                <h4>Dados para entrega</h4><br><br>

                <label for="cep" class="form-label">CEP</label>
                <input type="text" class="form-control" name="cep" id="cep" placeholder="Informe seu CEP">
                <br>

                <label for="rua" class="form-label">Rua</label>
                <input type="text" class="form-control" name="rua" id="rua" placeholder="Informe sua rua">
                <br>

                <label for="bairro" class="form-label">Bairro</label>
                <input type="text" class="form-control" name="bairro" id="bairro" placeholder="Informe seu bairro">
                <br>

                <label for="numero" class="form-label">Número</label>
                <input type="text" class="form-control" name="numero" id="numero" name="numero" placeholder="Informe seu número">
                <br>

                <label for="estado" class="form-label">Estado</label>
                <select class="form-select form-select-sm form-control" aria-label=".form-select-sm example" name="estado" id="estado">
                    <?php foreach ($estados as $estado) : ?>
                        <option value="<?php echo $estado['estado_id']; ?>"><?php echo $estado['nome_estado']; ?></option>
                    <?php endforeach; ?>
                </select>
                <br>

                <label for="cidade" class="form-label">Cidade</label>
                <input type="text" class="form-control" name="cidade" id="cidade" placeholder="Informe sua cidade">
                <br>
                <input type="hidden" id="plan" value="<?php echo number_format($_SESSION['total'], 2, '.', ','); ?>">

                <label for="formGroupExampleInput" class="form-label">Complemento</label>
                <input type="text" class="form-control" name="complemento" id="formGroupExampleInput" placeholder="Informe o complemento">
                <br>

                <button type="submit" class="flex-c-m stext-101 cl0 size-107 bgbutton bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
					Avançar
                </button>
                <br><br><br><br>
            </form>
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
                        <?php $_SESSION['subtotal'] = 0; ?>
                        <?php foreach ($produtos as $p) : ?>
                            <tr>
                                <td><a href="/visualizar/produto/<?php echo $p['0']; ?>"><?php echo $p['nome_pro']; ?></a></td>
                                <td><?php echo 'R$ ' . number_format($p['preco'], 2, ',', '.'); ?></td>
                                <td><?php echo $_SESSION['carrinho'][$p[0]]; ?></td>
                            </tr>

                            <?php
                            $_SESSION['subtotal'] += floatval($p['preco']) * $_SESSION['carrinho'][$p[0]];
                            ?>

                        <?php endforeach; ?>

                        <tr>
                            <td colspan="3" style="text-align:right"><b>SUBTOTAL: <div id="subtot" style="display:inline;"><?php echo 'R$ ' . number_format($_SESSION['subtotal'], 2, ',', '.'); ?></div></b></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:right"><b>FRETE: <div id="calcfrete" style="display:inline;"><?php echo (isset($_SESSION['frete']) ? 'R$ ' . $_SESSION['frete']['preco'] . ' Prazo: ' . $_SESSION['frete']['data'] . ' dia(s) para o CEP: ' . $_SESSION['frete']['cep'] : 'R$ 0,00') ?></div></b></td>
                        </tr>
                        <tr>
                            <?php
                            if (isset($_SESSION['frete'])) {
                                $frete = str_replace(',', '.', $_SESSION['frete']['preco']);
                                $_SESSION['total'] = $_SESSION['subtotal'] + floatval($frete);
                            } else {
                                $_SESSION['total'] = $_SESSION['subtotal'];
                            }
                            ?>
                            <td colspan="3" style="text-align:right"><b>TOTAL: <div id="totalfinal" style="display:inline;"><?php echo 'R$ ' . number_format($_SESSION['total'], 2, ',', '.'); ?></div></b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <form id="frete">
                <label for="cep" class="form-label">Cálculo do frete</label>
                <input type="text" class="form-control" id="cepCalc" name="cepCalc" placeholder="Insira o CEP de entrega">
                <br><button class="flex-c-m stext-101 cl0 size-107 bgbutton bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10" type="submit">Calcular</button>
            </form>
            <br>

        </div>
    </div>
</div>

<?php $render('commerce/lay02/footer', ['dados' => $dados]); ?>

<script type="text/javascript">
    $('#cepCalc').mask("00000000");
    $('#cep').mask("00000-000");
    $('#cpf').mask("00000000000");
</script>