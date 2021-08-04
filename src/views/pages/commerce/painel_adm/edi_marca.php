<?php
if (!isset($_SESSION['log_admin_c'])) {
    header("Location: /admin");
    exit;
}

$render("commerce/header_painel", ['title' => 'Painel administrativo | Editar Marca']);
?>

<div class="content-wrapper" style="min-height: 1227.43px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Editar Marca</h1>
                </div>
            </div>
        </div>
    </section>
    
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }
                    ?>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Dados</h3>
                        </div>
                        <form role="form" method="POST" action="/admin/painel/editar-marca/action">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nome marca</label>
                                    <input type="text" class="form-control" name="nomeMarca" id="nomeMarca" value="<?php echo (isset($dados)) ? $dados['nome_mar'] : ''; ?>" placeholder="Insira o nome da marca">
                                    <input type="hidden" value="<?php echo $dados['marca_id']; ?>" name="id">
                                </div>
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
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-title">
                                Imagem da Marca
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php if ($dados['marca_img'] == '0') : ?>
                                    <h5>Não há imagem cadastrada para essa marca.<br></h5>
                                <?php else : ?>
                                    <div class="col-sm-2">
                                        <a href="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $dados['marca_img']; ?>" data-toggle="lightbox" data-gallery="gallery">
                                            <img src="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $dados['marca_img']; ?>" class="img-fluid mb-2" alt="black sample">
                                        </a>
                                        <a href="/admin/painel/excluir-img-marca/<?php echo $dados['marca_id']; ?>">Excluir</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <br>
                        <h5> &nbsp; Para cadastrar uma nova imagem para a marca clique na opção <b>"Layout"</b> no Menu</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $render("commerce/footer_painel"); ?>

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