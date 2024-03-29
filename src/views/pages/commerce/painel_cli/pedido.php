<?php
if(!isset($_SESSION['login_cliente_ecommerce'])){
  header("Location: /login/c");
  exit;
}
if(!$pedido)header("Location: /cliente/painel/meus-pedidos");

$render("commerce/header_painel_cliente", ['title'=>'Painel administrativo | Pedido n° '.$pedido[0]['compra_id']]); 
?>

<div class="content-wrapper" style="min-height: 1227.43px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Compra número: <?php echo $pedido[0]['compra_id']; ?><br>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h3>Produtos</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Preço</th>
                                    <th scope="col">Qtd</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($pedido as $p): ?>
                                <tr>
                                    <td>
                                        <a href="/visualizar/produto/<?php echo $p['0']; ?>"><?php echo $p['nome_pro']; ?></a>
                                    </td>
                                    <td><?php echo 'R$ '. number_format($p['preco'],2,',','.'); ?></td>
                                    <td><?php echo $p['quantidade']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="3" style="text-align:right">
                                        <b>
                                            SUBTOTAL: <div id="totalfinal" style="display:inline;"> <?php echo 'R$ '. number_format( $p['subtotal_compra'],2,',','.'); ?></div>
                                        </b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align:right"><b>FRETE: <div id="totalfinal" style="display:inline;">
                                        <?php echo 'R$ '. number_format( $p['frete'],2,',','.'); ?></div></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align:right">
                                        <b>TOTAL: <div id="totalfinal" style="display:inline;">
                                            <?php echo 'R$ '. number_format( $p['total_compra'],2,',','.'); ?></div>
                                        </b>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h5 style="margin-bottom: 0px;">Data da compra:</h5>
                    <p><?php echo date('d/m/Y', strtotime($p['data_compra'])).' às: '. $p['hora_compra']; ?></p>
                </div>

                <div class="col-md-6">
                    <h5 style="margin-bottom: 0px;">Método de pagamento:</h5>
                    <?php if($p['tipo_pagamento']=='cartao'): ?>
                        <p>Cartão de crédito</p>
                    <?php else: ?>
                        <p>Boleto <?php echo($p['status_pagamento']!='unpaid')?'<br> <a target="_blank" href="'.$p['link_bol'].'">Clique aqui </a>para acessar o boleto':''; ?></p>
                    <?php endif ?>
                </div>

                <div class="col-md-6">
                    <h5 style="margin-bottom: 0px;">Envio:</h5>
                    <?php if($p['enviado']=='0' && $p['status_pagamento'] == 'paid'): ?>
                        <p>O vendedor está preparando seu produto</p>
                    <?php elseif($p['enviado']=='1' && $p['status_pagamento'] == 'paid'): ?>
                        <p>Enviado</p>
                    <?php elseif($p['status_pagamento'] == 'unpaid'): ?>
                        <p>Compra cancelada</p>
                    <?php else: ?>
                        <p>Aguardando pagamento</p>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <h5 style="margin-bottom: 0px;">Status pagamento:</h5>
                    <?php if($p['status_pagamento'] == 'paid'): ?>
                        <p>Pago</p>
                    <?php elseif($p['status_pagamento'] == 'waiting'): ?>
                        <p>Aguardando pagamento</p>
                    <?php elseif($p['status_pagamento'] == 'unpaid'): ?>
                        <p>Compra cancelada</p>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <h5 style="margin-bottom: 0px;">Pagamento:</h5>
                    <p><?php echo $p['parcela']; ?></p>
                </div>

                <div class="col-md-6">
                    <h5 style="margin-bottom: 0px;">Código de Rastreio (Correios):</h5>
                    <p><?php echo ($p['cod_rastreio']=='0')?'Não informado':$p['cod_rastreio']; ?></p>
                </div>

                <div class="col-md-6">
                    <h5 style="margin-bottom: 0px;">Endereço de entrega:</h5>
                    <p><?php echo 'CEP '.$p['cep_entrega']; ?> <br>
                        <?php echo $p['rua_entrega'].', N° '.$p['numero_entrega']; ?><br>
                        <?php echo $p['bairro_entrega']; ?><br>
                        <?php echo $p['cidade_entrega'].' - '.$p['estado_entrega']; ?><br>
                        <?php echo $p['complemento_entrega']; ?></p>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $render("commerce/footer_painel_c"); ?>