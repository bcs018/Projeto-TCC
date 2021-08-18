<?php $render('commerce/lay01/header', ['title' => $dados['nome_fantasia'] . ' | ' . $produto[0]['nome_pro'], 'layout' => $dados]); ?>

<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2><?php echo $produto[0]['nome_pro']; ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="single-sidebar">
                    <h2 class="sidebar-title">Postagens recentes</h2>
                    <ul>
                        <?php if (!empty($produtos)) : ?>
                            <?php $i = 0; ?>
                            <?php foreach ($produtos as $p) : ?>
                                <?php $i++; ?>
                                <?php if ($i > 5) break; ?>
                                <li><a href="/visualizar/produto/<?php echo $p['produto_id']; ?>"><?php echo $p['nome_pro']; ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="col-md-8">
                <div class="product-content-right">
                    <div class="product-inner-category">
                        <p>Categoria: <?php foreach ($categoria as $c) : ?>
                                <a href=""><?php echo $c['nome_cat'] ?></a> /
                                <?php endforeach; ?>.
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="product-images">
                                <div class="product-main-img">
                                    <?php if ($produto[0]['url'] == null) : ?>
                                        <img src="<?php echo BASE_ASS_C; ?>/images/semfoto.jpg" alt="">
                                    <?php else : ?>
                                        <img src="<?php echo BASE_ASS_C; ?>/images_commerce/<?php echo $produto[0]['url']; ?>" alt="">
                                    <?php endif; ?>
                                </div>
                                <div class="product-gallery">
                                    <?php foreach ($produto as $p) : ?>
                                        <img src="<?php echo BASE_ASS_C; ?>/images_commerce/<?php echo $p['url']; ?>" alt="">
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="product-inner">
                                <h2 class="product-name"><?php echo $produto[0]['nome_pro']; ?></h2>
                                <div class="product-inner-price">
                                    <ins style="font-size:x-large;"><?php echo 'R$' . number_format($produto[0]['preco'], 2, ',', '.'); ?></ins> <del><?php echo ($produto[0]['preco_antigo'] == 0.00) ? '' : 'R$' . number_format($produto[0]['preco_antigo'], 2, ',', '.'); ?></del>
                                </div>
                                <form action="/add-carrinho" method="POST" class="cart">
                                    <input type="hidden" name="id_produto" value="<?php echo $produto[0][0]; ?>">
                                    <button class="add_to_cart_button" type="submit">Comprar</button>
                                </form>
                                <h5>Estoque: <b><?php echo $produto[0]['estoque']; ?></b></h5>
                                <br><br>
                                <div role="tabpanel">
                                    <ul class="product-tab" role="tablist">
                                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Descrição do produto</a></li>
                                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Frete</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade in active" id="home">
                                            <p><?php echo $produto[0]['descricao']; ?></p>
                                        </div>

                                        <!-- <div role="tabpanel" class="tab-pane fade" id="profile"> -->
                                        <br>
                                        <hr>    
                                        <h2>Cálculo do frete</h2>
                                        <div class="submit-review">
                                            <form id="frete">
                                                <p>
                                                    <label for="cep">Informe seu CEP</label> 
                                                    <input name="cep" id="cep" type="text">
                                                </p>
                                                <p>
                                                    <input type="submit" value="Calcular">
                                                </p>
                                            </form>
                                        </div>
                                        <div id="calcfrete"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="related-products-wrapper">
                        <h2 class="related-products-title">PRODUTOS RELACIONADOS</h2>
                        <div class="related-products-carousel">
                            <?php foreach ($produtosRel as $pr) : ?>
                                <div class="single-product">
                                    <div class="product-f-image">
                                        <?php if ($pr['url'] == null) : ?>
                                            <img src="<?php echo BASE_ASS_C; ?>images/semfoto.jpg" alt="Produto sem foto">
                                        <?php else : ?>
                                            <img src="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $pr['url']; ?>" alt="Produto <?php echo $pr['nome_pro']; ?>">
                                        <?php endif; ?>
                                        <div class="product-hover">
                                            <a href="" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> Carrinho</a>
                                            <a href="" class="view-details-link"><i class="fa fa-link"></i> Detalhes</a>
                                        </div>
                                    </div>

                                    <h2><a href=""><?php echo $pr['nome_pro']; ?></a></h2>

                                    <div class="product-carousel-price">
                                        <ins><?php echo 'R$' . number_format($pr['preco'], 2, ',', '.'); ?></ins>
                                        <del><?php echo ($pr['preco_antigo'] == 0.00) ? '' : 'R$' . number_format($pr['preco_antigo'], 2, ',', '.'); ?></del>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
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