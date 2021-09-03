<?php
if(!isset($_SESSION['log_admin_c'])){
  header("Location: /admin");
  exit;
}

$render("commerce/header_painel", ['title'=>'Painel administrativo | Adicionar novo usuário']); 
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
                        <form role="form" method="POST" action="/admin/painel/add-usuario/action">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                            <label for="exampleInputEmail1">Nome</label>
                                            <input type="text" class="form-control" name="nome" id="nome">
                                            <input type="hidden" value="<?php echo $dados['usuario_id']; ?>" name="id">
                                        </div>
                                    </div>
 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                            <label for="exampleInputEmail1">Sobrenome</label>
                                            <input type="text" class="form-control" name="sobrenome" id="sobrenome">
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
                                            <label for="exampleInputEmail1">E-mail</label>
                                            <input type="text" class="form-control" name="email" id="email">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                            <label for="exampleInputEmail1">Celular</label>
                                            <input type="text" class="form-control" name="celular" id="celular">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div> -->
                                            <label for="exampleInputEmail1">CEP</label>
                                            <input type="text" class="form-control" name="cep" id="cep">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div> -->
                                            <label for="exampleInputEmail1">Rua</label>
                                            <input type="text" class="form-control" name="rua" id="rua">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div> -->
                                            <label for="exampleInputEmail1">Bairro</label>
                                            <input type="text" class="form-control" name="bairro" id="bairro">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div> -->
                                            <label for="exampleInputEmail1">Número</label>
                                            <input type="number" class="form-control" name="numero" id="numero">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div> -->
                                            <label for="exampleInputEmail1">Cidade</label>
                                            <input type="text" class="form-control" name="cidade" id="cidade">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <!-- <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div> -->
                                            <label for="exampleInputEmail1">Estado</label>
                                            <select class="form-control select2" style="width: 100%;" name="estado"
                                                id="estado">
                                                <option value="0">Nenhum estado selecionado</option>
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
                                            <input type="text" class="form-control" name="complemento" id="complemento">
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
