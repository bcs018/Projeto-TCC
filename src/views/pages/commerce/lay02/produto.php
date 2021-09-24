<?php $render('commerce/lay02/header', ['title' => $dados['nome_fantasia'] . ' | '. $produto[0]['nome_pro'], 'layout' => $dados, 'carrinho' => $carrinho]); ?>

<section class="sec-product-detail bg0 p-t-65 p-b-60">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-7 p-b-30">
                <div class="p-l-25 p-r-30 p-lr-0-lg">
                    <div class="wrap-slick3 flex-sb flex-w">
                        <div class="wrap-slick3-dots"></div>
                        <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                        <div class="slick3 gallery-lb">
                            <?php foreach ($produto as $p) : ?>
                                <div class="item-slick3" data-thumb="
                                                                        <?php if($p['url'] == null): ?>
                                                                            <?php echo BASE_ASS_C; ?>images/semfoto.jpg
                                                                        <?php else: ?>
                                                                            <?php echo BASE_ASS_C; ?>images_commerce/<?php echo $p['url']; ?>
                                                                        <?php endif; ?>
                                                                    ">
                                    <div class="wrap-pic-w pos-relative">
                                        <?php if($p['url'] == null): ?>
                                            <img src="<?php echo BASE_ASS_C; ?>images/semfoto.jpg" alt="Sem Imagem">
                                        <?php else: ?>
                                            <img src="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $p['url']; ?>" alt="IMAGEM-PRODUTO">
                                        <?php endif; ?>
                                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                            href="
                                                    <?php if($p['url'] == null): ?>
                                                        <?php echo BASE_ASS_C; ?>images/semfoto.jpg">
                                                    <?php else: ?>
                                                        <?php echo BASE_ASS_C; ?>/images_commerce/<?php echo $p['url']; ?>">
                                                    <?php endif; ?>
                                            <i class="fa fa-expand"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-5 p-b-30">
                <div class="p-r-50 p-t-5 p-lr-0-lg">
                    <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                        <?php echo $produto[0]['nome_pro']; ?>
                    </h4>

                    <span class="mtext-106 cl2">
                        <del><?php echo ($produto[0]['preco_antigo'] == 0.00) ? '' : 'De: R$' . number_format($produto[0]['preco_antigo'], 2, ',', '.'); ?></del> <br><br> <ins style="font-size:x-large;"><?php echo 'Por: R$' . number_format($produto[0]['preco'], 2, ',', '.'); ?></ins> 
                    </span>

                    <p class="stext-102 cl3 p-t-23">
                        <?php echo $produto[0]['descricao']; ?>
                    </p>

                    <!--  -->
                    <div class="p-t-33">
                        <!-- <div class="flex-w flex-r-m p-b-10">
                            <div class="size-203 flex-c-m respon6">
                                Size
                            </div>

                            <div class="size-204 respon6-next">
                                <div class="rs1-select2 bor8 bg0">
                                    <select class="js-select2" name="time">
                                        <option>Choose an option</option>
                                        <option>Size S</option>
                                        <option>Size M</option>
                                        <option>Size L</option>
                                        <option>Size XL</option>
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                            </div>
                        </div> -->

                        

                        <div class="flex-w flex-r-m p-b-10">
                            <div class="size-204 flex-w flex-m respon6-next">
                                <!-- <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                    </div>

                                    <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product"
                                        value="1">

                                    <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                    </div>
                                </div> -->


                                <form action="/add-carrinho" method="POST" class="cart">
                                    <input type="hidden" name="id_produto" value="<?php echo $produto[0][0]; ?>">
                                    <button class="add_to_cart_button flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04" type="submit">Comprar</button>
                                </form>


                                <!-- <button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                    Adicionar ao carrinho
                                </button> -->
                            </div>
                        </div>


                    </div>

                    <form id="frete">
                        <div style="padding-left: 0;" class="flex-w flex-m p-l-100 p-t-40 respon7">
                            <input type="text" name="cepCalc" id="cepCalc" class="form-control" placeholder="Calcular Frete">
                            <input value="<?php echo $produto[0][0]; ?>" name="id" id="id" type="hidden">
                            <input value="1" name="flag" id="flag" type="hidden">
                            <br><br><br>                    
                            <button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04" type="submit">Calcular</button>                        
                            <br><br><br><br>
                            <div id="calcfrete"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="bor10 m-t-50 p-t-43 p-b-40">
            <!-- Tab01 -->
            <div class="tab01">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item p-b-10">
                        <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Descrição</a>
                    </li>

                    <!-- <li class="nav-item p-b-10">
                        <a class="nav-link" data-toggle="tab" href="#information" role="tab">Additional information</a>
                    </li>

                    <li class="nav-item p-b-10">
                        <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews (1)</a>
                    </li> -->
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-t-43">
                    <!-- - -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <div class="how-pos2 p-lr-15-md">
                            <p class="stext-102 cl6">
                                <?php echo $produto[0]['descricao']; ?>
                            </p>
                        </div>
                    </div>

                    <!-- - -->
                    <div class="tab-pane fade" id="information" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                <ul class="p-lr-28 p-lr-15-sm">
                                    <li class="flex-w flex-t p-b-7">
                                        <span class="stext-102 cl3 size-205">
                                            Weight
                                        </span>

                                        <span class="stext-102 cl6 size-206">
                                            0.79 kg
                                        </span>
                                    </li>

                                    <li class="flex-w flex-t p-b-7">
                                        <span class="stext-102 cl3 size-205">
                                            Dimensions
                                        </span>

                                        <span class="stext-102 cl6 size-206">
                                            110 x 33 x 100 cm
                                        </span>
                                    </li>

                                    <li class="flex-w flex-t p-b-7">
                                        <span class="stext-102 cl3 size-205">
                                            Materials
                                        </span>

                                        <span class="stext-102 cl6 size-206">
                                            60% cotton
                                        </span>
                                    </li>

                                    <li class="flex-w flex-t p-b-7">
                                        <span class="stext-102 cl3 size-205">
                                            Color
                                        </span>

                                        <span class="stext-102 cl6 size-206">
                                            Black, Blue, Grey, Green, Red, White
                                        </span>
                                    </li>

                                    <li class="flex-w flex-t p-b-7">
                                        <span class="stext-102 cl3 size-205">
                                            Size
                                        </span>

                                        <span class="stext-102 cl6 size-206">
                                            XL, L, M, S
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- - -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                <div class="p-b-30 m-lr-15-sm">
                                    <!-- Review -->
                                    <div class="flex-w flex-t p-b-68">
                                        <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
                                            <img src="images/avatar-01.jpg" alt="AVATAR">
                                        </div>

                                        <div class="size-207">
                                            <div class="flex-w flex-sb-m p-b-17">
                                                <span class="mtext-107 cl2 p-r-20">
                                                    Ariana Grande
                                                </span>

                                                <span class="fs-18 cl11">
                                                    <i class="zmdi zmdi-star"></i>
                                                    <i class="zmdi zmdi-star"></i>
                                                    <i class="zmdi zmdi-star"></i>
                                                    <i class="zmdi zmdi-star"></i>
                                                    <i class="zmdi zmdi-star-half"></i>
                                                </span>
                                            </div>

                                            <p class="stext-102 cl6">
                                                Quod autem in homine praestantissimum atque optimum est, id deseruit.
                                                Apud ceteros autem philosophos
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Add review -->
                                    <form class="w-full">
                                        <h5 class="mtext-108 cl2 p-b-7">
                                            Add a review
                                        </h5>

                                        <p class="stext-102 cl6">
                                            Your email address will not be published. Required fields are marked *
                                        </p>

                                        <div class="flex-w flex-m p-t-50 p-b-23">
                                            <span class="stext-102 cl3 m-r-16">
                                                Your Rating
                                            </span>

                                            <span class="wrap-rating fs-18 cl11 pointer">
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <i class="item-rating pointer zmdi zmdi-star-outline"></i>
                                                <input class="dis-none" type="number" name="rating">
                                            </span>
                                        </div>

                                        <div class="row p-b-25">
                                            <div class="col-12 p-b-5">
                                                <label class="stext-102 cl3" for="review">Your review</label>
                                                <textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10"
                                                    id="review" name="review"></textarea>
                                            </div>

                                            <div class="col-sm-6 p-b-5">
                                                <label class="stext-102 cl3" for="name">Name</label>
                                                <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="name" type="text"
                                                    name="name">
                                            </div>

                                            <div class="col-sm-6 p-b-5">
                                                <label class="stext-102 cl3" for="email">Email</label>
                                                <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email"
                                                    type="text" name="email">
                                            </div>
                                        </div>

                                        <button
                                            class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
                                            Submit
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
        <span class="stext-107 cl6 p-lr-25"> </span>
        <span class="stext-107 cl6 p-lr-25"> </span>
    </div>
