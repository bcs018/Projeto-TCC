<?php
if(!isset($_SESSION['log_admin'])){
  header("Location: /admin");
  exit;
}

$render("commerce/header_painel", ['title'=>'Painel administrativo | Questionário']); 
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Preencha o questionário com relação ao uso da plataforma!</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
        <iframe src="https://docs.google.com/forms/d/e/1FAIpQLScJV92R9s_Mq6ZZjbTwIPNPWxLuD6jtTPzeUO1WlKzDqXxshQ/viewform?embedded=true" width="1100" height="2511" frameborder="0" marginheight="0" marginwidth="0">Carregando…</iframe>       
        </div>
    </section>
  </div>

<?php require_once('aviso.php'); ?>

<?php $render("commerce/footer_painel"); ?>

<script>
    $(document).ready(function(){
        if( <?php echo $control_rec; ?> == '0'){
            $('#aviso').modal('show')
       }
    });
</script>