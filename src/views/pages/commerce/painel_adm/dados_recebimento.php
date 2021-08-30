<?php
if(!isset($_SESSION['log_admin_c'])){
  header("Location: /admin");
  exit;
}

$render("commerce/header_painel", ['title'=>'Painel administrativo | Cadastrar dados Recebimento']); 
?>

<div class="content-wrapper" style="min-height: 1227.43px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Cadastrar dados para Recebimento</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Selecione o método em que você quer trabalhar: <b>PagSeguro</b> ou
                                <b>Mercado Pago</b></h3>
                        </div>
                        <form role="form" method="POST" action="/admin/painel/cadastrar-dados-recebimento/action">
                            <div class="card-body">
                                <div class="form-group">
                                    <?php 
                                    if(isset($_SESSION['message'])){
                                        echo $_SESSION['message'];
                                        unset($_SESSION['message']);
                                    } 
                                    ?>
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pagseguro-tab" data-toggle="pill"
                                                href="#pagseguro" role="tab" aria-controls="pagseguro"
                                                aria-selected="true">PagSeguro</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="mercadopago-tab" data-toggle="pill"
                                                href="#mercadopago" role="tab" aria-controls="mercadopago"
                                                aria-selected="false">MercadoPago</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pagseguro" role="tabpanel" aria-labelledby="pills-home-tab">
                                            <div class="form-group">
                                                <label for="tknpagseguro">Token do PagSeguro</label>
                                                <input type="text" class="form-control" name="tknpagseguro" id="tknpagseguro" aria-describedby="emailHelp" placeholder="Token PagSeguro">
                                                <small id="emailHelp" class="form-text text-muted">Esse token você consegue entrando <a target="_blank" href="https://www.sandbox.pagseguro.uol.com.br">aqui</a>, faz o login, em Perfis de integração clica em Vendedor, la vai ter o token.</small>
                                                <br>
                                                <label for="emailpagseguro">E-mail cadastrado no PagSeguro</label>
                                                <input type="email" class="form-control" name="emailpagseguro" id="emailpagseguro" aria-describedby="emailHelp" placeholder="E-mail cadastrado no PagSeguro">
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="mercadopago" role="tabpanel" aria-labelledby="pills-profile-tab">
                                            <div class="form-group">
                                                <label for="tknmpago">Token do Mercado Pago</label>
                                                <input type="text" class="form-control" name="tknmpago" id="tknmpago" aria-describedby="emailHelp" placeholder="Token Mercado Pago">
                                                <!-- <small id="emailHelp" class="form-text text-muted">Esse token você consegue entrando <a target="_blank" href="https://www.sandbox.pagseguro.uol.com.br">aqui</a>, faz o login, em Perfis de integração clica em Vendedor, la vai ter o token.</small> -->
                                                <br>
                                                <!-- <label for="emailpagseguro">E-mail cadastrado no PagSeguro</label>
                                                <input type="email" class="form-control" id="emailpagseguro"
                                                    aria-describedby="emailHelp" placeholder="E-mail cadastrado no PagSeguro"> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $render("commerce/footer_painel"); ?>
