<?php $render("sitePrincipal/header_paineladm", ['title'=>'Painel administrativo - Alterar dados pessoais']); ?>

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $title; ?></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Preencha somente os campos que necessite alterar</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data" id="alt_dados_pessoais">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nome</label>
                    <input type="text" class="form-control" name="nome" value="<?php echo $_SESSION['log_admin']['nome']; ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Insira sua senha atual</label>
                    <input type="password" class="form-control" placeholder="Senha atual" name="senha_atu">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Insira a nova senha</label>
                    <input type="password" class="form-control" placeholder="Nova senha" name="senha_nov">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Repita a nova senha</label>
                    <input type="password" class="form-control" placeholder="Repita a nova senha" name="senha_rep">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Foto</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="foto" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Alterar</button>
                </div>
              </form>
            </div>
            </div>
        </div>
    </div>

</div>

<?php $render("sitePrincipal/footer_paineladm"); ?>
