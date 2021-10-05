<?php 

$total_geral = 0;
$total_vendas = 0;

if($rel['total'] != 0){
  foreach($rel['total'] as $r){
    $total_geral += floatval($r);
  }
}

$render("sitePrincipal/header_paineladm", ['title'=>'Painel administrativo - Relatório']); 

?>

<div class="content-wrapper" style="min-height: 1227.43px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Relatório de vendas</h1><br>
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
          <label>Selecione o intervalo de datas</label><br>
            <form method="POST" action="/painel/relatorio">
              <div class="row">
                <div class="col-3">
                  <label>Data incio:</label><br>
                  <input type="date" name="data_ini" class="form-control">
                </div>
                <div class="col-3">
                  <label>Data final:</label><br>
                  <input type="date" name="data_fim" class="form-control">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-5">
                  <input type="submit" class="btn btn-success" value="Aplicar">
                </div>
              </div>
            </form>
            <br><br>
            <div class="row">
                <div class="col">         
                  <canvas id="grafico"></canvas>
                </div>
            </div>
            <div class="row">
                <div class="col"> 
                  <br>
                  <h2>Relatório detalhado</h2>
                  <br>
                  <h5>Periodo: <?php echo date('d/m/Y', strtotime($ini)) ?> até  <?php echo date('d/m/Y', strtotime($fim)) ?></h5>
                  <br>
                  <h5>Total geral: R$<?php echo number_format($total_geral, 2, ',','.'); ?></h5>
                  <h5 id="totvenda"></h5>
                  <br>
                  <?php if($rel['compras'] != ''): ?>
                    <?php foreach($rel['compras'] as $compra): ?>  
                      <?php $total_vendas++ ?>      
                      <fieldset class="border p-2">
                        <div class="row">
                            <div class="col-5">
                                <p style="margin-bottom: 0px;"><strong>Assinatura n°:  <?php echo $compra['assinatura_id']; ?> </strong></p>
                                <p style="margin-bottom: 0px;"><strong>Valor compra: R$<?php echo number_format($compra['valor_total'],2,',','.'); ?></strong></p>
                                <p style="margin-bottom: 0px;"><strong>Plano contratado: <?php echo $compra['nome_plano']; ?></strong></p>
                                <p style="margin-bottom: 0px;"><strong>Subdominio: <?php echo $compra['sub_dominio']; ?></strong></p><br>
                                <!-- <br><a href="/admin/painel/venda/<?php echo $compra['compra_id']; ?>">DETALHES</a> -->

                            </div>
                            <div class="col"> 
                                <b><p style="margin-bottom: 0px;">Data da compra: <?php echo date('d/m/Y', strtotime($compra['data_transacao'])). ' às: '. $compra['hora_transacao']; ?></p></b>
                                <?php if($compra['status_pagamento'] == '1' || $compra['status_pagamento'] == 'waiting'): ?>
                                    <b><p style="margin-bottom: 0px; color: #c98d00;">Aguardando pagamento</p></b>
                                <?php elseif($compra['status_pagamento'] == 'active' || $compra['status_pagamento'] == 'paid'): ?>
                                    <b><p style="margin-bottom: 0px; color: #0dc200;">Paga</p></b>
                                <?php elseif($compra['status_pagamento'] == 'unpaid' || $compra['status_pagamento'] == 'canceled'): ?>
                                    <b><p style="margin-bottom: 0px; color: #f55a42;">Compra cancelada ou não paga</p></b>
                                <?php elseif($compra['status_pagamento'] == 'contested'): ?>
                                    <b><p style="margin-bottom: 0px; color: #c98d00;">Pagamento em processo de contestação</p></b>
                                <?php elseif($compra['status_pagamento'] == 'settled'): ?>
                                    <b><p style="margin-bottom: 0px; color: #c98d00;">Cobrança foi confirmada manualmente</p></b>
                                <?php elseif($compra['status_pagamento'] == 'expired'): ?>
                                    <b><p style="margin-bottom: 0px; color: #c98d00;">Assinatura expirada. Todas as cobranças configuradas para a assinatura já foram emitidas</p></b>
                                <?php endif; ?>
                                <p style="margin-bottom: 0px;"><strong>Cod. Transação:  <?php echo $compra['cod_transacao']; ?> </strong></p>
                                <p style="margin-bottom: 0px;"><strong>Nome Responsável:  <?php echo $compra['nome']. ' '.$compra['sobrenome']; ?> </strong></p>
                                <p style="margin-bottom: 0px;"><strong>E-mail Responsável:  <?php echo $compra['email']; ?> </strong></p>
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

<?php $render("sitePrincipal/footer_paineladm"); ?>

<script type="text/javascript"> 
    window.onload = function(){
      var contexto = document.getElementById("grafico").getContext("2d");
      new Chart(contexto, {
          type:'line',
          options: {
              plugins: {
                  title: {
                      display: true,
                      text: 'Gráfico de vendas por por mês'
                  }
              }
          },
          data:{
              labels:[<?php echo $rel['mes']; ?>],
              datasets:[{
                  label:'Valor das vendas R$',
                  backgroundColor: '#10e0c5',
                  borderColor:'#10e0c5',
                  data:[ <?php echo implode(',',$rel['total']);?> ],
                  fill: null,
                  pointStyle: 'circle',
                  pointRadius: 9,
              }],
          },
      });
    }
</script>

<script>
  $("#totvenda").html('<?php echo 'Total de vendas: '.$total_vendas; ?>')
</script>