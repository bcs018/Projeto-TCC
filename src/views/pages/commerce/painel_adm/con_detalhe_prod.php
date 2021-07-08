<?php
if(!isset($_SESSION['log_admin_c'])){
  header("Location: /admin");
  exit;
}

$render("commerce/header_painel", ['title'=>'Painel administrativo | Detalhes do produto']); 
?>

<div class="content-wrapper" style="min-height: 1184.92px;">

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-4">
          <h1>Detalhes do produto</h1>
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
                  <div class="col-sm-2">
                    <a href="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $url; ?>" data-toggle="lightbox" data-gallery="gallery">
                      <img src="<?php echo BASE_ASS_C; ?>images_commerce/<?php echo $url; ?>" class="img-fluid mb-2" alt="black sample">
                    </a>
                    <a href="">Excluir</a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/000000.png?text=2" data-toggle="lightbox" data-title="sample 2 - black" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/000000?text=2" class="img-fluid mb-2" alt="black sample">
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/FF0000/FFFFFF.png?text=3" data-toggle="lightbox" data-title="sample 3 - red" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/FF0000/FFFFFF?text=3" class="img-fluid mb-2" alt="red sample">
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/FF0000/FFFFFF.png?text=4" data-toggle="lightbox" data-title="sample 4 - red" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/FF0000/FFFFFF?text=4" class="img-fluid mb-2" alt="red sample">
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/000000.png?text=5" data-toggle="lightbox" data-title="sample 5 - black" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/000000?text=5" class="img-fluid mb-2" alt="black sample">
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/FFFFFF.png?text=6" data-toggle="lightbox" data-title="sample 6 - white" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/FFFFFF?text=6" class="img-fluid mb-2" alt="white sample">
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/FFFFFF.png?text=7" data-toggle="lightbox" data-title="sample 7 - white" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/FFFFFF?text=7" class="img-fluid mb-2" alt="white sample">
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/000000.png?text=8" data-toggle="lightbox" data-title="sample 8 - black" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/000000?text=8" class="img-fluid mb-2" alt="black sample">
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/FF0000/FFFFFF.png?text=9" data-toggle="lightbox" data-title="sample 9 - red" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/FF0000/FFFFFF?text=9" class="img-fluid mb-2" alt="red sample">
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/FFFFFF.png?text=10" data-toggle="lightbox" data-title="sample 10 - white" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/FFFFFF?text=10" class="img-fluid mb-2" alt="white sample">
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/FFFFFF.png?text=11" data-toggle="lightbox" data-title="sample 11 - white" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/FFFFFF?text=11" class="img-fluid mb-2" alt="white sample">
                    </a>
                  </div>
                  <div class="col-sm-2">
                    <a href="https://via.placeholder.com/1200/000000.png?text=12" data-toggle="lightbox" data-title="sample 12 - black" data-gallery="gallery">
                      <img src="https://via.placeholder.com/300/000000?text=12" class="img-fluid mb-2" alt="black sample">
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
</div>

<?php $render("commerce/footer_painel"); ?>

<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.filter-container').filterizr({gutterPixels: 3});
    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  })
</script>