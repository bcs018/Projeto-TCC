<?php
if(!isset($_SESSION['log_admin_c'])){
  header("Location: /login/c");
  exit;
}

$render("commerce/header_painel_cliente", ['title'=>'Painel administrativo | Editar dados pessoais']); 
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
                                        <p style="margin-bottom: 0px;"><strong>Método pagamento: <?php echo ($compra['tipo_pagamento']=='cartao')?'Cartão de crédito':'Boleto'; ?></strong></p>
                                    </div>
                                    <div class="col"> 
                                        <b><p style="margin-bottom: 0px;">Data da compra: <?php echo $compra['data_compra']; ?></p></b>
                                        <?php if($compra['status_pagamento'] == '1'): ?>
                                            <b><p style="margin-bottom: 0px; color: #c98d00;">Aguardando pagamento</p></b>
                                        <?php elseif($compra['status_pagamento'] == '2'): ?>
                                            <b><p style="margin-bottom: 0px; color: #c98d00;">Em análise</p></b>
                                        <?php elseif($compra['status_pagamento'] == '3' && $compra['enviado'] == '0'): ?>
                                            <b><p style="margin-bottom: 0px; color: #0dc200;">Paga</p></b>
                                            <b><p style="margin-bottom: 0px; color: #c98d00;">O vendedor está preparando seu produto</p></b>
                                        <?php elseif($compra['status_pagamento'] == '3' && $compra['enviado'] == '1'): ?>
                                            <b><p style="margin-bottom: 0px; color: #0dc200;">Paga</p></b>
                                            <b><p style="margin-bottom: 0px; color: #0dc200;">Produto enviado</p></b>
                                        <?php elseif($compra['status_pagamento'] == '7'): ?>
                                            <b><p style="margin-bottom: 0px; color: #f55a42;">Compra cancelada</p></b>
                                        <?php endif; ?>
                                        <p><a href="/cliente/painel/meus-pedidos/<?php echo $compra['compra_id']; ?>">Visualizar</a></p>
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

<script type="text/javascript">
    $('#celular').mask("(00)00000-0000");
</script>

<?php $render("commerce/footer_painel"); ?>

<script src="<?php echo BASE_ASS_C; ?>js/validaSenha.js"></script>
