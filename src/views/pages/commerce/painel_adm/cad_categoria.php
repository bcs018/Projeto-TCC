<?php
if(!isset($_SESSION['log_admin'])){
  header("Location: /admin");
  exit;
}

$render("commerce/header_painel", ['title'=>'Painel administrativo | Cadastrar Categoria']); 
?>

<div class="content-wrapper" style="min-height: 1227.43px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cadastrar Categoria</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Dados</h3>
                        </div>
                        <form role="form" action="/admin/painel/cadastrar-categorias/action" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <?php 
                                    if(isset($_SESSION['message'])){
                                        echo $_SESSION['message'];
                                        unset($_SESSION['message']);
                                    }
                                    ?>
                                    <label for="exampleInputEmail1">Nome categoria</label>
                                    <input type="text" class="form-control" id="nomeCategoria" name="nomeCategoria"
                                        placeholder="Insira o nome da categoria">
                                </div>

                                <div class="form-group">
                                    <label>Selecione a categoria pai</label>
                                    <select class="form-control select2" style="width: 100%;" name="subCategoria" id="subCategoria">
                                        <?php if(!isset($cat)): ?>
                                            <option value="0"></option>
                                        <?php else: ?>
                                            <option value="0" selected></option>
                                            <?php foreach ($cat as $dado): ?>
                                            <option value="<?php echo $dado['categoria_id'] ?>"><?php echo $dado['nome_cat'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Cadastrar</button>
                            </div>
                        </form>
                    </div> 
                    
                    <div class="card card-lightblue">
                        <div class="card-header">
                            <h3 class="card-title"><b>Estrutura atual das categorias</b></h3>
                        </div>
                        <div class="card-body">
                    
                         <?php foreach($catOrga as $dado): ?>                               
                         <?php echo '<b>- '.$dado['nome_cat'].'</b>'; ?>
                            <?php 
                            if(count($dado['subs'])>0){
                                $render("commerce/subcategoria", array(
                                    'subs' => $dado['subs'],
                                    'level' => 1
                                ));
                            }
                            ?>
                            <br>
                         <?php endforeach; ?>
                        </div>
                    </div>            

                    <div class="card card-lightblue">
                        <div class="card-header">
                            <h3 class="card-title"><b>O que é categoria pai?</b></h3>
                        </div>
                        <div class="card-body">
                            <h6>
                                Quando se cria uma categoria com uma categoria pai, significa que aquela categoria a ser
                                criada é filha da categoria pai selecionada,
                                isso possibilita a criação de varias categorias para o produto, exemplo:
                            </h6>
                            <h6>
                                Temos a categoria "Camiseta", e irei criar uma nova categoria chamada "Manga curta",
                                selecionando no campo categoria pai a "Camiseta", então siginifica que
                                na categoria camiseta existe outro tipo de categoria "Manga curta", podendo fazer
                                estrutura de arvores com as categorias, como exemplo:
                            </h6>
                            <h6>
                                <b>-- Camisetas</b> <br>
                                ----- Manga Curta <br>
                                ----- Manga Longa <br>
                                <b>-- Tênis</b> <br>
                                ----- Com Cardaço <br>
                                ----- Sem Cardaço
                            </h6>
                            <h6>
                                No exemplo acima a categoria Manga Curta e Manga Longa possui a categoria pai Camisetas e
                                Com cardaço e Sem Cardaço possui a categoria pai Tênis.
                            </h6>
                            <h6>
                                Para criar uma categoria <b>PAI</b> como Camisetas e Tênis, deixar o campo "Categoria pai" selecionado em "Deixar esta categoria como PAI".
                            </h6>
                        </div>
                    </div>
                    <br><br>
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
  $(function () {
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