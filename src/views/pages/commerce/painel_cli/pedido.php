<?php
if(!isset($_SESSION['log_admin_c'])){
  header("Location: /login/c");
  exit;
}

$render("commerce/header_painel_cliente", ['title'=>'Painel administrativo | Editar dados pessoais']); 
?>

<div class="content-wrapper" style="min-height: 1227.43px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Compra número: XX<br>
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
                                <?php  //$_SESSION['subtotal'] = 0; ?>
                                <?php foreach($pedido as $p): ?>
                                <tr>
                                    <td><a
                                            href="/visualizar/produto/<?php echo $p['0']; ?>"><?php echo $p['nome_pro']; ?></a>
                                    </td>
                                    <td><?php echo 'R$ '. number_format($p['preco'],2,',','.'); ?></td>
                                    <td><?php echo $p['quantidade']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="3" style="text-align:right"><b>SUBTOTAL: <div id="totalfinal"
                                                style="display:inline;">
                                                <?php echo 'R$ '. number_format( $p['subtotal_compra'],2,',','.'); ?>
                                            </div></b></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align:right"><b>FRETE: <div id="totalfinal"
                                                style="display:inline;">
                                                <?php echo 'R$ '. number_format( $p['frete'],2,',','.'); ?></div></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align:right"><b>TOTAL: <div id="totalfinal"
                                                style="display:inline;">
                                                <?php echo 'R$ '. number_format( $p['total_compra'],2,',','.'); ?></div>
                                            </b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h5>Método de pagamento:</h5>
                    <p>cartao</p>
                </div>
                <div class="col-md-6">
                    <h5>Método de pagamento:</h5>
                    <p>cartao</p>
 
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $('#celular').mask("(00)00000-0000");
</script>

<?php $render("commerce/footer_painel"); ?>

<script src="<?php echo BASE_ASS_C; ?>js/validaSenha.js"></script>