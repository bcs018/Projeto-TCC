<?php
if(!isset($_SESSION['log_admin_c'])){
  header("Location: /login/c");
  exit;
}
$render("commerce/header_painel_cliente", ['title'=>'Painel administrativo | Questionário']); 
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Preencha o questionário com relação ao uso do ecommerce!</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSdIMCqlNHSFQPwhTekOpUwlLKI08cWFEBGuMQOKIbwr-PdA0A/viewform?embedded=true" width="1100" height="1482" frameborder="0" marginheight="0" marginwidth="0">Carregando…</iframe>       
        </div>
    </section>
  </div>

<?php $render("commerce/footer_painel_c"); ?>
