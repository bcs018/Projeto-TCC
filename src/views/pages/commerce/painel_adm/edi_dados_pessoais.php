<?php
if(!isset($_SESSION['log_admin'])){
  header("Location: /admin");
  exit;
}

$render("commerce/header_painel", ['title'=>'Painel administrativo | Editar dados pessoais']); 
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
                        <form role="form" method="POST" action="/admin/painel/alterar-dados-pessoais/action">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                            <label for="exampleInputEmail1">Nome</label>
                                            <input type="text" class="form-control" name="nome" id="nome"
                                                value="<?php echo $dados['nome']; ?>">
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
                                                value="<?php echo $dados['celular']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                            <label for="exampleInputEmail1">CEP</label>
                                            <input type="text" class="form-control" name="cep" id="cep"
                                                value="<?php echo $dados['cep']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                            <label for="exampleInputEmail1">Rua</label>
                                            <input type="text" class="form-control" name="rua" id="rua"
                                                value="<?php echo $dados['rua']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                            <label for="exampleInputEmail1">Bairro</label>
                                            <input type="text" class="form-control" name="bairro" id="bairro"
                                                value="<?php echo $dados['bairro']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                            <label for="exampleInputEmail1">Número</label>
                                            <input type="number" class="form-control" name="numero" id="numero"
                                                value="<?php echo $dados['numero']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                            <label for="exampleInputEmail1">Cidade</label>
                                            <input type="text" class="form-control" name="cidade" id="cidade"
                                                value="<?php echo $dados['cidade']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                            <label for="exampleInputEmail1">Estado</label>
                                            <select class="form-control select2" style="width: 100%;" name="estado"
                                                id="estado">
                                                <?php foreach ($estados as $estado): ?>
                                                <option value="<?php echo $estado['estado_id'] ?>">
                                                    <?php echo $estado['nome_estado'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Complemento</label>
                                            <input type="text" class="form-control" name="complemento" id="complemento"
                                                value="<?php echo $dados['complemento']; ?>">
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

<?php require_once('aviso.php'); ?>

<script type="text/javascript">
    $('#cep').mask("00000-000");
    $('#celular').mask("(00)00000-0000");
</script>

<script>
    document.getElementById('estado').value = <?php echo $dados['estado_id']; ?>
</script>

<?php $render("commerce/footer_painel"); ?>
<script src="<?php echo BASE_ASS_C; ?>js/validaSenha.js"></script>

<script>
    $(document).ready(function(){
        if( <?php echo $control_rec; ?> == '0'){
            $('#aviso').modal('show')
       }
    });
</script>