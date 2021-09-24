<?php $render("sitePrincipal/header_paineladm", ['title'=>'Painel administrativo - Clientes']); ?>

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $titleView; ?></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md">

            <fieldset class="border p-2">
                <div class="row">
                    <div class="col-5">
                        <p style="margin-bottom: 0px;"><strong>ID Cliente:  <?php  ?> </strong></p>
                        <p style="margin-bottom: 0px;"><strong>Nome Loja: <?php  ?></strong></p>
                        <p style="margin-bottom: 0px;"><strong>Nome Responsável: <?php  ?></strong></p>
                        <p style="margin-bottom: 0px;"><strong>E-mail Responsável: <?php  ?></strong></p>
                    </div>
                    <div class="col"> 
                        <b><p style="margin-bottom: 0px;">Data cadastro: <?php ?></p></b>
                        <b><p style="margin-bottom: 0px;">Plano: <?php ?></p></b>
                        <b><p style="margin-bottom: 0px;">Subdominio: <?php ?></p></b>
                        <b><p style="margin-bottom: 0px;">Ativo: <?php ?></p></b>
                        <p><a href="/">Visualizar</a></p>
                    </div>
                </div>
            </fieldset> <br>

            </div>
        </div>
    </div>

</div>


<?php $render("sitePrincipal/footer_paineladm"); ?>
