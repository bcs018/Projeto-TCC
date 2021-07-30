<?php
if (!isset($_SESSION['log_admin_c'])) {
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
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
            ?>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Banner da pagina principal</h3>
                        </div>
                        <form role="form" name="detalheProduto" method="POST" enctype="multipart/form-data" action="/admin/painel/editar-produto">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="bd-example">
                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                        <label for="nomeProd">Adicione imagens ao seu banner (Banners de 1160x360 até 1163x363 mega pixels) </label>
                                        <input type="file" class="form-control" name="banner">
                                        <input type="hidden" value="<?php echo $produtos[0][0]; ?>" id="id" name="id">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label>Selecione o produto vinculado ao banner</label>
                                    <select class="form-control select2" style="width: 100%;" name="produto" id="produto">
                                        <?php foreach ($produtos as $produto) : ?>
                                            <option value="<?php echo $produto['nome_pro'] ?>"><?php echo $produto['nome_pro'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <h5>Exemplo do banner circulado em vermelho:</h5>
                                    <img src="<?php echo BASE_ASS_C; ?>images/banner_ex.jpg" class="img-fluid" width="900px" height="350px" alt="">
                                </div>
                                <!-- <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label for="descProd">Descrição do produto</label>
                                    <textarea name="descProd" id="descProd" rows="6" class="form-control"><?php echo $produtos[0]['descricao']; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label>Selecione a categoria do produto</label>
                                    <select class="form-control select2" style="width: 100%;" name="categoria" id="categoria">
                                        <?php foreach ($categorias as $dado) : ?>
                                            <option value="<?php echo $dado['categoria_id'] ?>"><?php echo $dado['nome_cat'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label>Selecione a marca do produto</label>
                                    <select class="form-control select2" style="width: 100%;" name="marca" id="marca">
                                        <?php foreach ($marcas as $dado) : ?>
                                            <option value="<?php echo $dado['marca_id'] ?>"><?php echo $dado['nome_mar'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label for="estoque">Estoque</label>
                                    <input type="number" class="form-control" id="estoque" name="estoque" placeholder="Insira o nome do produto" value="<?php echo $produtos[0]['estoque']; ?>">
                                </div>
                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label for="preco">Preço</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="">R$</span>
                                        </div>
                                        <input type="text" class="form-control" id="preco" name="preco" placeholder="Insira o preço do produto" value="<?php echo $produtos[0]['preco']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label for="precoAnt">Preço antigo</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="">R$</span>
                                        </div>
                                        <input type="text" class="form-control" id="precoAnt" name="precoAnt" placeholder="Insira o preço antigo do produto" value="<?php echo $produtos[0]['preco_antigo']; ?>">
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
                                        <input class="custom-control-input" type="radio" id="promoSim" name="promo" <?php echo $produtos[0]['promocao'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label for="promoSim" class="custom-control-label">Sim</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="promoNao" name="promo" <?php echo $produtos[0]['promocao'] == 0 ? 'checked' : ''; ?> value="0">
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
                                        <input class="custom-control-input" type="radio" id="novoSim" name="novo" <?php echo $produtos[0]['novo_produto'] == 1 ? 'checked' : ''; ?> value="1">
                                        <label for="novoSim" class="custom-control-label">Sim</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="novoNao" name="novo" <?php echo $produtos[0]['novo_produto'] == 0 ? 'checked' : ''; ?> value="0">
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
                                </div> -->
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Editar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

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