<?php
if(!isset($_SESSION['log_admin_c'])){
  header("Location: /admin");
  exit;
}

$render("commerce/header_painel_cliente", ['title'=>'Painel administrativo | Editar dados pessoais']); 
?>

<div class="content-wrapper" style="min-height: 1227.43px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Editar dados pessoais</h1><br>

                    <center><br><h6 style="color: #fa3200;font-weight: bold;">Campos marcados com asterisco
                                    (*) são obrigatórios.</h6></center>
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Dados</h3>
                        </div>
                        <form role="form" method="POST" action="/cliente/painel/alterar-dados-pessoais/action">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                            <label for="exampleInputEmail1">Nome</label>
                                            <input type="text" class="form-control" name="nome" id="nome"
                                                value="<?php echo $dados['nome_usu_ue']; ?>">
                                            <input type="hidden" value="<?php echo $dados['usuario_id']; ?>" name="id">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                            <label for="exampleInputEmail1">Sobrenome</label>
                                            <input type="text" class="form-control" name="sobrenome" id="sobrenome"
                                                value="<?php echo $dados['sobrenome']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                            <label for="exampleInputEmail1">Celular</label>
                                            <input type="text" class="form-control" name="celular" id="celular"
                                                value="<?php echo $dados['celular_ue']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Alterar senha</label>
                                            <input type="password" class="form-control" name="altSenha" id="altSenha">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Repita a senha</label>
                                            <input type="password" class="form-control" name="altSenhaRep"
                                                id="altSenhaRep">
                                        </div>
                                        <div id="message"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Editar</button>
                            </div>
                        </form>
                    </div>
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
