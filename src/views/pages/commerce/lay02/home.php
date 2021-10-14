<?php $render('commerce/lay02/header', ['title' => $dados['nome_fantasia'] . ' | Home', 'layout' => $dados, 'carrinho' => $carrinho]); ?>
<?php 
if(isset($_SESSION['message'])){
    echo $_SESSION['message'];
    unset($_SESSION['message']);
} 
?>
<!-- Slider -->
<section class="section-slide">
    <div class="wrap-slick1 rs1-slick1">
        <div class="slick1">

            <?php if (!empty($prodBanner)) : ?>
                <?php foreach ($prodBanner as $pb) : ?>
                    <div class="item-slick1" style="background-image: url(<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $pb['banner_img']; ?>" alt="Slide <?php echo $pb['nome_pro']; ?>);">
                        <div class="container h-full">
                            <div class="flex-col-l-m h-full p-t-100 p-b-30">
                                <!-- <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                                    <span class="ltext-202 cl2 respon2">
                                        
                                    </span>
                                </div> -->

                                <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                                    <h2 class="ltext-104 cl2 p-t-19 p-b-43 respon1">
                                        <?php echo $pb['nome_pro']; ?>
                                    </h2>
                                </div>

                                <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                                    <a href="/visualizar/produto/<?php echo $pb[0]; ?>"
                                        class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                        Visualizar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>


<!-- Banner -->
<!-- <div class="sec-banner bg0">
    <div class="flex-w flex-c-m">
        <div class="size-202 m-lr-auto respon4">
            <div class="block1 wrap-pic-w">
                <img src="images/banner-04.jpg" alt="IMG-BANNER">

                <a href="product.html" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                    <div class="block1-txt-child1 flex-col-l">
                        <span class="block1-name ltext-102 trans-04 p-b-8">
                            Women
                        </span>

                        <span class="block1-info stext-102 trans-04">
                            Spring 2018
                        </span>
                    </div>

                    <div class="block1-txt-child2 p-b-4 trans-05">
                        <div class="block1-link stext-101 cl0 trans-09">
                            Shop Now
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="size-202 m-lr-auto respon4">
            <div class="block1 wrap-pic-w">
                <img src="images/banner-05.jpg" alt="IMG-BANNER">

                <a href="product.html" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                    <div class="block1-txt-child1 flex-col-l">
                        <span class="block1-name ltext-102 trans-04 p-b-8">
                            Men
                        </span>

                        <span class="block1-info stext-102 trans-04">
                            Spring 2018
                        </span>
                    </div>

                    <div class="block1-txt-child2 p-b-4 trans-05">
                        <div class="block1-link stext-101 cl0 trans-09">
                            Shop Now
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="size-202 m-lr-auto respon4">
            <div class="block1 wrap-pic-w">
                <img src="images/banner-06.jpg" alt="IMG-BANNER">

                <a href="product.html" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                    <div class="block1-txt-child1 flex-col-l">
                        <span class="block1-name ltext-102 trans-04 p-b-8">
                            Bags
                        </span>

                        <span class="block1-info stext-102 trans-04">
                            New Trend
                        </span>
                    </div>

                    <div class="block1-txt-child2 p-b-4 trans-05">
                        <div class="block1-link stext-101 cl0 trans-09">
                            Shop Now
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div> -->


<!-- Product -->
<section class="sec-product bg0 p-t-100 p-b-50">
    <div class="container">
        <div class="p-b-32">
            <h3 class="ltext-105 cl5 txt-center respon1">
                Visão geral da loja
            </h3>
        </div>

        <!-- Tab01 -->
        <div class="tab01">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item p-b-10">
                    <a class="nav-link active" data-toggle="tab" href="#best-seller" role="tab">Recentes</a>
                </li>

                <!-- <li class="nav-item p-b-10">
                    <a class="nav-link" data-toggle="tab" href="#featured" role="tab">Featured</a>
                </li>

                <li class="nav-item p-b-10">
                    <a class="nav-link" data-toggle="tab" href="#sale" role="tab">Sale</a>
                </li>

                <li class="nav-item p-b-10">
                    <a class="nav-link" data-toggle="tab" href="#top-rate" role="tab">Top Rate</a>
                </li> -->
            </ul>

            <div class="tab-content p-t-50">
                <div class="tab-pane fade show active" id="best-seller" role="tabpanel">
                    <div class="wrap-slick2">
                        <div class="slick2">

                            <?php if (!empty($produtos)) : ?>
                                <?php foreach ($produtos as $produto) : ?>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <a href="/visualizar/produto/<?php echo $produto[0]; ?>">
                                                    <?php if($produto['url'] == null): ?>
                                                        <img src="<?php echo BASE_ASS_C; ?>images/semfoto.jpg" alt="IMG-PRODUCT">
                                                    <?php else: ?>
                                                        <img id="prod-tam" src="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $produto['url']; ?>" alt="Imagem produto">
                                                    <?php endif; ?>
                                                </a>
                                                <a href="/visualizar/produto/<?php echo $produto[0]; ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                                    Visualizar
                                                </a>
                                            </div>

                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="/visualizar/produto/<?php echo $produto[0]; ?>"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        <?php echo $produto['nome_pro']; ?>
                                                    </a>

                                                    <span class="stext-105 cl3">
                                                        <?php echo 'R$' . number_format($produto['preco'], 2, ',', '.'); ?> &nbsp; &nbsp;
                                                        <del style="color: #ab0b00;"><?php echo ($produto['preco_antigo'] == 0.00)?'':'R$' . number_format($produto['preco_antigo'], 2, ',', '.'); ?></del>
                                                    </span>
                                                </div>

                                                <!-- <div class="block2-txt-child2 flex-r p-t-3">
                                                    <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                        <img class="icon-heart1 dis-block trans-04"
                                                            src="images/icons/icon-heart-01.png" alt="ICON">
                                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                            src="images/icons/icon-heart-02.png" alt="ICON">
                                                    </a>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($marcasImg)) : ?>

    <section class="sec-product bg0 p-t-100 p-b-50">
        <div class="container">
            <div class="p-b-32">
                <h3 class="ltext-105 cl5 txt-center respon1">
                    Nossas marcas
                </h3>
            </div>

            <!-- Tab01 -->
            <div class="tab01">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item p-b-10">
                        <a class="nav-link active" data-toggle="tab" href="#best-seller" role="tab">Marcas</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-t-50">
                    <!-- - -->
                    <div class="tab-pane fade show active" id="best-seller" role="tabpanel">
                        <!-- Slide2 -->
                        <div class="wrap-slick2">
                            <div class="slick2">
                                <?php foreach ($marcasImg as $img) : ?>

                                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                        <!-- Block2 -->
                                        <div class="block2">
                                            <div class="block2-pic hov-img0">
                                                <img src="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $img['marca_img']; ?>" alt="Imagem Marca">
                                            </div>
                                            <div class="block2-txt flex-w flex-t p-t-14">
                                                <div class="block2-txt-child1 flex-col-l ">
                                                    <a href="#"
                                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                        <?php echo $img['nome_mar']; ?>
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<br><br><br><br>
<br>
<?php $render('commerce/lay02/footer', ['dados' => $dados]); ?>