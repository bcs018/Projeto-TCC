<?php
if(!isset($_SESSION['log_admin'])){
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
                    <h1>Cadastrar produto</h1><br>
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
                            <h3 class="card-title">Dados do produto</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" id="cadProduto" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label for="nomeProd">Nome produto</label>
                                    <input type="text" class="form-control" id="nomeProd" name="nomeProd"
                                        placeholder="Insira o nome do produto" value="<?php if(isset($_POST['nomeProd'])){ echo $_POST['nomeProd']; } ?>">
                                </div>
                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label for="descProd">Descrição do produto</label>
                                    <textarea name="descProd" id="descProd" rows="6" class="form-control" value="<?php if(isset($_POST['descProd'])){ echo $_POST['descProd']; } ?>"></textarea>
                                </div>

                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label>Selecione a categoria do produto</label>
                                    <select class="form-control select2" style="width: 100%;" name="categoria" id="categoria">
                                        <?php foreach ($categorias as $dado): ?>
                                        <option value="<?php echo $dado['categoria_id'] ?>"><?php echo $dado['nome_cat'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label>Selecione a marca do produto</label>
                                    <select class="form-control select2" style="width: 100%;" name="marca" id="marca">
                                        <?php foreach ($marcas as $dado): ?>
                                        <option value="<?php echo $dado['marca_id'] ?>"><?php echo $dado['nome_mar'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label for="estoque">Estoque</label>
                                    <input type="number" class="form-control" id="estoque" name="estoque"
                                        placeholder="Insira o nome do produto" value="<?php if(isset($_POST['estoque'])){ echo $_POST['estoque']; } ?>">
                                </div>
                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label for="preco">Preço</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="">R$</span>
                                        </div>
                                        <input type="text" class="form-control" id="preco" name="preco"
                                            placeholder="Insira o preço do produto" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label for="precoAnt">Preço antigo</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="">R$</span>
                                        </div>
                                        <input type="text" class="form-control" id="precoAnt" name="precoAnt"
                                            placeholder="Insira o preço antigo do produto" value="">
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
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
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
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
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

                            <!-- <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success">Proximo <i class="fas fa-chevron-right"></i><i class="fas fa-chevron-right"></i></button>
                            </div> -->
                    </div>


                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Dados para o cálculo do frete do produto <b>(Insira os dados mais próximos possiveis)</b></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                            <div class="card-body">
                                <h4>Caso o produto seja menor que 15 cm em Altura, Largura, Comprimento e Diâmetro, informe 15 cm nesses campos para o cálculo do Correios</h4>
                                <br>

                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label for="nomeProd">Peso (Kg)</label>
                                    <input type="text" class="form-control" id="peso" name="peso"
                                        placeholder="Insira o peso do produto" value="<?php if(isset($_POST['peso'])){ echo $_POST['peso']; } ?>">
                                </div>
                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label for="descProd">Altura (cm)</label>
                                    <input type="text" class="form-control" id="altura" name="altura"
                                        placeholder="Insira a altura do produto" value="<?php if(isset($_POST['altura'])){ echo $_POST['altura']; } ?>">

                                </div>
                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label for="descProd">Largura (cm)</label>
                                    <input type="text" class="form-control" id="largura" name="largura"
                                        placeholder="Insira a largura do produto" value="<?php if(isset($_POST['largura'])){ echo $_POST['largura']; } ?>">

                                </div>
                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label for="descProd">Comprimento (cm)</label>
                                    <input type="text" class="form-control" id="comprimento" name="comprimento"
                                        placeholder="Insira o comprimento do produto" value="<?php if(isset($_POST['comprimento'])){ echo $_POST['comprimento']; } ?>">

                                </div>
                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label for="descProd">Diâmetro (cm)</label>
                                    <input type="text" class="form-control" id="diametro" name="diametro"
                                        placeholder="Insira o diâmetro do produto" value="<?php if(isset($_POST['diametro'])){ echo $_POST['diametro']; } ?>">

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

<script type="text/javascript">
    $('#preco').mask("# ##0,00", {
        reverse: true
    });
    $('#precoAnt').mask("# ##0,00", {
        reverse: true
    });
    $('#peso').mask("00,00", {
        reverse: true
    });
    $('#altura').mask("00,00", {
        reverse: true
    });
    $('#largura').mask("00,00", {
        reverse: true
    });
    $('#comprimento').mask("00,00", {
        reverse: true
    });
    $('#diametro').mask("00,00", {
        reverse: true
    });
</script>


<?php $render("commerce/footer_painel"); ?>

<script>
  $(function () {
    $('.select2').select2()
  })
</script>

<script>
    $(document).ready(function(){
        if( <?php echo $control_rec; ?> == '0'){
            $('#aviso').modal('show')
       }
    });
</script>