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
                        <form role="form" method="POST" action="/admin/painel/cadastrar-produtos/first-part">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nomeProd">Nome produto</label>
                                    <input type="text" class="form-control" id="nomeProd" name="nomeProd"
                                        placeholder="Insira o nome do produto" value="<?php if(isset($_POST['nomeProd'])){ echo $_POST['nomeProd']; } ?>">
                                </div>
                                <div class="form-group">
                                    <label for="descProd">Descrição do produto</label>
                                    <textarea name="descProd" id="descProd" rows="6" class="form-control" value="<?php if(isset($_POST['descProd'])){ echo $_POST['descProd']; } ?>"></textarea>
                                </div>
                        
                                <div class="form-group">
                                    <label>Categoria do produto</label>
                                    <select class="form-control select2" style="width: 100%;">
                                        <option>Camiseta</option>
                                        <option>Calça</option>
                                        <option>Moleton</option>
                                        <option>Tenis</option>
                                        <option>Meia</option>
                                        <option>Oculos</option>
                                        <option>Regatas</option>
                                    </select>
                                </div> 

                                <div class="form-group">
                                    <label>Marca do produto</label>
                                    <select class="form-control select2" style="width: 100%;">
                                        <option>Nike</option>
                                        <option>Adidas</option>
                                        <option>Puma</option>
                                        <option>Jordan</option>
                                        <option>Fila</option>
                                        <option>Everest</option>
                                        <option>Penalty</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="estoque">Estoque</label>
                                    <input type="number" class="form-control" id="estoque" name="estoque"
                                        placeholder="Insira o nome do produto" value="<?php if(isset($_POST['estoque'])){ echo $_POST['estoque']; } ?>">
                                </div>
                                <div class="form-group">
                                    <label for="preco">Preço</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="">R$</span>
                                        </div>
                                        <input type="text" class="form-control" id="preco" name="preco"
                                            placeholder="Insira o preço do produto" value="<?php if(isset($_POST['preco'])){ echo $_POST['preco']; } ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="precoAnt">Preço antigo</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="">R$</span>
                                        </div>
                                        <input type="text" class="form-control" id="precoAnt" name="precoAnt"
                                            placeholder="Insira o preço antigo do produto" value="<?php if(isset($_POST['precoAnt'])){ echo $_POST['precoAnt']; } ?>">
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
                                        <input class="custom-control-input" type="radio" id="promoSim" name="promo" value="1">
                                        <label for="promoSim" class="custom-control-label">Sim</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="promoNao" name="promo" checked="" value="0">
                                        <label for="promoNao" class="custom-control-label">Não</label>
                                    </div>
                                </div>

                                <div class="card card-lightblue">
                                    <div class="card-header">
                                        <h3 class="card-title"><b>O que é Produto em promoção?</b></h3>
                                    </div>
                                    <div class="card-body">
                                        <h6>
                                            Quando marcado <b>SIM</b>, o produto terá um destaque na loja e será um dos
                                            primeiros a aparecer na página principal, e terá um emblema no anuncio como
                                            "Promoção".
                                        </h6>
                                        <h6>Ele pode ser usado em combinação com o campo Preço antigo.</h6>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="promo">Produto novo?</label>

                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="novoSim" name="novo" checked="" value="1">
                                        <label for="novoSim" class="custom-control-label">Sim</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="novoNao" name="novo" value="0">
                                        <label for="novoNao" class="custom-control-label">Não</label>
                                    </div>
                                </div>

                                <div class="card card-lightblue">
                                    <div class="card-header">
                                        <h3 class="card-title"><b>O que é Produto novo?</b></h3>
                                    </div>
                                    <div class="card-body">
                                        <h6>
                                            Quando marcado <b>SIM</b>, o produto terá um destaque na loja e será um dos
                                            primeiros a aparecer na página principal, e terá um emblema no anuncio como
                                            "Novo".
                                        </h6>
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