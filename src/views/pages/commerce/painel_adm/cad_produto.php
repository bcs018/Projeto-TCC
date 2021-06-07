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
                                    <label for="nomeProd">Nome produto</label>
                                    <input type="text" class="form-control" id="nomeProd" name="nomeProd"
                                        placeholder="Insira o nome do produto">
                                </div>
                                <div class="form-group">
                                    <label for="descProd">Descrição do produto</label>
                                    <textarea name="descProd" id="descProd" rows="6" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="estoque">Estoque</label>
                                    <input type="number" class="form-control" id="estoque" name="estoque"
                                        placeholder="Insira o nome do produto">
                                </div>
                                <div class="form-group">
                                    <label for="preco">Preço</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="">R$</span>
                                        </div>
                                        <input type="text" class="form-control" id="preco" name="preco"
                                            placeholder="Insira o preço do produto">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="precoAnt">Preço antigo</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="">R$</span>
                                        </div>
                                        <input type="text" class="form-control" id="precoAnt" name="precoAnt"
                                            placeholder="Insira o preço antigo do produto">
                                    </div>
                                </div>

                                <div class="card card-lightblue">
                                    <div class="card-header">
                                        <h3 class="card-title"><b>O que é Preço antigo?</b></h3>
                                    </div>
                                    <div class="card-body">
                                        <h6>
                                            O campo Preço antigo é de uso opcional e serve para dar evidência ao
                                            produto, por exemplo:
                                        </h6>
                                        <h6>
                                            Produdo XYZ de <b>R$150,00</b> por R$119,99.
                                        </h6>
                                        <h6>
                                            O preço de <b>R$150,00</b> é o preço antigo do produto.
                                        </h6>
                                        <h6>
                                            O site somente irá informar o preço antigo se o produdo tiver o preço antigo
                                            cadastrado.
                                        </h6>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="promo">Produto em promoção?</label>

                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="promoSim"
                                            name="promo">
                                        <label for="promoSim" class="custom-control-label">Sim</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="promoNao"
                                            name="promo" checked="">
                                        <label for="promoNao" class="custom-control-label">Não</label>
                                    </div>
                                </div>

                                <div class="card card-lightblue">
                                    <div class="card-header">
                                        <h3 class="card-title"><b>O que é Produto em promoção?</b></h3>
                                    </div>
                                    <div class="card-body">
                                        <h6>
                                            Quando marcado <b>SIM</b>, o produto terá um destaque na loja e será um dos primeiros a aparecer na página principal, e terá um emblemano anuncio como "Promoção".
                                        </h6>
                                    </div>
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
    $('#preco').mask("#.##0,00", {
        reverse: true
    });
</script>

<?php $render("commerce/footer_painel"); ?>