<?php $render("sitePrincipal/header_paineladm", ['title'=>'Painel administrativo - Vendas à pagar']); ?>

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $titleView; ?></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md">
            <?php if(!$vendas): ?>
                <h4>Não há vendas à pagar</h4>
            <?php else: ?>
                <?php foreach($vendas as $c): ?>
                <fieldset class="border p-2">
                    <div class="row">
                        <div class="col-5">
                            <p style="margin-bottom: 0px;"><strong>ID Cliente:  </strong><?php echo $c[0]; ?> </p>
                            <p style="margin-bottom: 0px;"><strong>Nome Loja: </strong><?php echo $c['nome_fantasia']; ?></p>
                            <p style="margin-bottom: 0px;"><strong>Nome Responsável: </strong><?php echo $c['nome'].' '.$c['sobrenome']; ?></p>
                            <p style="margin-bottom: 0px;"><strong>E-mail Responsável: </strong><?php echo $c['email']; ?></p>
                            <p style="margin-bottom: 0px;"><strong>Chave PIX: </strong><?php echo $c['chave_pix']; ?></p>
                            <br>
                            <p style="margin-bottom: 0px;"><strong> <a href="/painel/vendas-a-pagar/<?php echo $c['compra_id']; ?>">Transferir</a> </strong></p>
                        </div>
                        
                        <div class="col"> 
                            <b><p style="margin-bottom: 0px;">Subtotal compra: </b><?php echo 'R$'.number_format($c['subtotal_compra'],2,',','.'); ?></p>
                            <b><p style="margin-bottom: 0px;">Frete compra: </b><?php echo 'R$'.number_format($c['frete'],2,',','.'); ?></p>
                            <b><p style="margin-bottom: 0px;">Total compra: </b><?php echo 'R$'.number_format($c['total_compra'],2,',','.'); ?></p>
                            <b><p style="margin-bottom: 0px;">Data da compra: </b><?php echo date("d/m/Y", strtotime($c['data_compra'])); ?></p>
                            <b><p style="margin-bottom: 0px;">Subdominio: </b><?php echo $c['sub_dominio']; ?></p>
                            <b><p style="margin-bottom: 0px;">Ativo: </b><?php echo($c['ativo']=='1')?'SIM':"NÃO"; ?></p>
                            <p style="margin-bottom: 0px;"><strong>Recebido: </strong><?php echo ($c['recebido']==1?'SIM':'NÃO'); ?></p>
                            <br>
                        </div>
                        
                    </div>
                </fieldset> <br>
                <?php endforeach; ?>
            <?php endif; ?>

            </div>
        </div>
    </div>

</div>



<?php $render("sitePrincipal/footer_paineladm"); ?>

<script>

  $('.ati').click(function(){
    id = $(this).attr('id').split("-")

    if(id[0] == 'a'){
      $.confirm({
        title: 'Ativar cliente?',
        content: '',
        type: 'orange',
        buttons: {
            deleteUser: {
                text: 'Ativar',
                action: function () {
                  $.ajax({
                    url: '/ativar/cliente/'+id[1],
                    type: 'GET',
                    dataType: 'JSON',
                    success:function(r){
                      if(r.ret == true){
                        $.alert('Cliente ativado!');
                      }else{
                        $.alert('Ocorreu erro interno ao ativar cliente!');
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
    }else{
      $.confirm({
          title: 'Inativar cliente?',
          content: '',
          type: 'orange',
          buttons: {
              deleteUser: {
                  text: 'Inativar',
                  action: function () {
                    $.ajax({
                      url: '/inativar/cliente/'+id[1],
                      type: 'GET',
                      dataType: 'JSON',
                      success:function(r){
                        if(r.ret == true){
                          $.alert('Cliente inativado!');
                        }else{
                          $.alert('Ocorreu erro interno ao inativar cliente!');
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
    }
  });

</script>