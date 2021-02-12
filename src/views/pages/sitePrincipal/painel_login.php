<?php $render('sitePrincipal/header', ['title' => 'BW Commerce | Painel']); ?>

<?php 
if(!isset($_SESSION['log'])){
    $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">Faça login para continuar!</div>';
    header("Location: /login");
}
?>

<h1>painel...</h1>

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
