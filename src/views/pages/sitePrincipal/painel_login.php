<?php $render('sitePrincipal/header', ['title' => 'BW Commerce | Painel']); ?>

<?php 
if(!isset($_SESSION['log'])){
    $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">Faça login para continuar!</div>';
    header("Location: /login");
}
?>

<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h2>Informações do cadastro</h2><br>
                <fieldset class="border p-2">
                   <div class="row">
                        <div class="col-md-6">
                            <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Nome do usuário:</label>
                            <p><?php echo $usuario['nome'].' '.$usuario['sobrenome']; ?></p>
                        </div>
                        
                        <div class="col-md-6">
                            <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Plano contratado:</label>
                            <p>Teste</p>
                        </div>
                        
                        <div class="col-md-6">
                            <label style="color: #525252;font-weight: bold;margin-bottom: 0;">E-mail:</label>
                            <p><?php echo $usuario['email']; ?></p>
                        </div>
                   </div>
                </fieldset>
            </div>
        </div>
    </div>
</section>



<script type="text/javascript">
	var times = "<?php echo time()+300; ?>";
	times = parseInt(times);
	var newTimes = "<?php echo time(); ?>";
	newTimes = parseInt(newTimes);
	var inter = setInterval(function(){
		newTimes += 1;

        if(times < newTimes){
            clearInterval(inter);
            setTimeout(function(){ window.location.href="/sair" }, 60000);

            var s = confirm('Sua sessão será encerrada, clique em OK para continuar');

            if(s){
                window.location.reload()
            }else{
                window.location.href="/sair";
            }
		}
	
	}, 1000);		
</script>

<?php $render('sitePrincipal/footer'); ?>
