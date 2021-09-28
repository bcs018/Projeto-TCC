<?php
if(!isset($_SESSION['log_admin_c'])){
  header("Location: /admin");
  exit;
}

$render("commerce/header_painel", ['title'=>'Painel administrativo | Relatório']); 
?>

<?php 

$vendas = array(10,20,30,50);
$custos = array(8,15,37,23);

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

                    <div id='message'><?php echo $u; ?></div>

                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
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

$array['periodo']['jan']

?>

<script type="text/javascript"> 
    //Ao terminar de carregar a pagina ele mostra o grafico
    window.onload = function(){
      //Pega o contexto que esta no canvas
      var contexto = document.getElementById("grafico").getContext("2d");
      new Chart(contexto, {
          //Tipo do grafico
          type:'line',
          //Dados do grafico
          data:{
              labels:[['Janeiro','2021'], 'Fevereiro', 'Março', 'Abril'],
              datasets:[{
                  //Tipo de dados
                  label:'Vendas',
                  backgroundColor:'#FF0000',
                  borderColor:'#FF0000',
                  //Dados que preencheram o grafico vindo do php
                  data:[ <?php echo implode(',',$vendas);?> ],
                  fill:false
              },{
                  label:'Custos',
                  backgroundColor:'#00FF00',
                  borderColor:'#00FF00',
                  data:[ <?php echo implode(',',$custos); ?> ],
                  fill:false
              }],
          }
      });
    }
    
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