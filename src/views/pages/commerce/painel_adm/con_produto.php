<?php
if(!isset($_SESSION['log_admin_c'])){
  header("Location: /admin");
  exit;
}

$render("commerce/header_painel", ['title'=>'Painel administrativo | Produtos']); 
?>

<div class="content-wrapper" style="min-height: 1184.92px;">
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
        <?php 
        if(isset($_SESSION['message'])){
          echo $_SESSION['message'];
          unset($_SESSION['message']);
        }
        ?>
      </div>
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
                      <th>Nome</th>
                      <th>Estoque</th>
                      <th>Preço</th>
                      <th>Preço antigo</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($dados as $dado): ?>
                      <tr>
                        <td><?php echo $dado['nome_pro']; ?></td>
                        <td><?php echo $dado['estoque']; ?></td>
                        <td><?php echo 'R$'.number_format($dado['preco'], 2, ',','.'); ?></td>
                        <td><?php echo 'R$'.number_format($dado['preco_antigo'], 2, ',','.'); ?></td>
                        <td> <a href="">Excluir</a> | <a href="">Editar</a> | <a href="/admin/painel/detalhes-produto/<?php echo $dado['produto_id']; ?>">Detalhes</a> </td>
                      </tr>
                    <?php endforeach; ?>
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