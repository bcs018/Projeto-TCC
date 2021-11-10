<?php
if (!isset($_SESSION['log_admin'])) {
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
                    <form role="form" name="detalheProduto" method="POST" action="/admin/painel/edi-layout2">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><b>Redes sociais</b></h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="bd-example">
                                        <label for="banner">Instagram</label>
                                        <input type="text" class="form-control" placeholder="Informe o link do Instagram de sua loja" name="insta" value="<?php echo ($dados['instagram']=='0')?'':$dados['instagram']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="bd-example">
                                        <label for="banner">Facebook</label>
                                        <input type="text" class="form-control" placeholder="Informe o link do Facebook de sua loja" name="face" value="<?php echo ($dados['facebook']=='0')?'':$dados['facebook']; ?>">
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <div class="bd-example">
                                        <label for="banner">LinkedIn</label>
                                        <input type="text" class="form-control" placeholder="Informe o link LinkedIn de sua loja" name="linke" value="<?php echo ($dados['linkedin']=='0')?'':$dados['linkedin']; ?>">
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <h5>
                                        Informe somente os campos em que você tenha conta na rede social. <br>
                                        As redes sociais serão mostradas no final da página.
                                    </h5>
                                </div>
                                <div class="form-group">
                                    <h5>Exemplo das Redes sociais:</h5>
                                    <img src="<?php echo BASE_ASS_C; ?>images/redes.jpg" class="img-fluid" width="900px" height="350px" alt="Exemplo de banner">
                                </div>                      
                            </div>
                        </div>

                        

                        <div class="text-right"><br>
                            <button type="submit" class="btn btn-success">Editar</button>
                        </div>
                        
                        <br><br>

                        <nav aria-label="...">
                            <ul class="pagination justify-content-center">
                                <li class="page-item" aria-current="page">
                                    <a class="page-link" href="/admin/painel/layout">1</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="/admin/painel/layout/2">2</a>
                                </li>
                            </ul>
                        </nav>

                        <br><br>
                    </form>
                </div>
            </div>
        </div>
    </section>

</div>

<?php require_once('aviso.php'); ?>

<?php $render("commerce/footer_painel"); ?>

<script>
    $(function() {
        $('.select2').select2()
    })
</script>

<script>
    $(document).ready(function(){
        if( <?php echo $control_rec; ?> == '0'){
            $('#aviso').modal('show')
       }
    });
</script>