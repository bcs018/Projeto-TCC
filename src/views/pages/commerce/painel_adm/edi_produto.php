<?php
if(!isset($_SESSION['log_admin_c'])){
  header("Location: /admin");
  exit;
}

$render("commerce/header_painel", ['title'=>'Painel administrativo | Editar produto']); 
?>

<div class="content-wrapper" style="min-height: 1184.92px;">

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Editar produto</h1>
        </div>
      </div>
      <?php 
        if(isset($_SESSION['message'])){
          echo $_SESSION['message'];
          unset($_SESSION['message']);
        }
        ?>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <div class="card-title">
                Fotos
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <?php if($produtos[0]['url'] == ''): ?>
                <h5>Não há imagens cadastradas</h5>
                <?php else: ?>
                <?php foreach($produtos as $produto): ?>
                <div class="col-sm-2">
                  <a href="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $produto['url']; ?>" data-toggle="lightbox"
                    data-gallery="gallery">
                    <img src="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $produto['url']; ?>"
                      class="img-fluid mb-2" alt="black sample">
                  </a>
                  <a href="">Excluir</a>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Dados do produto</h3>
            </div>
            <form role="form" name="detalheProduto" method="POST">
              <div class="card-body">
                <div class="form-group">
                  <div class="bd-example">
                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                    <label for="nomeProd">Adicione imagens aos produto</label>
                    <input type="file" class="form-control" name="imagem[]" multiple>
                    <input type="hidden" value="<?php echo $produtos[0]['produto_id']; ?>" id="id" name="id">
                  </div>
                </div>
                <div class="form-group">
                  <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                  <label for="nomeProd">Nome produto</label>
                  <input type="text" class="form-control" id="nomeProd" name="nomeProd"
                    placeholder="Insira o nome do produto"
                    value="<?php echo $produtos[0]['nome_pro']; ?>">
                </div>
                <div class="form-group">
                  <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                  <label for="descProd">Descrição do produto</label>
                  <textarea name="descProd" id="descProd" rows="6" class="form-control"><?php echo $produtos[0]['descricao']; ?></textarea>
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
                    placeholder="Insira o nome do produto"
                    value="<?php echo $produtos[0]['estoque']; ?>">
                </div>
                <div class="form-group">
                  <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                  <label for="preco">Preço</label>
                  <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text" id="">R$</span>
                    </div>
                    <input type="text" class="form-control" id="preco" name="preco"
                      placeholder="Insira o preço do produto" value="<?php echo $produtos[0]['preco']; ?>">
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
                      placeholder="Insira o preço antigo do produto" value="<?php echo $produtos[0]['preco_antigo']; ?>">
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
                </div>
              </div>

              <div class="card-footer text-right">
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
  document.getElementById('categoria').value = <?php echo $produtos[0]['categoria_id']; ?>;
  document.getElementById('marca').value = <?php echo $produtos[0]['marca_id']; ?>;

  $(function () {
    $('.select2').select2()
  })
</script>

<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.filter-container').filterizr({
      gutterPixels: 3
    });
    $('.btn[data-filter]').on('click', function () {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
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