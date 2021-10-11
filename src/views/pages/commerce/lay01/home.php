<?php $render('commerce/lay01/header', ['title' => $dados['nome_fantasia'] . ' | Home', 'layout' => $dados]); ?>
<?php 
if(isset($_SESSION['message'])){
    echo $_SESSION['message'];
    unset($_SESSION['message']);
} 

unset($_SESSION['frete']);

?>
<?php if (!empty($prodBanner)) : ?>
    <div class="slider-area">
        <!-- Slider -->
        <div class="block-slider block-slider4">
            <ul class="" id="bxslider-home4">
                <?php foreach ($prodBanner as $pb) : ?>
                    <li>
                        <img src="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $pb['banner_img']; ?>" alt="Slide <?php echo $pb['nome_pro']; ?>">
                        <div class="caption-group">
                            <h2 class="caption title">
                                <?php echo $pb['nome_pro']; ?>
                                <!--<span class="primary"><strong></strong></span>-->
                            </h2>
                            <!-- <h4 class="caption subtitle"></h4> -->
                            <a class="caption button-radius" href="/visualizar/produto/<?php echo $pb[0]; ?>"><span class="icon"></span>Visualizar</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>

<br><br><br>

<div class="maincontent-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="latest-product">
                    <h2 class="section-title">Últimos produtos</h2>
                    <div class="product-carousel">
                        <?php if (!empty($produtos)) : ?>
                            <?php foreach ($produtos as $produto) : ?>
                                <div class="single-product">
                                    <div class="product-f-image">
                                        <?php if($produto['url'] == null): ?>
                                            <img src="<?php echo BASE_ASS_C; ?>images/semfoto.jpg" width="500px" height="1000" alt="">
                                        <?php else: ?>
                                            <img src="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $produto['url']; ?>" width="500px" height="1000" alt="">
                                        <?php endif; ?>
                                        <div class="product-hover">
                                            <!-- <a href="#" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i>Carrinho</a> -->
                                            <a href="/visualizar/produto/<?php echo $produto[0]; ?>" class="view-details-link"><i class="fa fa-link"></i> Detalhes</a>
                                        </div>
                                    </div>

                                    <h2><a href="/visualizar/produto/<?php echo $produto[0]; ?>"><?php echo $produto['nome_pro']; ?></a></h2>

                                    <div class="product-carousel-price">
                                        <ins><?php echo 'R$' . number_format($produto['preco'], 2, ',', '.'); ?></ins> <del><?php echo ($produto['preco_antigo'] == 0.00)?'':'R$' . number_format($produto['preco_antigo'], 2, ',', '.'); ?></del>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End main content area -->

<?php if (!empty($marcasImg)) : ?>
    <div class="brands-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-title">Nossas marcas</h2>
                    <div class="brand-wrapper">
                        <div class="brand-list">
                            <?php foreach ($marcasImg as $img) : ?>
                                <img id="imagem" src="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $img['marca_img']; ?>" alt="Nossas marcas">
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="product-widget-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="single-product-widget">
                    <h2 class="product-wid-title">Mais vendidos</h2>
                    <!-- <div class="single-wid-product">
                        <a href="single-product.html"><img src="img/product-thumb-1.jpg" alt="" class="product-thumb"></a>
                        <h2><a href="single-product.html">Sony Smart TV - 2015</a></h2>
                        <div class="product-wid-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="product-wid-price">
                            <ins>R$400.00</ins> <del>R$425.00</del>
                        </div>
                    </div>
                    <div class="single-wid-product">
                        <a href="single-product.html"><img src="img/product-thumb-2.jpg" alt="" class="product-thumb"></a>
                        <h2><a href="single-product.html">Apple new mac book 2015</a></h2>
                        <div class="product-wid-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="product-wid-price">
                            <ins>R$400.00</ins> <del>R$425.00</del>
                        </div>
                    </div>
                    <div class="single-wid-product">
                        <a href="single-product.html"><img src="img/product-thumb-3.jpg" alt="" class="product-thumb"></a>
                        <h2><a href="single-product.html">Apple new i phone 6</a></h2>
                        <div class="product-wid-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="product-wid-price">
                            <ins>R$400.00</ins> <del>R$425.00</del>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="single-product-widget">
                    <h2 class="product-wid-title">Vistos recentemente</h2>
                    <!-- <div class="single-wid-product">
                        <a href="single-product.html"><img src="img/product-thumb-4.jpg" alt="" class="product-thumb"></a>
                        <h2><a href="single-product.html">Sony playstation microsoft</a></h2>
                        <div class="product-wid-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="product-wid-price">
                            <ins>R$400.00</ins> <del>R$425.00</del>
                        </div>
                    </div>
                    <div class="single-wid-product">
                        <a href="single-product.html"><img src="img/product-thumb-1.jpg" alt="" class="product-thumb"></a>
                        <h2><a href="single-product.html">Sony Smart Air Condtion</a></h2>
                        <div class="product-wid-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="product-wid-price">
                            <ins>R$400.00</ins> <del>R$425.00</del>
                        </div>
                    </div>
                    <div class="single-wid-product">
                        <a href="single-product.html"><img src="img/product-thumb-2.jpg" alt="" class="product-thumb"></a>
                        <h2><a href="single-product.html">Samsung gallaxy note 4</a></h2>
                        <div class="product-wid-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="product-wid-price">
                            <ins>R$400.00</ins> <del>R$425.00</del>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="single-product-widget">
                    <h2 class="product-wid-title">Novos produtos</h2>
                    <?php if (!empty($produtos)) : ?>
                        <?php $i = 0; ?>
                        <?php foreach ($produtos as $produto) : ?>
                            <?php $i++; ?>
                            <?php if ($i > 3) break; ?>
                            <div class="single-wid-product">
                                <a href="/visualizar/produto/<?php echo $produto[0]; ?>">
                                    <?php if($produto['url'] == null): ?>    
                                        <img src="<?php echo BASE_ASS_C; ?>images/semfoto.jpg" width="500px" height="1000" alt="" class="product-thumb">
                                    <?php else: ?>
                                        <img src="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $produto['url']; ?>" alt="" class="product-thumb">
                                    <?php endif; ?>
                                </a>
                                <h2><a href="/visualizar/produto/<?php echo $produto[0]; ?>"><?php echo $produto['nome_pro'] ?></a></h2>
                                <div class="product-wid-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product-wid-price">
                                    <ins><?php echo 'R$' . number_format($produto['preco'], 2, ',', '.'); ?></ins> <del> <?php echo ($produto['preco_antigo'] == 0.00)?'':'R$' . number_format($produto['preco_antigo'], 2, ',', '.'); ?></del>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End product widget area -->

<?php $render('commerce/lay01/footer', ['dados' => $dados]); ?>

<script>
    $(".bx-viewport").css('height','200px');
</script>