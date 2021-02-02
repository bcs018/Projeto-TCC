<?php $render('sitePrincipal/header'); ?>

<section class="hero-wrap hero-wrap-2" style="background-image: url('<?php echo BASE_ASS; ?>images/bg_cads2.jpg');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs mb-2"><span class="mr-2"><a href="/">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Crie sua Loja <i class="ion-ios-arrow-forward"></i></span></p>
                <h1 class="mb-0 bread">Crie sua loja</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="wrapper">
                    <div class="row no-gutters justify-content-center">
                        <div class="col-lg col-md-7 order-md-last d-flex align-items-stretch">
                            <div class="contact-wrap w-100 p-md-5 p-4">
                                <h2 class="mb-4">Cadastre-se para criar sua loja</h2>
                                <div id="form-message-warning" class="mb-4"></div>
                                <br><br>
                                <form method="POST" id="contactForm" name="contactForm" class="contactForm">
                                    <div class="col-md">
                                        <fieldset class="border p-2">
                                            <legend class="w-auto">Pessoais</legend>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label" for="name">Nome completo</label>
                                                        <input type="text" class="form-control" name="name" id="name" placeholder="Nome completo">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label" for="email">E-mail</label>
                                                        <input type="email" class="form-control" name="email" id="email" placeholder="E-mail">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label" for="subject">CPF</label>
                                                        <input type="number" class="form-control" name="subject" id="subject" placeholder="CPF">
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <br>
                                    <div class="col-md">
                                        <fieldset class="border p-2">
                                            <legend class="w-auto">Endereço</legend>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label" for="#">Rua</label>
                                                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Rua">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label" for="subject">Bairro</label>
                                                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Bairro">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label" for="subject">Número</label>
                                                        <input type="number" class="form-control" name="subject" id="subject" placeholder="Número">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label" for="subject">CEP</label>
                                                        <input type="number" class="form-control" name="subject" id="subject" placeholder="CEP">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label" for="subject">Estado</label>
                                                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Estado">
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset><br>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="submit" value="Send Message" class="btn btn-primary">
                                            <div class="submitting"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php $render('sitePrincipal/footer'); ?>