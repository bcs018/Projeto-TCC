<?php
if(!isset($_SESSION['login_cliente_ecommerce'])){
  header("Location: /login/c");
  exit;
}

$render("commerce/header_painel_cliente", ['title'=>'Painel administrativo | Meus pedidos']); 
?>

<div class="content-wrapper" style="min-height: 1227.43px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Meus pedidos<br>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <?php 
                    if(isset($_SESSION['message'])){
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    } 
                    ?>

                    <?php if(!$compras): ?>
                        <div class="alert alert-info" role="alert">
                            Você ainda não comprou nenhum item!
                        </div>
                    <?php else: ?>
                        <?php foreach($compras as $compra): ?>
                            <fieldset class="border p-2">
                                <div class="row">
                                    <div class="col-5">
                                        <a href="/cliente/painel/meus-pedidos/<?php echo $compra['compra_id']; ?>">
                                            <p style="margin-bottom: 0px;"><strong>Compra n°:  <?php echo $compra['compra_id']; ?> </strong></p>
                                        </a>
                                        <p style="margin-bottom: 0px;"><strong>Valor compra: R$<?php echo number_format($compra['total_compra'],2,',','.'); ?></strong></p>
                                        <p style="margin-bottom: 0px;"><strong>Método pagamento: <?php echo ($compra['tipo_pagamento']=='cartao')?'Cartão de crédito':'Boleto'; ?></strong></p><br>
                                        <p><a class="btn btn-info" href="/cliente/painel/meus-pedidos/<?php echo $compra['compra_id']; ?>">Visualizar</a></p>

                                    </div>
                                    <div class="col"> 
                                        <b><p style="margin-bottom: 0px;">Data da compra: <?php echo date('d/m/Y', strtotime($compra['data_compra'])). ' às: '. $compra['hora_compra']; ?></p></b>
                                        <?php if($compra['status_pagamento'] == '1' || $compra['status_pagamento'] == 'in_process' || $compra['status_pagamento'] == 'pending_waiting_payment'): ?>
                                            <b><p style="margin-bottom: 0px; color: #c98d00;">Aguardando pagamento</p></b>
                                        <?php elseif($compra['status_pagamento'] == '2' || $compra['status_pagamento'] == 'in_process'): ?>
                                            <b><p style="margin-bottom: 0px; color: #c98d00;">Em análise</p></b>
                                        <?php elseif(($compra['status_pagamento'] == '3' || $compra['status_pagamento'] == 'approved') && $compra['enviado'] == '0'): ?>
                                            <b><p style="margin-bottom: 0px; color: #0dc200;">Paga</p></b>
                                            <b><p style="margin-bottom: 0px; color: #c98d00;">O vendedor está preparando seu produto</p></b>
                                        <?php elseif(($compra['status_pagamento'] == '3' || $compra['status_pagamento'] == 'approved') && $compra['enviado'] == '1'): ?>
                                            <b><p style="margin-bottom: 0px; color: #0dc200;">Paga</p></b>
                                            <b><p style="margin-bottom: 0px; color: #0dc200;">Produto enviado</p></b>
                                        <?php elseif($compra['status_pagamento'] == '7' || $compra['status_pagamento'] == 'rejected'): ?>
                                            <b><p style="margin-bottom: 0px; color: #f55a42;">Compra cancelada</p></b>
                                        <?php endif; ?>
                                        <br>
                                        <button id="r-<?php echo $compra['compra_id']; ?>" class="btn btn-success">Marcar como recebido</button>
                                        <!-- <input type="hidden" value="<?php //echo $compra['compra_id']; ?>" id="idcompra"> -->
                                    </div>
                                </div>
                            </fieldset> <br>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    

                </div>
            </div>
        </div>
    </section>
</div>

<?php $render("commerce/footer_painel"); ?>

<script>

$('button').click(function(){
    id = $(this).attr('id').split("-")
    $.confirm({
      title: 'Marcar como Recebido?',
      content: '',
      type: 'orange',
      buttons: {
          deleteUser: {
              text: 'SIM',
              action: function () {
                $.ajax({
                  url: '/cliente/painel/marcar-recebido',
                  type: 'POST',
                  dataType: 'JSON',
                  data:{
                    id:id[1]
                  },
                  success:function(r){
                    if(r.ret == true){
                      $.alert('Marcado como Recebido!');
                    }else{
                      $.alert('Ocorreu erro interno!');
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