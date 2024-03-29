<?php
if(!isset($_SESSION['log_admin'])){
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
          <br><h5>Edite ou Exclua as categorias</h5>
          
          <?php
          if(isset($_SESSION['message'])){
            echo '<br>'.$_SESSION['message'];
            unset($_SESSION['message']);
          }
          ?>
          <?php 
          if(empty($dados)):
            echo "<br>Não há categorias cadastradas!";
          else: 
          ?>
            <?php foreach($dados as $dado): ?>
            <?php echo '<br>- '.$dado['nome_cat']; ?>.......[<a
              href="/admin/painel/editar-categoria/<?php echo $dado['categoria_id']; ?>">Editar</a> | 
              <a id="e-<?php echo $dado['categoria_id']; ?>" href="#">Excluir</a>]
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
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
  <br><br><br>
</div>

<?php require_once('aviso.php'); ?>

<?php $render("commerce/footer_painel"); ?>

<script>
    $(document).ready(function(){
        if( <?php echo $control_rec; ?> == '0'){
            $('#aviso').modal('show')
       }
    });
</script>

<script>
  
  $('a').click(function(){
    id = $(this).attr('id').split("-")
    $.confirm({
        title: 'Confirma exclusão da categoria?',
        content: '',
        type: 'orange',
        buttons: {
            deleteUser: {
                text: 'Sim',
                action: function () {
                  window.location.href = '/admin/painel/excluir-categoria/action/'+id[1];
                }
            },
            não: {
                btnClass: 'btn-red any-other-class', // multiple classes.
            },
        }
      });
  })

</script>