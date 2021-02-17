<?php $render('sitePrincipal/header', ['title' => 'BW Commerce | Pagamento']); ?>

<?php 
if(!isset($_SESSION['person'])){
    header('Location: /crie-sua-loja');
}

if($plano == false){
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
    <h2><?php echo $_SESSION['person']['name']; ?>, estamos quase lá, preencha os dados para pagamento.</h2>
    <h6 class="mb-4" style="color: #fa3200;font-weight: bold;">Campos marcados com asterisco (*) são obrigatórios.</h6>
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
                                <!--<form id="final_pagamento" name="final_pagamento" class="contactForm">-->
                                    <div class="col-md">
                                        <fieldset class="border p-2">
                                            <legend class="w-auto">Dados para pagamento</legend>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label" for="name">Número do cartão</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp</div>
                                                        <input type="text" class="form-control" name="n_card" id="n_card" placeholder="Número do cartão" autofocus>
                                                        <div id="error1"> </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label" for="name">Número de parcelas</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp</div>
                                                        <select name="parc" id="parc" class="form-control"></select>
                                                        <div id="error1"> </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label" for="email">Código de segurança</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <input type="text" class="form-control" name="cd_seg" id="cd_seg" placeholder="Código de segurança">
                                                        <div id="error4"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label" for="email">Mês e ano do vencimento</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <select name="cartao_mes" id="cartao_mes" class="form-control">
                                                                    <?php for($q=1; $q<=12; $q++): ?>
                                                                        <option><?php echo ($q<10)?'0'.$q:$q; ?></option>
                                                                    <?php endfor; ?>
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="col-md-6">
                                                                <select name="cartao_ano" id="cartao_ano" class="form-control">
                                                                    <?php $ano = intval(date('Y')); ?>
                                                                    <?php for($q=$ano; $q<=($ano+30); $q++): ?>
                                                                        <option><?php echo $q; ?></option>
                                                                    <?php endfor; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div id="error3"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label" for="name">Nome impresso no cartão</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <input type="text" class="form-control" name="nome_card" id="nome_card" placeholder="Nome impresso no cartão">
                                                        <div id="error2"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label" for="subject">CPF do titular do cartão</label>
                                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp
                                                        </div>
                                                        <input type="text" class="form-control" name="cpf_card" id="cpf_card" placeholder="CPF do titular do cartão">
                                                        <div id="error5"></div>
                                                    </div>
                                                </div>
                                              
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="label" for="subject">Cupom de desconto</label>                                                      
                                                        <input type="text" class="form-control" name="cupom" id="cupom" placeholder="Cupom de desconto">
                                                        <div id="error5"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-primary">Validar Cupom</button>
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
                                <!--</form>-->
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
                                                        <p>R$<?php echo number_format($plano['preco'], 2, ',', '.'); ?></p>
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


<!-- Puxando o script do pagseguro -->
<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
<script type="text/javascript" src="<?php echo BASE_ASS; ?>js/sitePrincipal/psckttransparente.js"></script>

<script type="text/javascript">
    PagSeguroDirectPayment.setSessionId("<?php echo $sessionCode; ?>");
</script>


<br><br><br><br>
<?php $render('sitePrincipal/footer') ?>