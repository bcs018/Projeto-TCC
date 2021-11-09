<?php $render("sitePrincipal/header_paineladm", ['title'=>'Painel administrativo - Venda à pagar']); ?>

<div class="content-wrapper" style="min-height: 1184.92px;">

  <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Dados da venda</h3>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-6">
                    <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Nome do responsável</label>
                    <p><?php echo $venda['nome']. ' ' .$venda['sobrenome']; ?></p>
                  </div>

                  <div class="col-6">
                    <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Nome da Loja</label>
                    <p><?php echo $venda['nome_fantasia']; ?></p>
                  </div>

                  <div class="col-6">
                    <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Subdominio</label>
                    <p><?php echo $venda['sub_dominio']; ?></p>
                  </div>

                  <div class="col-6">
                    <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Telefone responsável</label>
                    <p><?php echo $venda['celular']; ?></p>
                  </div>

                  <div class="col-6">
                    <label style="color: #525252;font-weight: bold;margin-bottom: 0;">E-mail responsável</label>
                    <p><?php echo $venda['email']; ?></p>
                  </div>

                  <div class="col-6">
                    <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Compra n°</label>
                    <p><?php echo $venda['compra_id']; ?></p>
                  </div>

                  <div class="col-6">
                    <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Subtotal</label>
                    <p><?php echo 'R$'.number_format($venda['subtotal_compra'], 2, ',','.'); ?></p>
                  </div>

                  <div class="col-6">
                    <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Frete</label>
                    <p><?php echo 'R$'.number_format($venda['frete'], 2, ',','.'); ?></p>
                  </div>

                  <div class="col-6">
                    <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Total compra</label>
                    <p><?php echo 'R$'.number_format($venda['total_compra'], 2, ',','.'); ?></p>
                  </div>

                  <div class="col-6">
                    <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Transferir para o PIX</label>
                    <p><?php echo $venda['chave_pix'] ?></p>
                  </div>

                  <div class="col-6">
                    <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Recebido?</label>
                    <p><?php echo ($venda['recebido']==1)?'SIM':'NÃO' ?></p>
                  </div>

                  <div class="col-6">
                    <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Transferido?</label>
                    <p id="transferido"><?php echo ($venda['transferido']==1)?'SIM':'NÃO' ?></p>
                  </div>
                  
                  <div class="col-12">
                    <label style="color: #525252;font-weight: bold;margin-bottom: 0;"><b>TOTAL A SER TRANSFERIDO</b></label>
                    <p><b><?php echo 'R$'.number_format(($venda['total_compra']-$juros)-5, 2, ',','.'); ?></b></p>
                  </div>

                  <div class="col-2">
                    <button id="tran" class="btn btn-success">Transferido</button>
                    <input type="hidden" id="idcompra" value="<?php echo $venda['compra_id']; ?>">
                  </div>
                  <div class="col-7">
                    <button id="ntran" class="btn btn-danger">Não transferido</button>
                  </div>
                </div>
              </div>
              <br><br>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

<?php $render("sitePrincipal/footer_paineladm"); ?>

<script>

  $('#tran').click(function(){
    id = $('#idcompra').val();
    $.confirm({
      title: 'Marcar como transferido?',
      content: '',
      type: 'orange',
      buttons: {
          deleteUser: {
              text: 'SIM',
              action: function () {
                $.ajax({
                  url: '/transferir/compra',
                  type: 'POST',
                  dataType: 'JSON',
                  data:{
                    tran:1,
                    id:id,
                    idEco:'<?php echo $venda['ecommerce_id']; ?>',
                    valor:'<?php echo 'R$'.number_format($venda['total_compra'], 2, ',','.');?>'
                  },
                  success:function(r){
                    if(r.ret == true){
                      $('#transferido').html('SIM');
                      $.alert('Transferido!');
                    }else{
                      $.alert('Ocorreu erro interno ao transferir!');
                    }
                  }
                })
              }
          },
          cancelar: {
              btnClass: 'btn-red any-other-class', // multiple classes.
          },
      }
    });
  });

  $('#ntran').click(function(){
    id = $('#idcompra').val();
    $.confirm({
      title: 'Marcar como não transferido?',
      content: '',
      type: 'orange',
      buttons: {
          deleteUser: {
              text: 'SIM',
              action: function () {
                $.ajax({
                  url: '/transferir/compra',
                  type: 'POST',
                  dataType: 'JSON',
                  data:{tran:0,id:id},
                  success:function(r){
                    if(r.ret == true){
                      $('#transferido').html('NÃO');
                      $.alert('Marcado como Não Transferido!');
                    }else{
                      $.alert('Ocorreu erro interno ao transferir!');
                    }
                  }
                })
              }
          },
          cancelar: {
              btnClass: 'btn-red any-other-class', // multiple classes.
          },
      }
    });
  });

</script>