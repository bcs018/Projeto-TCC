<?php
if (!isset($_SESSION['log_admin_c'])) {
    header("Location: /admin");
    exit;
}

$render("commerce/header_painel", ['title' => 'Painel administrativo | Layout']);
?>

<div class="content-wrapper" style="min-height: 1184.92px;">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Editar layout do ecommerce</h1>
                </div>
            </div>
            <?php
            if (isset($_SESSION['message'])) {
                echo '<br>'.$_SESSION['message'];
                unset($_SESSION['message']);
            }
            ?>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <form role="form" name="detalheProduto" method="POST" enctype="multipart/form-data" action="/admin/painel/edi-layout">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><b>Banner da pagina principal</b></h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="bd-example">
                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                        <label for="banner">Adicione imagem ao seu banner (Banners de 1160x360 até 1163x363 mega pixels) </label>
                                        <input type="file" class="form-control" name="banner">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label>Selecione o produto vinculado ao banner</label>
                                    <select class="form-control select2" style="width: 100%;" name="produtoId" id="produto">
                                        <?php foreach ($produtos as $produto) : ?>
                                            <option value="<?php echo $produto['produto_id']; ?>"><?php echo $produto['nome_pro']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <h5>Exemplo do banner circulado em vermelho:</h5>
                                    <img src="<?php echo BASE_ASS_C; ?>images/banner_ex.jpg" class="img-fluid" width="900px" height="350px" alt="Exemplo de banner">
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><b>Logotipo</b></h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="bd-example">
                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                        <label for="logo">Adicione seu logotipo (Logotipo de 170x60 até 180x70 mega pixels) </label>
                                        <input type="file" class="form-control" name="logo">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <h5>Exemplo do logotipo circulado em vermelho:</h5>
                                    <img src="<?php echo BASE_ASS_C; ?>images/logo_ex.jpg" class="img-fluid" width="900px" height="350px" alt="Exemplo de logotipo">
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><b>Icone da barra do navegador</b></h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="bd-example">
                                        <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                        <label for="ico">Adicione seu icone</label>
                                        <input type="file" class="form-control" name="ico">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <h5>Somente arquivo .ico <br>Para converter arquivos em .ico acessar o site <a href="https://icoconvert.com/" target="_blank">icoconvert.com</a> <br><br>
                                    Exemplo do icone circulado em vermelho:</h5>
                                    <img src="<?php echo BASE_ASS_C; ?>images/ico_ex.jpg" class="img-fluid" alt="Exemplo do icone na barra do navegador">
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
    </section>

</div>

<?php $render("commerce/footer_painel"); ?>

<script>
    $(function() {
        $('.select2').select2()
    })
</script>

<script type="text/javascript">
    $('#preco').mask("# ##0,00", {
        reverse: true
    });
    $('#precoAnt').mask("# ##0,00", {
        reverse: true
    });
</script>