<?php $render('sitePrincipal/header', ['title' => 'BW Commerce | Opção de pagamento']); ?>

<?php
/*if (!isset($_SESSION['person'])) {
    header('Location: /crie-sua-loja');
}

if ($plano == false) {
    $_SESSION['message'] = '<div class="alert alert-danger" role="alert">Plano inexistente, escolha outro.</div><br>';
    header('Location: /crie-sua-loja/pagamento');
}*/
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
                                <h1>Boleto</h1>
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