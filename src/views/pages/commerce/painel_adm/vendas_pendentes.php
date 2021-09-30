<?php
$render("commerce/header_painel", ['title'=>'Painel administrativo | Vendas pendentes', 'qtdNoti'=>$qtdNoti]); 
?>

<div class="content-wrapper" style="min-height: 1227.43px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Vendas pendentes</h1><br>
                    <?php
                    if(isset($_SESSION['message'])){
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }
                    ?>
                    <div id='message'></div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col"> 
                  <br>
                  <h5>Verifique as vendas pendentes, embale-as e envie pelos Correios, após isso marque-a como enviada!</h5>
                  <br>
                  <?php if($rel['compras'] != ''): ?>
                    <?php foreach($rel['compras'] as $compra): ?>  
                      <fieldset class="border p-2">
                        <div class="row">
                            <div class="col-5">
                                <p style="margin-bottom: 0px;"><strong>Compra n°:  <?php echo $compra['compra_id']; ?> </strong></p>
                                <p style="margin-bottom: 0px;"><strong>Valor compra: R$<?php echo number_format($compra['total_compra'],2,',','.'); ?></strong></p>
                                <p style="margin-bottom: 0px;"><strong>Método pagamento: <?php echo ($compra['tipo_pagamento']=='cartao')?'Cartão de crédito':'Boleto'; ?></strong></p>
                            </div>
                            <div class="col"> 
                                <b><p style="margin-bottom: 0px;">Data da compra: <?php echo date('d/m/Y', strtotime($compra['data_compra'])). ' às: '. $compra['hora_compra']; ?></p></b>
                                <?php if($compra['status_pagamento'] == '1' || $compra['status_pagamento'] == 'in_process' || $compra['status_pagamento'] == 'pending_waiting_payment'): ?>
                                    <b><p style="margin-bottom: 0px; color: #c98d00;">Aguardando pagamento</p></b>
                                <?php elseif($compra['status_pagamento'] == '2' || $compra['status_pagamento'] == 'in_process'): ?>
                                    <b><p style="margin-bottom: 0px; color: #c98d00;">Em análise</p></b>
                                <?php elseif($compra['status_pagamento'] == '3' || $compra['status_pagamento'] == 'approved' && $compra['enviado'] == '0'): ?>
                                    <b><p style="margin-bottom: 0px; color: #0dc200;">Paga</p></b>
                                    <b><p style="margin-bottom: 0px; color: #c98d00;">Produto em preparação</p></b>
                                <?php elseif($compra['status_pagamento'] == '3' || $compra['status_pagamento'] == 'approved' && $compra['enviado'] == '1'): ?>
                                    <b><p style="margin-bottom: 0px; color: #0dc200;">Paga</p></b>
                                    <b><p style="margin-bottom: 0px; color: #0dc200;">Produto enviado</p></b>
                                <?php elseif($compra['status_pagamento'] == '7' || $compra['status_pagamento'] == 'rejected'): ?>
                                    <b><p style="margin-bottom: 0px; color: #f55a42;">Compra cancelada</p></b>
                                <?php endif; ?>
                                <p style="margin-bottom: 0px;"><strong>Cod. Transação:  <?php echo $compra['cod_transacao']; ?> </strong></p>
                                <p style="margin-bottom: 0px;"><strong>Pagamento:  <?php echo $compra['parcela']; ?> </strong></p>
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