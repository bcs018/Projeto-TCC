<?php $render('sitePrincipal/header', ['title' => 'PotLid Commerce | Painel']); ?>

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
                            <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Endereço de sua loja:</label>
                            <p><?php echo $plano['sub_dominio'].'.bw.com.br'; ?></p>
                        </div>

                        <div class="col-md-6">
                            <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Usuário ativo?</label>
                            <p><?php echo ($usuario['ativo']==0)?'Não':'Sim'; ?></p>
                        </div>

                        <div class="col-md-6">
                            <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Direitos:</label>
                            <?php $planos = explode(';', $plano['descricao_plano']); ?>
                            <?php foreach($planos as $item): ?>
                                <p style="margin-bottom:0;"> <?php echo utf8_encode($item) ?> <br></p>
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
                                <p><?php echo ($assinatura['tipo_pagamento']=='cartao')?'Cartão de crédito':'Boleto'; ?></p>
                            </div>

                            <div class="col-md-6">
                                <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Status pagamento:</label>
                                <p>
                                <?php switch ($assinatura['status_pagamento']) {
                                    case 'new': 
                                        echo 'Plano criado';
                                        break;
                                    
                                    // Forma de pagamento selecionada, aguardando a confirmação do pagamento
                                    case 'waiting':
                                        echo 'Aguardando pagamento';
                                        break;
                    
                                    // Assinatura ativa. Todas as cobranças estão sendo geradas
                                    case 'active': 
                                        echo 'Pago, aguardando proximo boleto';
                                        break;
                                    
                                    // Pagamento confirmado
                                    case 'paid':
                                        echo 'Pago';
                                        break;
                                    
                                    // Não foi possível confirmar o pagamento da cobrança
                                    case 'unpaid': 
                                        echo 'Não pago';
                                        break;
                    
                                    // Assinatura foi cancelada pelo vendedor ou pelo pagador
                                    case 'canceled': 
                                        echo 'Não pago';
                                        break;
                    
                                    // Pagamento devolvido pelo lojista ou pelo intermediador Gerencianet
                                    case 'refunded': 
                                        echo 'Pagamento devolvido';
                                        break;
                    
                                    // Pagamento em processo de contestação
                                    case 'contested': 
                                        echo 'Em contestação';
                                        break;
                    
                                    // Cobrança foi confirmada manualmente
                                    case 'settled': 
                                        echo 'Pago manualmente';
                                        break;
                    
                                    // Assinatura expirada. Todas as cobranças configuradas para a assinatura já foram emitidas
                                    case 'expired': 
                                        echo 'Expirada';
                                        break;
                                    
                                    default:
                                        echo 'Inativo';
                                        break;
                                } ?>
                                </p>
                            </div>

                            <?php 
                            if(!empty( $link_bol['link_boleto'])): ?>
                                <div class="col-md-6">
                                    <label style="color: #525252;font-weight: bold;margin-bottom: 0;">2º via boleto:</label> <br>
                                    <a target="_blank" href="<?php echo $link_bol['link_boleto']; ?>">Clique aqui para abrir seu boleto</a>
                                </div>
                            <?php endif; ?>
                            
                            <?php 
                            if(!empty( $assinatura['cod_transacao'])): ?>
                            <div class="col-md-6">
                                <label style="color: #525252;font-weight: bold;margin-bottom: 0;">Código transação:</label>
                                <p style="word-wrap: break-word;"><?php echo $assinatura['cod_transacao']; ?></p>
                            </div>
                            <?php endif; ?>

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
