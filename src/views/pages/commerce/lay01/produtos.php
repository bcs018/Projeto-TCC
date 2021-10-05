<?php $render('commerce/lay01/header', ['title' => $dados['nome_fantasia'] . ' | Produtos', 'layout' => $dados]); ?>

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">
        <?php if(isset($txt)): ?>
            <h4>Pesquisa por: <?php echo $txt ?></h4><br>
        <?php endif; ?>
            <?php if(!$produtos): ?>
                <?php
                if(isset($_SESSION['message'])){
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                }
                ?>
            <?php else: ?>
                <?php foreach($produtos as $p): ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="single-product">
                            <div class="product-f-image">
                                <?php if($p['url'] == null): ?>
                                    <img src="<?php echo BASE_ASS_C; ?>/images/semfoto.jpg" width="500px" height="1000" alt="">
                                <?php else: ?>
                                    <img src="<?php echo BASE_ASS_C; ?>/images_commerce/<?php echo $p['url']; ?>" width="500px" height="1000" alt="">
                                <?php endif; ?>
                                <div class="product-hover">
                                    <!-- <a href="#" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i>Carrinho</a> -->
                                    <a href="/visualizar/produto/<?php echo $p[0]; ?>" class="view-details-link"><i class="fa fa-link"></i> Detalhes</a>
                                </div>
                            </div>

                            <h2><a href="/visualizar/produto/<?php echo $p[0]; ?>"><?php echo $p['nome_pro']; ?></a></h2>

                            <div class="product-carousel-price">
                                <ins><?php echo 'R$' . number_format($p['preco'], 2, ',', '.'); ?></ins> <del><?php echo ($p['preco_antigo'] == 0.00) ? '' : 'R$' . number_format($p['preco_antigo'], 2, ',', '.'); ?></del>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- <div class="row">
            <div class="col-md-12">
                <div class="product-pagination text-center">
                    <nav>
                        <ul class="pagination">
                            <li>
                                <a href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li>
                                <a href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div> -->
    </div>
</div>

<?php $render('commerce/lay01/footer', ['dados' => $dados]); ?>