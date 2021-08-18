<?php $render('commerce/lay01/header', ['title' => $dados['nome_fantasia'] . ' | Carrinho', 'layout' => $dados]); ?>

<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Carrinho</h2>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End Page title area -->

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-content-right">
                    <div class="woocommerce">
                        <form method="post" action="#">
                            <table cellspacing="0" class="shop_table cart">
                                <thead>
                                    <tr>
                                        <th class="product-remove">&nbsp;</th>
                                        <th class="product-thumbnail">&nbsp;</th>
                                        <th class="product-name">Produto</th>
                                        <th class="product-price">Preço</th>
                                        <th class="product-quantity">Quantidade</th>
                                        <th class="product-subtotal">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($control): ?>
                                        <?php echo $carrinho; ?>
                                    <?php else: ?>
                                        <?php foreach($carrinho as $c): ?>
                                            <tr class="cart_item">
                                                <td class="product-remove">
                                                    <center><a title="Remover" class="remove" href="/deletar/item/carrinho/<?php echo $c[0] ?>">X</a></center>
                                                </td>

                                                <td class="product-thumbnail">
                                                    <a href="/visualizar/produto/<?php echo $c[0]; ?>"><center><img width="145" height="145" alt="poster_1_up" class="shop_thumbnail" src="<?php if ($c['url'] == null) : ?>
                                                                                                                                                                                                <?php echo BASE_ASS_C; ?>/images/semfoto.jpg
                                                                                                                                                                                            <?php else : ?>
                                                                                                                                                                                                <?php echo BASE_ASS_C; ?>/images_commerce/<?php echo $c['url']; ?>
                                                                                                                                                                                            <?php endif; ?>"></center>
                                                                                                                                                                                            </a>
                                                </td>

                                                <td class="product-name">
                                                    <a href="/visualizar/produto/<?php echo $c[0]; ?>"><?php echo $c['nome_pro']; ?></a>
                                                </td>

                                                <td class="product-price">
                                                    <span class="amount"><?php echo 'R$ ' . number_format($c['preco'], 2, ',', '.'); ?></span>
                                                </td>

                                                <td class="product-quantity">
                                                    <div class="quantity buttons_added">
                                                        <input type="number" id="<?php echo $c[0]; ?>" size="4" name="qtd" class="input-text qty text" title="Quantidade" value="<?php echo $_SESSION['carrinho'][$c[0]]; ?>" min="1" step="1">
                                                    </div>
                                                </td>

                                                <td class="product-subtotal">
                                                    <div id="v<?php echo $c[0]; ?>"><?php echo 'R$ ' . number_format($c['preco'] * $_SESSION['carrinho'][$c[0]], 2, ',', '.'); ?></div>
                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <tr>
                                        <td class="actions" colspan="6" style="text-align: right;">
                                            <!-- <div class="coupon">
                                                    <label for="coupon_code">Coupon:</label>
                                                    <input type="text" placeholder="Coupon code" value="" id="coupon_code" class="input-text" name="coupon_code">
                                                    <input type="submit" value="Apply Coupon" name="apply_coupon" class="button">
                                                </div>
                                                <input type="submit" value="Update Cart" name="update_cart" class="button"> -->
                                            <input type="submit" value="Pagar" name="proceed" class="checkout-button button alt wc-forward">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>

                        <div class="col-md-6 float-left">
                            <div class="cart_totals ">
                                <table cellspacing="0">
                                    <tbody>
                                        <tr class="cart-subtotal">
                                            <th>Subtotal</th>
                                            <td><div id="subtot"><?php echo (isset($valores['subtotal'])) ? 'R$ '. $valores['subtotal'] : 'R$ 0,00'; ?></div></td>
                                        </tr>

                                        <tr class="shipping">
                                            <th>Frete</th>
                                            <td><div id="calcfrete"><?php //echo(isset($_SESSION['frete']))?'R$ '.$_SESSION['frete']['preco'].' Prazo: '.$_SESSION['frete']['data'].' dia(s)':''; ?></div></td>
                                        </tr>

                                        <tr class="order-total">
                                            <th>Total</th>
                                            <td><strong><span id="totalfinal" class="amount"><?php echo (isset($valores['total'])) ? 'R$ '. $valores['total'] : 'R$ 0,00'; ?></span></strong> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <?php if(isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0): ?>
                        <div class="col-md-6 ">
                            <form method="post" id="frete" class="shipping_calculator float-left">
                                <h2>Calculo do Frete</h2>
                                <p class="form-row form-row-wide">
                                    <input type="text" id="cep" name="cep" placeholder="Informe o CEP" class="input-text">
                                </p>

                                <p>
                                    <button class="button" type="submit">Calcular</button>
                                </p>
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $render('commerce/lay01/footer', ['dados' => $dados]); ?>

<script type="text/javascript">
    $('#cep').mask("00000000");
</script>