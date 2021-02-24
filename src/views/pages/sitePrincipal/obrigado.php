<?php $render('sitePrincipal/header', ['title' => 'BW Commerce | Obrigado']); ?>

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
    <h2><?php echo (isset($_SESSION['person']['name']))?$_SESSION['person']['name']:'Muito'; ?> obrigado por nos escolher!.</h2>
    <br>
</center>

<h4>Para acessar seu boleto clique <a href="<?php echo $link; ?>">aqui</a> ou faça login para emitir a segunda via</h4>

<br><br><br><br><br>

<?php $render('sitePrincipal/footer') ?>