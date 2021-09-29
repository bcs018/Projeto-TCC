<?php
if(!isset($_SESSION['log_admin_c'])){
  header("Location: /admin");
  exit;
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
            <br><br><br>
            <div class="row">
                <div class="col">         
                  <canvas id="grafico"></canvas>
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

<?php 

//echo '<pre>';print_r($dados);


// $ultimo_dia = date("t", mktime(0,0,0, date("m"),'01', date("Y")));

// echo $dados['plano_id'].'<br>';

// echo $dados['data_cad'];

// echo date("Y-m").'-'.$ultimo_dia

$data1 = '2021-03-01';
$data2 = '2021-04-02';

$resul = strtotime($data2) - strtotime($data1);
$dias = floor($resul/(60*60*24));

echo $dias;

//183 dias = 6 meses

?>

<script type="text/javascript"> 
    window.onload = function(){
      var contexto = document.getElementById("grafico").getContext("2d");
      new Chart(contexto, {
          type:'line',
          data:{
              labels:[<?php echo $rel['mes']; ?>],
              datasets:[{
                  label:'Valor das vendas R$',
                  backgroundColor:<?php echo "'".$dados['cor']."'"; ?>,
                  borderColor:<?php echo "'".$dados['cor']."'"; ?>,
                  data:[ <?php echo implode(',',$rel['total']);?> ],
                  fill:false
              }],
          },
      });
    }
</script>

<script>
  //Date range picker
  $('#reservation').daterangepicker({
    locale: {
        format: 'MM/DD/YYYY'
      }
  })
</script>

<script>
  $(function () {
    $('.select2').select2()
  })
</script>

<script>
    $(document).ready(function(){
        if( <?php echo $control_rec; ?> == '0'){
            $('#aviso').modal('show')
       }
    });
</script>