<?php
if(!isset($_SESSION['log_admin_c'])){
  header("Location: /login/c");
  exit;
}
$render("commerce/header_painel_cliente", ['title'=>'Painel administrativo | Principal']); 
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Painel de controle</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $qtdCompra; ?></h3>

                <p>Compras realizadas</p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <a href="/cliente/painel/meus-pedidos" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><sup style="font-size: 20px">Dúvidas</sup></h3>

                <p></p><br>
              </div>
              <div class="icon">
                <i class="fas fa-question"></i>
              </div>
              <a href="#" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>  

          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><sup style="font-size: 20px">Reclamação</sup></h3>
                <p></p><br>
                <!-- <p>Novos clientes p/ dia</p> -->
              </div>
              <div class="icon">
                <i class="fas fa-exclamation"></i>
              </div>
              <a href="#" class="small-box-footer">Mais informações <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <br><br>
            <h3>Aviso!</h3>
            <h5>Se você já usou o ecommerce por completo, clique na opção "Questionário" no MENU 
              e responda o questionário.
            </h5>
            <h5>Sua resposta é de extrema importância para nós!</h5>
            <h5>Obrigado!</h5><br><br><br>
          </div>
        </div>
        
      </div><!-- /.container-fluid -->
    </section>
  </div>
  <!-- /.content-wrapper -->


<?php $render("commerce/footer_painel_c"); ?>
