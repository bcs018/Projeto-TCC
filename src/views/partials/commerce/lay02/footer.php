<!-- Footer -->
<?php 
use src\controllers\commerce\CategoriaController;
$cat = new CategoriaController;
$cats = $cat->listaCategorias();
?>

<footer class="bg3 p-t-75 p-b-32">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    Categorias
                </h4>

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

            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    Confira também
                </h4>

                <ul>
                    <li class="p-b-10">
                        <a href="/cliente/painel">
                            Minha conta
                        </a>
                    </li>

                    <li class="p-b-10">
                        <a href="/carrinho">
                            Carrinho
                        </a>
                    </li>

                    <li class="p-b-10">
                        <a href="/produtos">
                            Produtos
                        </a>
                    </li>

                    <li class="p-b-10">
                        <a href="#">
                            Sobre
                        </a>
                    </li>

                    <li class="p-b-10">
                        <a href="/login/c">
                            Login
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-sm-6 col-lg-3 p-b-50">
                <?php if($dados['facebook']!='0' || $dados['instagram']!='0' || $dados['linkedin']!='0'): ?>
                    <h4 class="stext-301 cl0 p-b-30">
                        Redes sociais
                    </h4>
                <?php endif; ?>

                <ul>
                    <li class="p-b-10">
                        <?php if($dados['facebook']!='0'): ?>
                            <a href="<?php echo $dados['facebook']; ?>" class="fs-35 cl7 hov-cl1 trans-04 m-r-16">
                                <i class="fa fa-facebook"></i>
                            </a>
                        <?php endif; ?>

                        <?php if($dados['instagram']!='0'): ?>
                            <a href="<?php echo $dados['instagram']; ?>" class="fs-35 cl7 hov-cl1 trans-04 m-r-16">
                                <i class="fa fa-instagram"></i>
                            </a>
                        <?php endif; ?>

                        <?php if($dados['linkedin']!='0'): ?>
                            <a href="<?php echo $dados['linkedin']; ?>" class="fs-35 cl7 hov-cl1 trans-04 m-r-16">
                                <i class="fa fa-linkedin"></i>
                            </a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
            <div class="col-sm-6 col-lg-3 p-b-50">
                <h1>
                    <?php echo $dados['nome_fantasia']; ?>
                </h1>
            </div>
        </div>
    </div>

    <div class="p-t-40">
        <div class="flex-c-m flex-w p-b-18">
            <a href="#" class="m-all-1">
                <img src="<?php echo BASE_ASS_C; ?>lay02/images/icons/icon-pay-01.png" alt="ICON-PAY">
            </a>

            <a href="#" class="m-all-1">
                <img src="<?php echo BASE_ASS_C; ?>lay02/images/icons/icon-pay-02.png" alt="ICON-PAY">
            </a>

            <a href="#" class="m-all-1">
                <img src="<?php echo BASE_ASS_C; ?>lay02/images/icons/icon-pay-03.png" alt="ICON-PAY">
            </a>

        </div>

        <p class="stext-107 cl6 txt-center">
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script>
                document.write(new Date().getFullYear());
            </script> <?php echo $dados['nome_fantasia']; ?> | Made with by <a href="https://colorlib.com"
                target="_blank">Colorlib</a> &amp; distributed by <a href="https://themewagon.com"
                target="_blank">ThemeWagon</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

        </p>
    </div>
    </div>
</footer>

<!-- Back to top -->
<div class="btn-back-to-top" id="myBtn">
    <span class="symbol-btn-back-to-top">
        <i class="zmdi zmdi-chevron-up"></i>
    </span>
</div>

<!--===============================================================================================-->
<script src="<?php echo BASE_ASS_C; ?>lay02/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="<?php echo BASE_ASS_C; ?>lay02/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="<?php echo BASE_ASS_C; ?>lay02/vendor/bootstrap/js/popper.js"></script>
<script src="<?php echo BASE_ASS_C; ?>lay02/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="<?php echo BASE_ASS_C; ?>lay02/vendor/select2/select2.min.js"></script>
<script>
    $(".js-select2").each(function () {
        $(this).select2({
            minimumResultsForSearch: 20,
            dropdownParent: $(this).next('.dropDownSelect2')
        });
    })
</script>
<!--===============================================================================================-->
<script src="<?php echo BASE_ASS_C; ?>lay02/vendor/daterangepicker/moment.min.js"></script>
<script src="<?php echo BASE_ASS_C; ?>lay02/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="<?php echo BASE_ASS_C; ?>lay02/vendor/slick/slick.min.js"></script>
<script src="<?php echo BASE_ASS_C; ?>lay02/js/slick-custom.js"></script>
<!--===============================================================================================-->
<script src="<?php echo BASE_ASS_C; ?>lay02/vendor/parallax100/parallax100.js"></script>
<script>
    $('.parallax100').parallax100();
</script>
<!--===============================================================================================-->
<script src="<?php echo BASE_ASS_C; ?>lay02/vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
<script>
    $('.gallery-lb').each(function () { // the containers for all your galleries
        $(this).magnificPopup({
            delegate: 'a', // the selector for gallery item
            type: 'image',
            gallery: {
                enabled: true
            },
            mainClass: 'mfp-fade'
        });
    });
</script>
<!--===============================================================================================-->
<script src="<?php echo BASE_ASS_C; ?>lay02/vendor/isotope/isotope.pkgd.min.js"></script>
<!--===============================================================================================-->
<script src="<?php echo BASE_ASS_C; ?>lay02/vendor/sweetalert/sweetalert.min.js"></script>
<script>
    $('.js-addwish-b2').on('click', function (e) {
        e.preventDefault();
    });

    $('.js-addwish-b2').each(function () {
        var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
        $(this).on('click', function () {
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass('js-addedwish-b2');
            $(this).off('click');
        });
    });

    $('.js-addwish-detail').each(function () {
        var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

        $(this).on('click', function () {
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass('js-addedwish-detail');
            $(this).off('click');
        });
    });

    /*---------------------------------------------*/

    $('.js-addcart-detail').each(function () {
        var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
        $(this).on('click', function () {
            swal(nameProduct, "is added to cart !", "success");
        });
    });
</script>
<!--===============================================================================================-->
<script src="<?php echo BASE_ASS_C; ?>lay02/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script>
    $('.js-pscroll').each(function () {
        $(this).css('position', 'relative');
        $(this).css('overflow', 'hidden');
        var ps = new PerfectScrollbar(this, {
            wheelSpeed: 1,
            scrollingThreshold: 1000,
            wheelPropagation: false,
        });

        $(window).on('resize', function () {
            ps.update();
        })
    });
</script>
<!--===============================================================================================-->
<script src="<?php echo BASE_ASS_C; ?>lay02/js/main.js"></script>
<script src="<?php echo BASE_ASS_C; ?>lay01/js/calculaPreco.js"></script>
<script src="<?php echo BASE_ASS_C; ?>lay01/js/calculaFrete.js"></script>
<script src="<?php echo BASE_ASS_C; ?>lay01/js/login.js"></script>
<script src="<?php echo BASE_ASS_C; ?>js/validaSenha.js"></script>
<script src="<?php echo BASE_ASS_C; ?>js/selecionaPgm.js"></script>
<script src="<?php echo BASE_ASS_C; ?>js/getCep.js"></script>
<script src="<?php echo BASE_ASS; ?>js/jquery.mask.min.js"></script>


</body>

</html>