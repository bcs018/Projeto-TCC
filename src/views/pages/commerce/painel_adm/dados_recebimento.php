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
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title"><b>AVISO!!! </b></h3>
                        </div>
                            <div class="card-body">                           
                                <h5>Se você possuir cadastro no PagSeguro, cadastre seu E-mail e seu Token.</h5>
                                <h5>Se você possuir cadastro no Mercado Pago, cadastre sua Public Key e seu Access Token.</h5>
                                <br><h4>Jamais cadastre somente seu E-mail ou somente seu Token do PagSeguro ou somente sua Public Key ou somente 
                                    Access Token do Mercado Pago.
                                </h4> 
                                <h4>Essas informações são responsáveis pelo seu recebimento das vendas!</h4>

                            </div>
                    </div>


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
                                                aria-selected="false">Mercado Pago</a>
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
                                                <label for="pkmpago">Public Key do Mercado Pago</label>
                                                <input type="text" class="form-control" name="pkmpago" id="pkmpago" aria-describedby="emailHelp" placeholder="Public Key Mercado Pago">
                                                <br>
                                                <label for="tknmpago">Accsess Token do Mercado Pago</label>
                                                <input type="text" class="form-control" name="tknmpago" id="tknmpago" aria-describedby="emailHelp" placeholder="Accsess Token Mercado Pago">

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

<div class="modal" id="aviso" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">AVISO!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Você não cadastrou nenhuma conta referente ao recebimento de suas vendas!.</p>
        <p>Vá no MENU "Dados para recebimento" e cadastre sua conta PagSeguro ou Mercado Pago</p>
        <p><b>CASO VOCÊ NÃO CADASTRE, SEUS CLIENTES NÃO VÃO CONSEGUIR EFETUAR COMPRAS E EVENTUALMENTE 
            VOCÊ NÃO IRÁ RECEBER!!!
        </b></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<?php $render("commerce/footer_painel"); ?>
<script>
    $(document).ready(function(){
        if( <?php echo $control_rec; ?> == '0'){
            $('#aviso').modal('show')
       }
    });
</script>