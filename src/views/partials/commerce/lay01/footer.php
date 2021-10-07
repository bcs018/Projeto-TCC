<div class="footer-top-area">

    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="footer-about-us">
                    <h2><span><?php echo $dados['nome_fantasia']; ?></span></h2>
                    <br>
                    <div class="footer-social">
                        <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-youtube"></i></a>
                        <a href="#" target="_blank"><i class="fa fa-linkedin"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="footer-menu">
                    <h2 class="footer-wid-title">Confira também </h2>
                    <ul>
                        <li><a href="/cliente/painel">Minha conta</a></li>
                        <li><a href="/carrinho">Carrinho</a></li>
                        <li><a href="/produtos">Produtos</a></li>
                        <li><a href="#">Sobre</a></li>
                        <li><a href="/login/c">Login</a></li>
                    </ul>
                </div>
            </div>

            <?php 
            use src\controllers\commerce\CategoriaController;

            $cat = new CategoriaController;

            $cats = $cat->listaCategorias();
            ?>

            <div class="col-md-4 col-sm-6">
                <div class="footer-menu">
                    <h2 class="footer-wid-title">Categorias</h2>
                    <ul>
                    <?php foreach($cats as $dado): ?>                               
                         <?php echo '<li><a href="/produtos/categoria/'.$dado['categoria_id'].'">'.$dado['nome_cat'].'</a></li>'; ?>
                            <?php 
                            if(count($dado['subs'])>0){
                                $render("commerce/lay01/subcategoria_footer", array(
                                    'subs' => $dado['subs'],
                                    'level' => 1
                                ));
                            }
                            ?>
                    <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> <!-- End footer top area -->

<div class="footer-bottom-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="copyright">
                        <p>&copy; <?php echo date('Y').' '. $dados['nome_fantasia']; ?>. All Rights Reserved. <a href="http://www.freshdesignweb.com"
                                target="_blank">freshDesignweb.com</a></p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="footer-card-icon">
                        <i class="fa fa-cc-discover"></i>
                        <i class="fa fa-cc-mastercard"></i>
                        <i class="fa fa-cc-paypal"></i>
                        <i class="fa fa-cc-visa"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> 

<!-- Jquery -->
<!-- <script src="<?php //echo BASE_ASS; ?>adminlte/plugins/jquery/jquery.min.js"></script> -->
<script src="https://code.jquery.com/jquery.min.js"></script>

<!-- Bootstrap JS form CDN -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<!-- jQuery sticky menu -->
<script src="<?php echo BASE_ASS_C; ?>lay01/js/owl.carousel.min.js"></script>
<script src="<?php echo BASE_ASS_C; ?>lay01/js/jquery.sticky.js"></script>

<!-- jQuery easing -->
<script src="<?php echo BASE_ASS_C; ?>lay01/js/jquery.easing.1.3.min.js"></script>
<!-- Mask -->
<script src="<?php echo BASE_ASS; ?>js/jquery.mask.min.js"></script>
<!-- Main Script -->
<script src="<?php echo BASE_ASS_C; ?>lay01/js/main.js"></script>
<script src="<?php echo BASE_ASS_C; ?>lay01/js/calculaPreco.js"></script>
<script src="<?php echo BASE_ASS_C; ?>lay01/js/calculaFrete.js"></script>
<script src="<?php echo BASE_ASS_C; ?>lay01/js/login.js"></script>
<script src="<?php echo BASE_ASS_C; ?>js/validaSenha.js"></script>
<script src="<?php echo BASE_ASS_C; ?>js/selecionaPgm.js"></script>
<script src="<?php echo BASE_ASS_C; ?>js/getCep.js"></script>

<!-- Slider -->
<script type="text/javascript" src="<?php echo BASE_ASS_C; ?>lay01/js/bxslider.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_ASS_C; ?>lay01/js/script.slider.js"></script>
</body>

</html>