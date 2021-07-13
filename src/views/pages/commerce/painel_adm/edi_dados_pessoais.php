<?php
if(!isset($_SESSION['log_admin_c'])){
  header("Location: /admin");
  exit;
}

$render("commerce/header_painel", ['title'=>'Painel administrativo | Editar dados pessoais']); 
?>

<div class="content-wrapper" style="min-height: 1227.43px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Editar dados pessoais</h1>
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
                        <form role="form" method="POST" action="/admin/painel/editar-marca/action">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nome</label>
                                            <input type="text" class="form-control" name="nome" id="nome"
                                                value="<?php echo(isset($dados))?$dados['nome_mar']:''; ?>">
                                            <input type="hidden" value="<?php echo $dados['marca_id']; ?>" name="id">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Sobrenome</label>
                                            <input type="text" class="form-control" name="sobrenome" id="sobrenome"
                                                value="<?php echo(isset($dados))?$dados['nome_mar']:''; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Celular</label>
                                            <input type="text" class="form-control" name="celular" id="celular"
                                                value="<?php echo(isset($dados))?$dados['nome_mar']:''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Rua</label>
                                            <input type="text" class="form-control" name="rua" id="rua"
                                                value="<?php echo(isset($dados))?$dados['nome_mar']:''; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Bairro</label>
                                            <input type="text" class="form-control" name="bairro" id="bairro"
                                                value="<?php echo(isset($dados))?$dados['nome_mar']:''; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Número</label>
                                            <input type="number" class="form-control" name="numero" id="numero"
                                                value="<?php echo(isset($dados))?$dados['nome_mar']:''; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">CEP</label>
                                            <input type="number" class="form-control" name="cep" id="cep"
                                                value="<?php echo(isset($dados))?$dados['nome_mar']:''; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Cidade</label>
                                            <input type="text" class="form-control" name="cidade" id="cidade"
                                                value="<?php echo(isset($dados))?$dados['nome_mar']:''; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Complemento</label>
                                            <input type="text" class="form-control" name="complemento" id="complemento"
                                                value="<?php echo(isset($dados))?$dados['nome_mar']:''; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Alterar senha</label>
                                            <input type="password" class="form-control" name="altSenha" id="altSenha"
                                                value="<?php echo(isset($dados))?$dados['nome_mar']:''; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Repita a senha</label>
                                            <input type="password" class="form-control" name="altSenhaRep"
                                                id="altSenhaRep"
                                                value="<?php echo(isset($dados))?$dados['nome_mar']:''; ?>">
                                        </div>
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

<?php $render("commerce/footer_painel"); ?>