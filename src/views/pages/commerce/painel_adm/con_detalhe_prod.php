<?php
if (!isset($_SESSION['log_admin'])) {
  header("Location: /admin");
  exit;
}

$render("commerce/header_painel", ['title' => 'Painel administrativo | Detalhes do produto']);
?>

<div class="content-wrapper" style="min-height: 1184.92px;">

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Detalhes do produto</h1>
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
        <div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <div class="card-title">
                Fotos
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <?php if ($produtos[0]['url'] == '') : ?>
                  <h5>Não há imagens cadastradas</h5>
                <?php else : ?>
                  <?php foreach ($produtos as $produto) : ?>
                    <div class="col-sm-2">
                      <a href="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $produto['url']; ?>" data-toggle="lightbox" data-gallery="gallery">
                        <img src="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $produto['url']; ?>" class="img-fluid mb-2" alt="black sample">
                      </a>
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
            <div class="card-body">
              <div class="row">
                <div class="col-6">
                  <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Nome produto</label>
                  <p><?php echo $produtos[0]['nome_pro']; ?></p>
                </div>

                <div class="col-6">
                  <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Descrição</label>
                  <p><?php echo $produtos[0]['descricao']; ?></p>
                </div>

                <div class="col-6">
                  <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Categoria</label>
                  <select class="form-control select2" disabled style="width: 100%;" name="categoria" id="categoria">
                    <?php foreach ($categorias as $dado) : ?>
                      <option value="<?php echo $dado['categoria_id'] ?>"><?php echo $dado['nome_cat'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="col-6">
                  <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Marca</label>
                  <select class="form-control select2" disabled style="width: 100%;" name="marca" id="marca">
                    <?php foreach ($marcas as $dado) : ?>
                      <option value="<?php echo $dado['marca_id'] ?>"><?php echo $dado['nome_mar'] ?></option>
                    <?php endforeach; ?>
                  </select> <p></p>
                </div>

                <div class="col-6">
                  <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Estoque</label>
                  <p><?php echo $produtos[0]['estoque']; ?></p>
                </div>

                <div class="col-6">
                  <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Preço</label>
                  <p><?php echo 'R$'.number_format($produtos[0]['preco'], 2, ',','.'); ?></p>
                </div>

                <div class="col-6">
                  <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Preço antigo</label>
                  <p><?php echo 'R$'.number_format($produtos[0]['preco_antigo'], 2, ',','.'); ?></p>
                </div>

                <div class="col-6">
                  <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Produto em promoção?</label>
                  <p><?php echo $produtos[0]['promocao'] == 1 ? 'SIM' : 'NÃO'; ?></p>
                </div>
                
                <div class="col-6">
                  <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Produto novo?</label>
                  <p><?php echo $produtos[0]['novo_produto'] == 1 ? 'SIM' : 'NÃO'; ?></p>
                </div>
              </div>
            </div>
            <br><br>
          </div>
        </div>
      </div>
    </div>
  </section>

</div>

<!-- <div class="modal" id="aviso" tabindex="-1" role="dialog">
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
</div> -->

<?php require_once('aviso.php'); ?>

<?php $render("commerce/footer_painel"); ?>

<script>
  document.getElementById('categoria').value = <?php echo $produtos[0]['categoria_id']; ?>;
  document.getElementById('marca').value = <?php echo $produtos[0]['marca_id']; ?>;

  $(function() {
    $('.select2').select2()
  })
</script>

<script>
  $(function() {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.filter-container').filterizr({
      gutterPixels: 3
    });
    $('.btn[data-filter]').on('click', function() {
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

<script>
    $(document).ready(function(){
        if( <?php echo $control_rec; ?> == '0'){
            $('#aviso').modal('show')
       }
    });
</script>