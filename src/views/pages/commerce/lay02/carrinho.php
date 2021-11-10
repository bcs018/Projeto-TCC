<?php $render('commerce/lay02/header', ['title' => $dados['nome_fantasia'] . ' | Carrinho', 'layout' => $dados, 'carrinho' => $carrinho]); ?>
<br><br><br><br>

<style>
    .container {max-width: 2000px;}

    @media (max-width: 1600px) {
    .container {max-width: 2000px;}
    }
</style>

<!-- <form class="bg0 p-t-75 p-b-85"> -->
    <div class="container">
        <center><h1>Carrinho</h1></center><br><br><br>
        <div class="row">
            <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <div class="wrap-table-shopping-cart">
                        <div class="table-responsive-sm">    
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col">Produto</th>
                                        <th scope="col">Preço</th>
                                        <th scope="col"> <center> Qtd.</center></th>
                                        <th scope="col">Estoque</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>

                                <?php if($control): ?>
                                    <?php
                                        if(isset($_SESSION['message'])){
                                            echo $_SESSION['message'];
                                            unset($_SESSION['message']);
                                        }
                                    ?>
                                    <?php echo $carrinho; ?>
                                <?php else: ?>
                                    <?php foreach($carrinho as $c): ?>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a title="Remover" href="/deletar/item/carrinho/<?php echo $c[0] ?>">X</a>
                                                </td>

                                                <td>
                                                    <div class="how-itemcart1">
                                                        <img src="<?php if ($c['url'] == null) : ?>
                                                                                <?php echo BASE_ASS_C; ?>/images/semfoto.jpg
                                                                            <?php else : ?>
                                                                                    <?php echo BASE_ASS_C; ?>/images_commerce/<?php echo $c['url']; ?>
                                                                            <?php endif; ?>" alt="IMG">
                                                    </div>
                                                </td>

                                                <td>
                                                    <a href="/visualizar/produto/<?php echo $c[0]; ?>"><?php echo $c['nome_pro']; ?></a>
                                                </td>

                                                <td><?php echo 'R$ ' . number_format($c['preco'], 2, ',', '.'); ?></td>

                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" class="form-control" id="<?php echo $c[0]; ?>" size="2" name="qtd" aria-describedby="inputGroup-sizing-sm" value="<?php echo $_SESSION['carrinho'][$c[0]]; ?>" min="1" step="1">
                                                    </div>
                                                </td>

                                                <td><center> <?php echo $c['estoque']; ?></center></td>

                                                <td>
                                                    <div id="v<?php echo $c[0]; ?>">
                                                        <?php echo 'R$ ' . number_format($c['preco'] * $_SESSION['carrinho'][$c[0]], 2, ',', '.'); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>

                    <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                        <!-- <div class="flex-w flex-m m-r-20 m-tb-5">
                            <input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text"
                                name="coupon" placeholder="Coupon Code">

                            <div class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
                                Apply coupon
                            </div>
                        </div> -->

                        <!-- <div
                            class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                            Update Cart
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                    <h4 class="mtext-109 cl2 p-b-30">
                        Detalhes
                    </h4>

                    <div class="flex-w flex-t bor12 p-b-13">
                        <div class="size-208">
                            <span class="stext-110 cl2">
                                Subtotal:            
                            </span>
                        </div>

                        <div class="size-209">
                            <span class="mtext-110 cl2">
                                <div id="subtot">
                                    <?php echo (isset($valores['subtotal'])) ? 'R$ '. $valores['subtotal'] : 'R$ 0,00'; ?>
                                </div>
                            </span>
                        </div>
                    </div>

                    <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                        <div class="size-208 w-full-ssm">
                            <span class="stext-110 cl2">
                                Frete:
                            </span>
                        </div>

                        <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                            <p class="stext-111 cl6 p-t-2">
                                <div id="calcfrete">
                                    <?php echo(isset($_SESSION['frete']))?'R$ '.$_SESSION['frete']['preco'].' Prazo: '.$_SESSION['frete']['data'].' dia(s) para o CEP: '.$_SESSION['frete']['cep']:''; ?>
                                </div>
                            </p>
                        </div>
                        <div class="w-full-ssm">                                               
                            <?php if(isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0): ?>
                                <br>
                                <div class="p-t-15">
                                    <span class="stext-112 cl8">
                                        Calcular Frete
                                    </span>

                                    <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                        <form method="post" id="frete" class="shipping_calculator float-left">
                                            <input type="text" class="form-control" id="cepCalc" name="cepCalc" placeholder="Informe o CEP" class="input-text">
                                            <br>
                                            <button class="btn btn-info" type="submit">Calcular</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="flex-w flex-t p-t-27 p-b-33">
                        <div class="size-208">
                            <span class="mtext-101 cl2">
                                Total:
                            </span>
                        </div>

                        <div class="size-209 p-t-1">
                            <span class="mtext-110 cl2">
                            <strong>
                                <span id="totalfinal" class="amount"><?php echo (isset($valores['total'])) ? 'R$ '. $valores['total'] : 'R$ 0,00'; ?></span>
                            </strong>
                            </span>
                        </div>
                    </div>
                    <a href="" class="btn btn-info" id="pagar">Comprar</a>
            
                    <!-- <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                        Proceed to Checkout
                    </button> -->
                </div>
            </div>
        </div>
    </div>
<!-- </form> -->

<div class="modal fade bd-example-modal-sm" id="selectPay" tabindex="-1" role="dialog"
    aria-labelledby="selectPayLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="font-size: 0.99rem;" class="modal-title" id="exampleModalLabel">Selecione o tipo de pagamento</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div style="margin: 35px;" class="modal-body">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tpPgm" id="card"
                            value="card" checked>
                        <label class="form-check-label" for="card">
                            Cartão de crédito <img src="<?php echo BASE_ASS_C?>images/card.png" alt="Cartão de crédito"
                                id="imgcard">
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tpPgm" id="bol"
                            value="bol">
                        <label class="form-check-label" for="bol">
                            Boleto bancario <img src="<?php echo BASE_ASS_C?>images/codbarra.png"
                                alt="Cartão de crédito" id="imgbol">
                        </label>
                    </div>
                    <div id="message"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="btnSelPgm">OK</button>
                </div>
                
            </form>
        </div>
    </div>
</div>
<br><br><br><br><br><br>
<?php $render('commerce/lay02/footer', ['dados' => $dados]); ?>

<script type="text/javascript">
    $('#cepCalc').mask("00000000");
</script>