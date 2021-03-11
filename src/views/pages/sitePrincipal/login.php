<?php $render('sitePrincipal/header', ['title' => 'BW Commerce | Login']); ?>

<?php 
if(isset($_SESSION['log'])){
	header("Location: /painel");
}
?>

<link rel="stylesheet" type="text/css" href="<?php echo BASE_ASS; ?>css/util.css">
<link rel="stylesheet" type="text/css" href="<?php echo BASE_ASS; ?>css//main.css">

<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
				<form method="POST" action="/login/validar" class="login100-form validate-form">
					<span class="login100-form-title p-b-33">
						<b>Login</b>
					</span>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="number" name="cpf" placeholder="<?php echo $tpLogin; ?>" >
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="wrap-input100 rs1 validate-input">
						<input class="input100" type="password" name="pass" placeholder="Informe sua senha">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="container-login100-form-btn m-t-20">
						<input type="submit" value="Entrar" class="login100-form-btn">
					</div>

					<?php 
					if(isset($_SESSION['message'])){
						echo $_SESSION['message'];
						unset($_SESSION['message']);
					}
					?>

					<br>
					<div class="text-center">
						<span class="txt1">
							Não tem uma conta?
						</span>

						<a href="/crie-sua-loja" class="txt2 hov1">Cadastre-se</a>
					</div>
				</form>
			</div>
		</div>
	</div>

<?php $render('sitePrincipal/footer'); ?>

