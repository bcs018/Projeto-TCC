<?php $render('sitePrincipal/header', ['title'=>'BW Commerce | Criar Loja']); ?>

<section class="hero-wrap hero-wrap-2" style="background-image: url('<?php echo BASE_ASS; ?>images/bg_cads2.jpg');"
    data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs mb-2"><span class="mr-2">Home &nbsp; | </span> <span>Crie sua Loja<i class="ion-ios-arrow-forward"></i></span></p>
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
                                <h1 class="mb-4">Cadastre-se para criar sua loja</h1>
                                <h6 class="mb-4" style="color: #fa3200;font-weight: bold;">Campos marcados com asterisco
                                    (*) são obrigatórios.</h6>
                                <div id="form-message-warning" class="mb-4"></div>
                                <br>      
                                <div id="retorno"></div>
                                <br>
                                <form method="POST" id="acha_cadastro" name="acha_cadastro" class="contactForm">
                                    <div class="col-md">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h2>Continuar com o pagamento</h2>
                                                <div class="form-group">
                                                    <label class="label" for="cpf_cad">Se você se cadastrou mas ainda não finalizou o pagamento, informe seu CPF abaixo para continuar:</label>
                                                    <input type="text" class="form-control" name="cpf_cad" id="cpf_cad" placeholder="Informe aqui o CPF cadastrado">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="submit" value="Continuar" class="btn btn-success">
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </form>
                                <br><br>
                                <form method="POST" id="cadastro" name="cadastro" class="contactForm">
                                    <div class="col-md">
                                        <h2>Novo cadastro</h2>
                                        <fieldset class="border p-2">
                                            <legend class="w-auto">Pessoais</legend>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label" for="name">Nome</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp</div>
                                                        <input type="text" class="form-control" name="nome_usu"
                                                            id="nome_usu" placeholder="Nome" autofocus>
                                                        <div id="error1"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label" for="name">Sobrenome</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <input type="text" class="form-control" name="sobrenome_usu"
                                                            id="sobrenome_usu" placeholder="Sobrenome">
                                                        <div id="error2"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label" for="email">E-mail</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <input type="email" class="form-control" name="email_usu"
                                                            id="email_usu" placeholder="E-mail">
                                                        <div id="error3"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label" for="email">Celular</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <input type="text" class="form-control" name="celular"
                                                            id="celular" placeholder="Celular">
                                                        <div id="error4"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label" for="subject">CPF</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <input type="text" class="form-control" name="cpf_usu"
                                                            id="cpf_usu" placeholder="CPF">
                                                        <div id="error5"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label" for="email">Data de nascimento</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <input type="text" class="form-control" name="data_nasc"
                                                            id="data_nasc" placeholder="Data de nascimento">
                                                        <div id="error6"></div>
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
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <input type="text" class="form-control" name="rua_usu"
                                                            id="rua_usu" placeholder="Rua">
                                                        <div id="error7"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label" for="subject">Bairro</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <input type="text" class="form-control" name="bairro_usu"
                                                            id="bairro_usu" placeholder="Bairro">
                                                        <div id="error8"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label" for="subject">Número</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <input type="number" class="form-control" name="num_usu"
                                                            id="num_usu" placeholder="Número">
                                                        <div id="error9"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label" for="subject">CEP</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <input type="text" class="form-control" name="cep_usu"
                                                            id="cep_usu" placeholder="CEP">
                                                        <div id="error10"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label" for="estado_usu">Selecione o estado</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                     
                                                        <select class="form-select form-select-sm form-control" aria-label=".form-select-sm example" name="estado_usu" id="estado_usu">
                                                            <?php foreach($estados as $estado): ?>
                                                                <option value="<?php echo $estado['estado_id']; ?>"><?php echo $estado['nome_estado']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <br>

                                    <div class="col-md">
                                        <fieldset class="border p-2">
                                            <legend class="w-auto">Dados da Loja</legend>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label" for="#">Informe seu subdomínio</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <input type="text" class="form-control" name="subdominio"
                                                            id="subdominio" placeholder="Subdomínio">
                                                        <div id="error12"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label" for="subject">Nome Fantasia</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <input type="text" class="form-control" name="nome_fan"
                                                            id="nome_fan" placeholder="Nome fantasia">
                                                        <div id="error13"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="label" for="subject">CNPJ</label>

                                                        <input type="text" class="form-control" name="cnpj"
                                                            id="cnpj" placeholder="CNPJ">
                                                        <span id="passwordHelpInline" class="form-text">
                                                            (Opcional)
                                                        </span>

                                                    </div>
                                                </div>

                                            </div>
                                        </fieldset><br>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="submit" value="Cadastrar" class="btn btn-success">
                                        </div>
                                    </div>

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

<?php $render('sitePrincipal/footer'); ?>