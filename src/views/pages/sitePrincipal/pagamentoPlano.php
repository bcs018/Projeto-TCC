<?php $render('sitePrincipal/header', ['title' => 'BW Commerce | Pagamento']); ?>

<?php 
if(!isset($_SESSION['person'])){
    header('Location: /crie-sua-loja');
}

if($plano == false){
    $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">Plano inexistente, escolha outro.</div><br>';
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
<h2><?php echo $_SESSION['person']['name']; ?>, estamos quase lá, preencha os dados para pagamento.</h2>
</center>



<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="wrapper">
                    <div class="row">
                        <div class="col-lg">
                            <div>
                                <div id="retorno"></div>
                                <br>
                                <form method="POST" id="cadastro" name="cadastro" class="contactForm">
                                    <div class="col-md">
                                        <fieldset class="border p-2">
                                            <legend class="w-auto">Dados para pagamento</legend>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label" for="name">Número do cartão</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp</div>
                                                        <input type="text" class="form-control" name="nome_usu" id="nome_usu" placeholder="Nome" autofocus>
                                                        <div id="error1"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label" for="name">Nome completo</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <input type="text" class="form-control" name="sobrenome_usu" id="sobrenome_usu" placeholder="Sobrenome">
                                                        <div id="error2"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label" for="email">Data de vencimento</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <input type="email" class="form-control" name="email_usu" id="email_usu" placeholder="E-mail">
                                                        <div id="error3"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label" for="email">Código de segurnça</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <input type="text" class="form-control" name="celular" id="celular" placeholder="Celular">
                                                        <div id="error4"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label" for="subject">CPF do titular do cartão</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <input type="text" class="form-control" name="cpf_usu" id="cpf_usu" placeholder="CPF">
                                                        <div id="error5"></div>
                                                    </div>
                                                </div>
        
                                            </div>
                                        </fieldset>
                                    </div>
                                    <br>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="submit" value="Finalizar" class="btn btn-success">
                                        </div>
                                    </div>

                                    <div id="loading"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="wrapper">
                    <div class="row no-gutters justify-content-center">
                        <div class="col-lg col-md-7 order-md-last d-flex align-items-stretch">
                            <div>
                                <div id="retorno"></div>
                                <br>
                                <form method="POST" id="cadastro" name="cadastro" class="contactForm">
                                    <div class="col-md">
                                        <fieldset class="border p-2">
                                            <legend class="w-auto">Informações do plano</legend>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label">Nome do plano:</label>
                                                        <p><?php echo $plano['nome_plano']; ?></p>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label" for="name">Direitos:</label>
                                                        <?php $direitos = explode(";", $plano['descricao_plano']); ?>
                                                        <p>
                                                            <?php foreach($direitos as $direito): ?>
                                                            <?php echo $direito; ?>. <br>
                                                            <?php endforeach; ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label" for="email">Preço:</label>
                                                        <p></p>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label" for="email">Celular</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <input type="text" class="form-control" name="celular" id="celular" placeholder="Celular">
                                                        <div id="error4"></div>
                                                    </div>
                                                </div>

                                                
                                            </div>
                                        </fieldset>
                                    </div>
                                    <br>
                                    

                                    <div id="loading"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




<br><br><br><br>
<?php $render('sitePrincipal/footer') ?>