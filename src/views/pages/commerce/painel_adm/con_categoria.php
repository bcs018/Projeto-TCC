<?php
if(!isset($_SESSION['log_admin_c'])){
  header("Location: /admin");
  exit;
}

$render("commerce/header_painel", ['title'=>'Painel administrativo | Categorias']); 
?>

<div class="content-wrapper" style="min-height: 1184.92px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-4">
            <h1>Categorias</h1>
          </div>
          <div class="col-sm-8 text-right">
              <a class="btn btn-success" href="/admin/painel/cadastrar-categorias"><i class="fas fa-plus"></i>&nbsp; Cadastrar Categoria</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                  <?php foreach($dados as $dado): ?>                               
                  <?php echo '<br>- '.$dado['nome_cat']; ?>.......[<a href="/admin/painel/editar-categoria/<?php echo $dado['categoria_id']; ?>">Editar</a> | <a href="/admin/painel/excluir-categoria/action/<?php echo $dado['categoria_id']; ?>">Excluir</a>]
                    <?php 
                    if(count($dado['subs'])>0){
                        $render("commerce/subcategoria", array(
                            'subs' => $dado['subs'],
                            'level' => 1,
                            'edit' => 1
                        ));
                    }
                    ?>
                    <br>
                  <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <br><br><br>
</div>

  <?php $render("commerce/footer_painel"); ?>