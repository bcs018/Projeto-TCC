<?php  
if(isset($_SESSION['login_cliente_ecommerce'])){
  // redirecionar para o painel de controle
  header("Location: /");
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo BASE_ASS; ?>adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo BASE_ASS; ?>adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo BASE_ASS; ?>adminlte/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <b>Login</b>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Informe suas credênciais</p>

        <form id="login_cliente">
          <div id="message"></div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Login ou Email" name="login" value="<?php if(isset($_SESSION['credencial'])){ echo $_SESSION['credencial'];unset($_SESSION['credencial']); }?>">
            <div class="input-group-append">
              <div class="input-group-text">
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Senha" name="senha">
            <div class="input-group-append">
              <div class="input-group-text">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Entrar</button>
            </div>
            <!-- /.col -->
          </div>
          <?php 
          if(isset($_SESSION['message'])){
            echo '<br>'.$_SESSION['message'];
            unset($_SESSION['message']);
          }
          ?>
        </form>

        <p class="mb-1">
          <a href="forgot-password.html">Esqueci minha senha</a>
        </p>
        <p class="mb-0">
          <a href="register.html" class="text-center">Cadastre-se</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?php echo BASE_ASS; ?>adminlte/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo BASE_ASS; ?>adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo BASE_ASS; ?>adminlte/dist/js/adminlte.min.js"></script>
  <script src="<?php echo BASE_ASS_C; ?>lay01/js/login.js"></script>


</body>

</html>