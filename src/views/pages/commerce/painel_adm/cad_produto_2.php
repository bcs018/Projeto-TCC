<?php
if(!isset($_SESSION['log_admin_c'])){
  header("Location: /admin");
  exit;
}

$render("commerce/header_painel", ['title'=>'Painel administrativo | Cadastrar Produto']); 
?>

<div class="content-wrapper" style="min-height: 1227.43px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Continuação do cadastro de produto</h1><br>
                    <?php
                    if(isset($_SESSION['message'])){
                        echo '<br>'.$_SESSION['message'];
                        unset($_SESSION['message']);
                    }
                    ?>

                    <div id='message'></div>

                    <center><br><h6 style="color: #fa3200;font-weight: bold;">Campos marcados com asterisco
                                    (*) são obrigatórios.</h6></center>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Dados</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="POST" enctype="multipart/form-data" action="/admin/painel/cadastrar-produtos/second">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="bd-example">
                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                        <label for="nomeProd">Selecione as imagens do produto</label>
                                        <input type="file" class="form-control" name="imagem[]" multiple>
                                        <input type="hidden" value="<?php echo $id; ?>" name="id">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- /.card-body -->

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success">Proximo <i class="fas fa-chevron-right"></i><i class="fas fa-chevron-right"></i></button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script type="text/javascript">
    $('#preco').mask("# ##0,00", {
        reverse: true
    });
    $('#precoAnt').mask("# ##0,00", {
        reverse: true
    });
</script>


<?php $render("commerce/footer_painel"); ?>

<script>
  $(function () {
    $('.select2').select2()
  })
</script>