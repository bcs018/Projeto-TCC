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
                    <form role="form" name="detalheProduto" method="POST" enctype="multipart/form-data" action="/admin/painel/edi-layout">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><b>Escolha do layout</b></h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="bd-example">
                                        <label for="banner">Esolha um layout para seu e-commerce</label>
                                        <select class="form-control" style="width: 100%;" name="escolhaLay" id="escolhaLay">
                                            <option value="lay01" <?php echo($dados['layout']=='lay01')?'selected':'' ?> >Layout 01</option>
                                            <?php if($dados['plano_id'] != '1'): ?>
                                                <option value="lay02" <?php echo($dados['layout']=='lay02')?'selected':'' ?>>Layout 02</option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><b>Nome Fantasia</b></h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="bd-example">
                                        <label for="banner">Altere o nome fantasia de sua loja </label>
                                        <input type="text" class="form-control" name="nomeFant" value="<?php echo $dados['nome_fantasia']; ?>">
                                    </div>
                                </div>                                
                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><b>Banner da pagina principal</b></h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="bd-example">
                                        <label for="banner">Adicione imagem ao seu banner (Banners de 1160x350 até 1163x399 mega pixels) </label>
                                        <input type="file" class="form-control" name="banner">
                                    </div>
                                </div>

                                <div class="form-group">
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

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><b>Imagens de Marcas</b></h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="bd-example">
                                        <label for="marca">Adicione imagem das marcas em que você trabalha (Imagens de 250x100 até 950x700 mega pixels) </label>
                                        <input type="file" class="form-control" name="marca">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div style="float: left;color: red;font-weight: bold;">*&nbsp;</div>
                                    <label>Selecione a marca vinculado a imagem</label>
                                    <select class="form-control select2" style="width: 100%;" name="marcaId" id="marcaId">
                                        <?php foreach ($marcas as $marca) : ?>
                                            <option value="<?php echo $marca['marca_id']; ?>"><?php echo $marca['nome_mar']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <h5>Exemplo das marcas:</h5>
                                    <img src="<?php echo BASE_ASS_C; ?>images/marca_ex.jpg" class="img-fluid" width="900px" height="350px" alt="Exemplo de banner">
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><b>Cor secundária</b></h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="bd-example">
                                    <label for="cor" class="form-label">Selecione a cor</label>
                                    <input type="color" name="cor" class="form-control form-control-color" value="<?php echo $dados['cor']; ?>" title="Escolha sua cor">                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><b>Cor do rodapé</b></h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="bd-example">
                                    <label for="corRodape" class="form-label">Selecione a cor</label>
                                    <input type="color" name="corRodape" class="form-control form-control-color" value="<?php echo $dados['cor_rodape']; ?>" title="Escolha sua cor">                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-success">Editar</button>
                        </div>
                        
                        <br><br>

                        <nav aria-label="...">
                            <ul class="pagination justify-content-center">
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link" href="/admin/painel/layout">1</a>
                                </li>
                                <li class="page-item">
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

<!-- <div class="modal" id="aviso" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">AVISO!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Você não cadastrou nenhuma conta referente ao recebimento de suas vendas!.</p>
        <p>Vá no MENU "Dados para recebimento" e cadastre sua conta PagSeguro ou Mercado Pago</p>
        <p><b>CASO VOCÊ NÃO CADASTRE, SEUS CLIENTES NÃO VÃO CONSEGUIR EFETUAR COMPRAS E EVENTUALMENTE 
            VOCÊ NÃO IRÁ RECEBER!!!
        </b></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div> -->

<?php require_once('aviso.php'); ?>

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

<script>
    $(document).ready(function(){
        if( <?php echo $control_rec; ?> == '0'){
            $('#aviso').modal('show')
       }
    });
</script>