<?php
$render("commerce/header_painel", ['title'=>'Painel administrativo | Venda n° '.$venda[0]['compra_id'], 'qtdNoti'=>$qtdNoti]); 
?>

<div class="content-wrapper" style="min-height: 1227.43px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Venda n° <?php echo $venda[0]['compra_id'] ?></h1><br>
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
                  <h5>Caso tenha enviado a encomenda, clique em ENVIADO para seu cliente saber que o produto ja foi enviado.</h5>
                  <br>
                  <hr>
                  <br>
                  <div class="row">
                      <div class="col-2">
                          <button data="<?php echo $venda[0]['compra_id']; ?>" id="enviar" class="btn btn-info">Enviado</button>
                      </div>
                      <div class="col">
                          <button data="<?php echo $venda[0]['compra_id']; ?>" id="naoenviar" class="btn btn-info">Não enviado</button>
                      </div>
                  </div><br>
                  <div class="row">
                      <div class="col">
                          <b><p id="enviado"><?php echo($venda[0]['enviado']=='0')?'Não enviado':'Enviado'; ?></p></b>
                      </div>
                  </div>
                  <br><br>
                  <?php if($venda != 0): ?>
                    <h4>Dados da compra</h4><br>
                    <div class="row">
                        <div class="col-5">
                            <p style="margin-bottom: 0px;"><strong>Compra n°:  </strong><?php echo $venda[0]['compra_id']; ?> </p>
                            <p style="margin-bottom: 0px;"><strong>Valor compra:</strong> R$<?php echo number_format($venda[0]['total_compra'],2,',','.'); ?></p>
                            <p style="margin-bottom: 0px;"><strong>Valor subtotal:</strong> R$<?php echo number_format($venda[0]['subtotal_compra'],2,',','.'); ?></p>
                            <p style="margin-bottom: 0px;"><strong>Valor frete: </strong>R$<?php echo number_format($venda[0]['frete'],2,',','.'); ?></p>
                        </div>
                        <div class="col"> 
                            <p style="margin-bottom: 0px;"><strong>Método pagamento:</strong> <?php echo ($venda[0]['tipo_pagamento']=='cartao')?'Cartão de crédito':'Boleto'; ?></p>
                            <p style="margin-bottom: 0px;"><strong>Data da compra: </strong><?php echo date('d/m/Y', strtotime($venda[0]['data_compra'])). ' às: '. $venda[0]['hora_compra']; ?></p>
                            <p style="margin-bottom: 0px;"><strong>Status: </strong><?php echo ($venda[0]['status_pagamento']=='approved' || $venda[0]['status_pagamento'] == '3')?'Aprovado':''; ?></p>
                            <p style="margin-bottom: 0px;"><strong>Cod. Transação:  </strong><?php echo $venda[0]['cod_transacao']; ?> </p>
                            <p style="margin-bottom: 0px;"><strong>Pagamento:  </strong><?php echo $venda[0]['parcela']; ?> </p>
                        </div>
                    </div>
                  <?php endif; ?>
                </div>
            </div>
            <br>
            <hr>
            <br>                
            <h4>Dados da entrega</h4><br>
            <div class="row">
                <div class="col-5">
                    <p style="margin-bottom: 0px;"><strong>Rua: </strong><?php echo $venda[0]['rua_entrega']; ?> - <strong>N°:</strong> <?php echo $venda[0]['numero_entrega']; ?></p>
                    <p style="margin-bottom: 0px;"><strong>Bairro: </strong><?php echo $venda[0]['bairro_entrega']; ?> </p>
                    <p style="margin-bottom: 0px;"><strong>Cidade: </strong><?php echo $venda[0]['cidade_entrega']; ?> </p><br>
                </div>
                <div class="col">
                    <p style="margin-bottom: 0px;"><strong>Estado: </strong><?php echo $venda[0]['estado_entrega']; ?> </p>
                    <p style="margin-bottom: 0px;"><strong>CEP: </strong><?php echo $venda[0]['cep_entrega']; ?> </p>                    <p style="margin-bottom: 0px;"><strong>Complemento: </strong><?php echo $venda[0]['complemento_entrega']; ?> </p> <br>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <p style="margin-bottom: 0px;"><strong>Quem recebe: </strong><?php echo $venda[0]['nome_usu_ue'].' '.$venda[0]['sobrenome']; ?> </p>
                    <p style="margin-bottom: 0px;"><strong>E-mail: </strong><?php echo $venda[0]['email_ue']; ?> </p>
                    <p style="margin-bottom: 0px;"><strong>Celular: </strong><?php echo $venda[0]['celular_ue']; ?> </p>
                </div>
            </div>
            <br>
            <hr>
            <br>                
            <h4>Produto(s)</h4><br>
            <?php foreach($venda as $v): ?>
                <div class="row">
                    <div class="col-5">
                        <p style="margin-bottom: 0px;"><strong>Nome: </strong><?php echo $v['nome_pro']; ?> </p>
                        <p style="margin-bottom: 0px;"><strong>Descricao do produto: </strong><?php echo $v['descricao']; ?> </p>
                    </div>
                    <div class="col">
                        <p style="margin-bottom: 0px;"><strong>Preço: </strong>R$<?php echo number_format($v['preco'],2,',','.'); ?></p>
                        <p style="margin-bottom: 0px;"><strong>Quantidade: </strong><?php echo $v['quantidade']; ?></p>
                    </div>
                </div> <br>
            <?php endforeach; ?>
        </div>
        <br><br><br><br><br>
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