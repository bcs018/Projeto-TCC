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
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
  <br><br><br>
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

<?php $render("commerce/footer_painel"); ?>

<script>
    $(document).ready(function(){
        if( <?php echo $control_rec; ?> == '0'){
            $('#aviso').modal('show')
       }
    });
</script>