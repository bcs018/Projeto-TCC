<?php
if(!isset($_SESSION['log_admin'])){
  header("Location: /admin");
  exit;
}

$total_geral = 0;
$total_vendas = 0;

if($rel['total'] != 0){
  foreach($rel['total'] as $r){
    $total_geral += floatval($r);
  }
}

$render("commerce/header_painel", ['title'=>'Painel administrativo | Relatório']); 
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
            <form method="POST" action="/admin/painel/relatorio-intervalo">
              <div class="row">
                <div class="col-6">
                  <label>Data incio:</label><br>
                  <input type="date" name="data_ini" class="form-control">
                </div>
                <div class="col-6">
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
                                <p style="margin-bottom: 0px;"><strong>Compra n°:  <?php echo $compra['compra_id']; ?> </strong></p>
                                <p style="margin-bottom: 0px;"><strong>Valor compra: R$<?php echo number_format($compra['total_compra'],2,',','.'); ?></strong></p>
                                <p style="margin-bottom: 0px;"><strong>Método pagamento: <?php echo ($compra['tipo_pagamento']=='cartao')?'Cartão de crédito':'Boleto'; ?></strong></p><br>
                                <br><a href="/admin/painel/venda/<?php echo $compra['compra_id']; ?>">DETALHES</a>

                            </div>
                            <div class="col"> 
                                <b><p style="margin-bottom: 0px;">Data da compra: <?php echo date('d/m/Y', strtotime($compra['data_compra'])). ' às: '. $compra['hora_compra']; ?></p></b>
                                <?php if($compra['status_pagamento'] == 'waiting'): ?>
                                    <b><p style="margin-bottom: 0px; color: #c98d00;">Aguardando pagamento</p></b>
                                <?php elseif(($compra['status_pagamento'] == 'paid' || $compra['status_pagamento'] == 'settled') && $compra['enviado'] == '0'): ?>
                                    <b><p style="margin-bottom: 0px; color: #0dc200;">Paga</p></b>
                                    <b><p style="margin-bottom: 0px; color: #c98d00;">Produto em preparação</p></b>
                                <?php elseif(($compra['status_pagamento'] == 'paid' || $compra['status_pagamento'] == 'settled') && $compra['enviado'] == '1'): ?>
                                    <b><p style="margin-bottom: 0px; color: #0dc200;">Paga</p></b>
                                    <b><p style="margin-bottom: 0px; color: #0dc200;">Produto enviado</p></b>
                                <?php elseif($compra['status_pagamento'] == 'unpaid'): ?>
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

<?php require_once('aviso.php'); ?>

<?php $render("commerce/footer_painel"); ?>

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
                  backgroundColor:<?php echo "'".$dados['cor']."'"; ?>,
                  borderColor:<?php echo "'".$dados['cor']."'"; ?>,
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

<script>
    $(document).ready(function(){
        if( <?php echo $control_rec; ?> == '0'){
            $('#aviso').modal('show')
       }
    });
</script>