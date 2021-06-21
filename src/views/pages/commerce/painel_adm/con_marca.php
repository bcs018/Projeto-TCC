<?php
if(!isset($_SESSION['log_admin_c'])){
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
                        <td> <a href="/admin/painel/excluir-marca/action/<?php echo $dado['marca_id']; ?>">Excluir</a> | <a href="">Editar</a> </td>
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

  <?php $render("commerce/footer_painel"); ?>