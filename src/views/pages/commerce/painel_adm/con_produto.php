<?php
if(!isset($_SESSION['log_admin_c'])){
  header("Location: /admin");
  exit;
}

$render("commerce/header_painel", ['title'=>'Painel administrativo | Produtos']); 
?>

<div class="content-wrapper" style="min-height: 1184.92px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-4">
            <h1>Produtos</h1>
          </div>
          <div class="col-sm-8 text-right">
              <a class="btn btn-success" href="/admin/painel/cadastrar-produtos"><i class="fas fa-plus"></i>&nbsp; Cadastrar Produtos</a>
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
            <div class="card">
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>Estoque</th>
                      <th>Preço</th>
                      <th>Preço antigo</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>45</td>
                      <td>123,30</td>
                      <td>150,00</td>
                      <td> <a href="">Excluir</a> | <a href="">Editar</a> </td>
                    </tr>
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