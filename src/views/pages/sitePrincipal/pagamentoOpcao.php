<?php $render('sitePrincipal/header', ['title' => 'BW Commerce | Opção de pagamento']); ?>

<?php
if (!isset($_SESSION['person'])) {
    header('Location: /crie-sua-loja');
}

if ($plano == false) {
    $_SESSION['message'] = '<div class="alert alert-danger" role="alert">Plano inexistente, escolha outro.</div><br>';
    header('Location: /crie-sua-loja/pagamento');
}
?>

<section class="hero-wrap hero-wrap-2" style="background-image: url('<?php echo BASE_ASS; ?>images/pg1.jpg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs mb-2"><span class="mr-2">Home &nbsp;|</span> <span>Crie sua loja &nbsp;| &nbsp;</span> <span>Pagamento</span> </p>
                <h1 class="mb-0 bread">Pagamento</h1>
            </div>
        </div>
    </div>
</section>

<br><br><br>

<center>
    <h2><?php echo $_SESSION['person']['name']; ?>, escolha uma opção de pagamento.</h2>
    <br>
</center>

<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="wrapper">
                    <div class="row">
                        <div class="col-lg">
                            <div>
                                <div id="retorno"></div>
                                <br>
                                <form action="" method="post">
                                    <div class="col-md">
                                        <fieldset class="border p-2">
                                            <legend class="w-auto">Escolha uma opção para pagamento</legend>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="gridRadios" id="cartao" value="cartao" checked>
                                                        
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="col-md-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="gridRadios" id="boleto" value="boleto">
                                                        <label class="form-check-label" for="boleto">
                                                            Cartão de crédito
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <br>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button class="btn btn-success finalizar">Finalizar</button>
                                        </div>
                                    </div>

                                    <div id="loading"></div>
                                </form>





                                <ul class="payment-methods">
                                    <li class="payment-method paypal">
                                        <input name="payment_methods" type="radio" id="paypal">
                                        <label for="paypal">PayPal</label>
                                    </li>

                                    <li class="payment-method pagseguro">
                                        <input name="payment_methods" type="radio" id="pagseguro">
                                        <label for="pagseguro">PagSeguro</label>
                                    </li>

                                    <li class="payment-method bankslip">
                                        <input name="payment_methods" type="radio" id="bankslip">
                                        <label for="bankslip">Boleto</label>
                                    </li>
                                </ul>






                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<br><br><br><br><br>

<?php $render('sitePrincipal/footer') ?>