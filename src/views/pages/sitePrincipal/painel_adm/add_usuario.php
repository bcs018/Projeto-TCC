<?php
$render("sitePrincipal/header_paineladm", ['title'=>'Painel administrativo - Criar novo usuário']);
?>

<div class="content-wrapper" style="min-height: 1227.43px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Adicionar novo usuário</h1><br>

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
                        <form role="form" method="POST" action="/painel/add-usuario/action">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                            <label for="exampleInputEmail1">Nome</label>
                                            <input type="text" class="form-control" name="nome" id="nome">
                                        </div>
                                    </div>
 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                            <label for="exampleInputEmail1">Login</label>
                                            <input type="text" class="form-control" name="login" id="login">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                            <label for="exampleInputEmail1">Senha</label>
                                            <input type="password" class="form-control" name="senha" id="altSenha">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                            <label for="exampleInputEmail1">Repita a senha</label>
                                            <input type="password" class="form-control" name="senhaRep"
                                                id="altSenhaRep">
                                        </div>
                                        <div id="message"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Incluir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $render("sitePrincipal/footer_paineladm"); ?>

<script src="<?php echo BASE_ASS_C; ?>js/validaSenha.js"></script>

