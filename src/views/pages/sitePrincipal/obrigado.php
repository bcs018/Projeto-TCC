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
    <h1><?php echo (isset($_SESSION['person']['name']))?$_SESSION['person']['name']:'Muito'; ?> obrigado por nos escolher!</h1>
    <br>
</center>
<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h5>Geramos seu boleto para pagamento, lembrando que o pagamento pode ser confirmado em até 3 dias úteis.</h5> <br>
                <h5>Para acessar seu boleto clique <a target="_blank" href="<?php echo $link; ?>">aqui</a> ou faça login para emitir a segunda via.</h5><br>
                <h5>A data do vencimento é após 4 dias a partir da data de compra.</h5>
                <br><br>
                <a target="_blank" class="btn btn-success" href="<?php echo $link ?>">Abrir boleto</a>
            </div>
        </div>
    </div>
</section>

<br><br><br><br><br>

<?php $render('sitePrincipal/footer') ?>