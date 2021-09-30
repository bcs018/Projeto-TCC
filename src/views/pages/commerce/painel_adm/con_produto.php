<?php
if(!isset($_SESSION['log_admin_c'])){
  header("Location: /admin");
  exit;
}

$render("commerce/header_painel", ['title'=>'Painel administrativo | Produtos', 'qtdNoti'=>$qtdNoti]); 
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
                      <th>Banner?</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(isset($dados[0])): ?>
                      <?php foreach($dados as $dado): ?>
                        <tr>
                          <td><?php echo $dado['nome_pro']; ?></td>
                          <td><?php echo $dado['estoque']; ?></td>
                          <td><?php echo 'R$'.number_format($dado['preco'], 2, ',','.'); ?></td>
                          <td><?php echo 'R$'.number_format($dado['preco_antigo'], 2, ',','.'); ?></td>
                          <td><?php echo $dado['banner_img'] != '0' ? 'SIM' : 'NÃO'; ?></td>
                          <td> <a id="e-<?php echo $dado['produto_id']; ?>" href="#">Excluir</a> | <a href="/admin/painel/editar-produto/<?php echo $dado['produto_id']; ?>">Editar</a> | <a href="/admin/painel/detalhes-produto/<?php echo $dado['produto_id']; ?>">Detalhes</a> </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <td>Não há produtos cadastrados</td>
                    
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

<script>
  
  $('a').click(function(){
    id = $(this).attr('id').split("-")
    $.confirm({
        title: 'Confirma exclusão do produto?',
        content: '',
        type: 'orange',
        buttons: {
            deleteUser: {
                text: 'Sim',
                action: function () {
                  window.location.href = '/admin/painel/excluir-produto/'+id[1];
                }
            },
            não: {
                btnClass: 'btn-red any-other-class', // multiple classes.
            },
        }
      });
  })

</script>