</section>


<!-- Related Products -->
<section class="sec-relate-product bg0 p-t-45 p-b-105">
    <div class="container">
        <div class="p-b-45">
            <h3 class="ltext-106 cl5 txt-center">
                Produtos relacionados
            </h3>
        </div>

        <!-- Slide2 -->
        <div class="wrap-slick2">
            <div class="slick2">

            <?php foreach ($produtosRel as $pr) : ?>
                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                    <!-- Block2 -->
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <?php if ($pr['url'] == null) : ?>
                                <img src="<?php echo BASE_ASS_C; ?>images/semfoto.jpg" alt="Sem imagem">
                            <?php else: ?>
                                <img src="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $pr['url']; ?>" alt="Produto <?php echo $pr['nome_pro']; ?>">
                            <?php endif; ?>

                            <a href="/visualizar/produto/<?php echo $pr[0] ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                Visualizar
                            </a>
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">
                                <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    <h4><?php echo $pr['nome_pro']; ?></h4>
                                </a>

                                <span class="stext-105 cl3">
                                <h6>
                                    <b></b> <del><?php echo ($pr['preco_antigo'] == 0.00) ? '' : 'De: R$' . number_format($pr['preco_antigo'], 2, ',', '.'); ?></del> <br><br>  <b>Por</b>: <ins><?php echo 'R$' . number_format($pr['preco'], 2, ',', '.'); ?></ins> 
                                </h6>
                                </span>
                            </div>

                            <!-- <div class="block2-txt-child2 flex-r p-t-3">
                                <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                    <img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
                                        alt="ICON">
                                    <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                        src="images/icons/icon-heart-02.png" alt="ICON">
                                </a>
                            </div> -->
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<?php $render('commerce/lay02/footer', ['dados' => $dados]); ?>

<script type="text/javascript">
    $('#cepCalc').mask("00000000");
</script>