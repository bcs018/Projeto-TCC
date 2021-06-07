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
                <div class="col-sm-6">
                    <h1>Cadastrar produto</h1>
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
                        <form role="form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nome produto</label>
                                    <input type="text" class="form-control" id="nomeProd" name="nomeProd" placeholder="Insira o nome do produto">
                                </div>
                                <div class="form-group">
                                    <label for="descProd">Descrição do produto</label>
                                    <textarea name="descProd" id="descProd" rows="6" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Estoque</label>
                                    <input type="number" class="form-control" id="estoque" name="estoque" placeholder="Insira o nome do produto">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Preço</label>
                                    <input type="text" class="form-control" id="preco" name="preco" placeholder="Insira o preço do produto">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="">Upload</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
    $('#preco').mask("#.##0,00", {reverse: true});
</script>  

<?php $render("commerce/footer_painel"); ?>
