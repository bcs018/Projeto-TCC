<?php
if(!isset($_SESSION['log_admin_c'])){
  header("Location: /login/c");
  exit;
}

$render("commerce/header_painel_cliente", ['title'=>'Painel administrativo | Contato']); 
?>

<div class="content-wrapper" style="min-height: 1227.43px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Entre em contato com <b><?php echo $dados['nome_fantasia']; ?></b> pelos meios:</h1><br>
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
                        <h4><i class="fas fa-phone">&nbsp;&nbsp; </i>Telefone: <?php echo $contato['celular']; ?></h4> <br>
                        <h4><i class="fas fa-envelope-open-text">&nbsp;&nbsp;</i>E-mail: <?php echo $contato['email']; ?></h4>
                    </fieldset>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $('#celular').mask("(00)00000-0000");
</script>

<?php $render("commerce/footer_painel_c"); ?>

<script src="<?php echo BASE_ASS_C; ?>js/validaSenha.js"></script>
