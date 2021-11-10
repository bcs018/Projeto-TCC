<?php
if(!isset($_SESSION['log_admin'])){
  header("Location: /admin");
  exit;
}

$render("commerce/header_painel", ['title'=>'Painel administrativo | Marcas']); 
?>

<div class="content-wrapper" style="min-height: 1184.92px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-4">
            <h1>Marcas</h1>
          </div>
          <div class="col-sm-8 text-right">
              <a class="btn btn-success" href="/admin/painel/cadastrar-marcas"><i class="fas fa-plus"></i>&nbsp; Cadastrar Marca</a>
              <!-- <button class="btn btn-success"><i class="fas fa-plus"></i>&nbsp; Cadastrar Marca</button> -->
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
              <?php 
              if(isset($_SESSION['message'])){
                echo $_SESSION['message'];
                unset($_SESSION['message']);
              }
              ?>
            <div class="card">
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nome marca</th>
                      <th>Ação</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!isset($dados)): ?>
                      <tr>
                        <td>Nenhuma marca cadastrada</td>
                        <td></td>
                        <td></td>
                      </tr>
                    <?php else: ?>
                      <?php foreach ($dados as $dado): ?>
                      <tr>
                        <td><?php echo $dado['marca_id']; ?></td>
                        <td><?php echo $dado['nome_mar']; ?></td>
                        <td> <a id="e-<?php echo $dado['marca_id']; ?>" href="#">Excluir</a> | <a href="/admin/painel/editar-marca/<?php echo $dado['marca_id']; ?>">Editar</a> </td>
                      </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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
        title: 'Confirma exclusão da marca?',
        content: '',
        type: 'orange',
        buttons: {
            deleteUser: {
                text: 'Sim',
                action: function () {
                  window.location.href = '/admin/painel/excluir-marca/action/'+id[1];
                }
            },
            não: {
                btnClass: 'btn-red any-other-class', // multiple classes.
            },
        }
      });
  })

</script>