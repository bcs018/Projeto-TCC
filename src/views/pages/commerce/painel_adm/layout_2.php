<?php
if (!isset($_SESSION['log_admin'])) {
    header("Location: /admin");
    exit;
}

$render("commerce/header_painel", ['title' => 'Painel administrativo | Layout']);
?>

<div class="content-wrapper" style="min-height: 1184.92px;">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Editar layout do ecommerce</h1>
                </div>
            </div>
            <?php
            if (isset($_SESSION['message'])) {
                echo '<br>'.$_SESSION['message'];
                unset($_SESSION['message']);
            }
            ?>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <form role="form" name="detalheProduto" method="POST" enctype="multipart/form-data" action="/admin/painel/edi-layout">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><b>Redes sociais</b></h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="bd-example">
                                        <label for="banner">Instagram</label>
                                        <input type="text" class="form-control" placeholder="Informe o link do Instagram de sua loja" name="insta" value="<?php //echo $dados['nome_fantasia']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="bd-example">
                                        <label for="banner">Facebook</label>
                                        <input type="text" class="form-control" placeholder="Informe o link do Facebook de sua loja" name="face" value="<?php //echo $dados['nome_fantasia']; ?>">
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <div class="bd-example">
                                        <label for="banner">LinkedIn</label>
                                        <input type="text" class="form-control" placeholder="Informe o link LinkedIn de sua loja" name="linke" value="<?php //echo $dados['nome_fantasia']; ?>">
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <h5>
                                        Informe somente os campos em que você tenha conta na rede social. <br>
                                        As redes sociais serão mostradas no final da página.
                                    </h5>
                                </div>                             
                            </div>
                        </div>

                        

                        <div>
                            <button type="submit" class="btn btn-success">Editar</button>
                        </div>
                        
                        <br><br>

                        <nav aria-label="...">
                            <ul class="pagination justify-content-center">
                                <li class="page-item" aria-current="page">
                                    <a class="page-link" href="/admin/painel/layout">1</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="/admin/painel/layout/2">2</a>
                                </li>
                            </ul>
                        </nav>

                        <br><br>
                    </form>
                </div>
            </div>
        </div>
    </section>

</div>

<!-- <div class="modal" id="aviso" tabindex="-1" role="dialog">
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
</div> -->

<?php require_once('aviso.php'); ?>

<?php $render("commerce/footer_painel"); ?>

<script>
    $(function() {
        $('.select2').select2()
    })
</script>

<script type="text/javascript">
    $('#preco').mask("# ##0,00", {
        reverse: true
    });
    $('#precoAnt').mask("# ##0,00", {
        reverse: true
    });
</script>

<script>
    $(document).ready(function(){
        if( <?php echo $control_rec; ?> == '0'){
            $('#aviso').modal('show')
       }
    });
</script>