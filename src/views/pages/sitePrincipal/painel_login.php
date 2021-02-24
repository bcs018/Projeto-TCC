<?php $render('sitePrincipal/header', ['title' => 'BW Commerce | Painel']); ?>

<section class="ftco-section bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a style="float:right;font-size:18px;color:red;margin-top:16px;" href="/sair">Sair</a>

                <h2>Informações do cadastro</h2>
                <br>
                <fieldset class="border p-2">
                   <legend class="w-auto">Dados gerais</legend>
                   <div class="row">
                        <div class="col-md-6">
                            <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Nome do usuário:</label>
                            <p><?php echo $usuario['nome'].' '.$usuario['sobrenome']; ?></p>
                        </div>
                        
                        <div class="col-md-6">
                            <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Plano escolhido:</label>
                            <p><?php echo $plano['nome_plano']; ?></p>
                        </div>
                        
                        <div class="col-md-6">
                            <label style="color: #525252;font-weight: bold;margin-bottom: 0;">E-mail:</label>
                            <p><?php echo $usuario['email']; ?></p>
                        </div>

                        <div class="col-md-6">
                            <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Nome fantasia:</label>
                            <p><?php echo $plano['nome_fantasia']; ?></p>
                        </div>

                        <div class="col-md-6">
                            <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Subdominio:</label>
                            <p><?php echo $plano['sub_dominio']; ?></p>
                        </div>

                        <div class="col-md-6">
                            <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Usuário ativo?</label>
                            <p><?php echo ($usuario['ativo']==0)?'Não':'Sim'; ?></p>
                        </div>

                        <div class="col-md-6">
                            <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Direitos:</label>
                            <?php $planos = explode(';', $plano['descricao_plano']); ?>
                            <?php foreach($planos as $item): ?>
                                <p style="margin-bottom:0;"> <?php echo $item ?> <br></p>
                            <?php endforeach; ?>
                        </div>
                   </div>
                </fieldset>
                <br>

                <?php if($assinatura != false && $plano['plano_id'] != 1): ?>
                    <fieldset class="border p-2">
                    <legend class="w-auto">Dados do pagamento</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Número da compra:</label>
                                <p><?php echo $assinatura['assinatura_id']; ?></p>
                            </div>

                            <div class="col-md-6">
                                <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Valor:</label>
                                <p><?php echo 'R$'.number_format($assinatura['valor_total'],2,',','.'); ?></p>
                            </div>
                            
                            <div class="col-md-6">
                                <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Tipo de pagamento:</label>
                                <p><?php echo ($assinatura['tipo_pagamento']=='pagsegurockttransparente')?'Cartão de crédito':'Boleto'; ?></p>
                            </div>

                            <div class="col-md-6">
                                <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Status pagamento:</label>
                                <p><?php echo ($assinatura['status_pagamento']==0)?'Pendente':'Pago'; ?></p>
                            </div>

                            <div class="col-md-6">
                                <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Código transação:</label>
                                <p style="word-wrap: break-word;"><?php echo $assinatura['cod_transacao']; ?></p>
                            </div>

                        </div>
                    </fieldset>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<br><br><br><br>



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
