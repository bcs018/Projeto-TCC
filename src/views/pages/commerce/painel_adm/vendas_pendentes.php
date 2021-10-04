<?php
$render("commerce/header_painel", ['title'=>'Painel administrativo | Vendas pendentes']); 
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
                  <?php if($vendas != 0): ?>
                    <?php foreach($vendas as $v): ?>  
                      <fieldset class="border p-2">
                        <div class="row">
                            <div class="col-5">
                                <p style="margin-bottom: 0px;"><strong>Compra n°:  </strong><?php echo $v['compra_id']; ?> </p>
                                <p style="margin-bottom: 0px;"><strong>Valor compra: </strong>R$<?php echo number_format($v['total_compra'],2,',','.'); ?></p>
                                <p style="margin-bottom: 0px;"><strong>Método pagamento: </strong><?php echo ($v['tipo_pagamento']=='cartao')?'Cartão de crédito':'Boleto'; ?></p>
                                <br><a href="/admin/painel/venda/<?php echo $v['compra_id']; ?>">ALTERAR PARA ENVIADO</a>
                            </div>
                            <div class="col"> 
                                <p style="margin-bottom: 0px;"><strong>Data da compra: </strong><?php echo date('d/m/Y', strtotime($v['data_compra'])). ' às: '. $v['hora_compra']; ?></p>
                                <p style="margin-bottom: 0px;"><strong>Status: </strong><?php echo ($v['status_pagamento']=='approved' || $v['status_pagamento'] == '3')?'Aprovado':''; ?></p>
                                <p style="margin-bottom: 0px;"><strong>Cod. Transação:  </strong><?php echo $v['cod_transacao']; ?> </p>
                                <p style="margin-bottom: 0px;"><strong>Pagamento:  </strong><?php echo $v['parcela']; ?> </p>
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