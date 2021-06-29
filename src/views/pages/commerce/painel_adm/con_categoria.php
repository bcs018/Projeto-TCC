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
          <a class="btn btn-success" href="/admin/painel/cadastrar-categorias"><i class="fas fa-plus"></i>&nbsp;
            Cadastrar Categoria</a>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col">
          <div class="card card-red">
            <div class="card-header">
              <h3 class="card-title"><b>CUIDADO AO EXCLUIR OU EDITAR UMA CATEGORIA</b></h3>
            </div>
            <div class="card-body">
              <h6>
                 Ao excluir uma categoria, tenha em mente que se a categoria a ser excluida tiver 
                 subcategorias (filhas), todas as filhas dessa categoria serão excluidas.
              </h6>
              <h6>Exemplo:</h6>
              <h6>
                -- Tênis <br>
                ----- Com cardaço <br>
                ----- Sem cardaço 
              </h6>
              <h6>
                Ao excluir a Categoria pai Tênis, suas filhas Com cardaço e Sem cardaço serão excluidas 
                automaticamente.
              </h6>
              <h6>
                Então pense bem antes de excluir suas categorias para não ter que recadastrar tudo novamente.
              </h6>
            </div>
          </div>
          
          <br><h4>Edite ou Exclua as categorias</h4>
          
          <?php foreach($dados as $dado): ?>
          <?php echo '<br>- '.$dado['nome_cat']; ?>.......[<a
            href="/admin/painel/editar-categoria/<?php echo $dado['categoria_id']; ?>">Editar</a> | <a
            href="/admin/painel/excluir-categoria/action/<?php echo $dado['categoria_id']; ?>">Excluir</a>]
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