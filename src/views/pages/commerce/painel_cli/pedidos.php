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
                    <fieldset class="border p-2">
                        <div class="row">
                            <div class="col-5">
                                <img src="<?php echo BASE_ASS_C ?>images/semfoto.jpg" alt="" width="70px" height="70px">
                                <p style="margin-bottom: 0px;"><strong>Nome do Produto</strong></p>
                                <p style="margin-bottom: 0px; color: #51c900;"><strong>R$89,36</strong></p>
                            </div>
                            <div class="col">
                                <b><p style="margin-bottom: 0px;">25/09/2021</p></b>
                                <b><p style="margin-bottom: 0px; color: #c98d00;">Aguardando pagamento</p></b>
                                <b><p style="margin-bottom: 0px; color: #c98d00;">O vendedor está preparando seu produto</p></b>
                                <b><p style="margin-bottom: 0px; color: #aec900;">Produto enviado</p></b>
                                <b><p style="margin-bottom: 0px; color: #0dc200;">Entregue</p></b>

                            </div>
                        </div>
                    </fieldset> <br>

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
