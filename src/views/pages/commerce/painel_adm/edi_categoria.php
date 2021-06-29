<?php
if(!isset($_SESSION['log_admin_c'])){
  header("Location: /admin");
  exit;
}

$render("commerce/header_painel", ['title'=>'Painel administrativo | Editar Categoria']); 
?>

<div class="content-wrapper" style="min-height: 1227.43px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Editar Categoria</h1>
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
                        <form role="form" action="/admin/painel/editar-categoria/action" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <?php 
                                    if(isset($_SESSION['message'])){
                                        echo $_SESSION['message'];
                                        unset($_SESSION['message']);
                                    }
                                    ?>
                                    <label for="exampleInputEmail1">Nome categoria</label>
                                    <input type="text" class="form-control" id="nomeCategoria" name="nomeCategoria" placeholder="Insira o nome da categoria" value="<?php echo $categoria['nome_cat']; ?>">
                                    <input type="hidden" value="<?php echo $categoria['categoria_id']; ?>" name="id">

                                </div>

                                <div class="form-group">
                                    <label>Selecione a categoria pai</label>
                                    <select class="form-control select2" style="width: 100%;" name="subCategoria" id="subCategoria">
                                        <?php if(!isset($categorias)): ?>
                                            <option value="0"></option>
                                        <?php else: ?>
                                            <option value="0" selected></option>
                                            <?php foreach ($categorias as $cat): ?>
                                            <option value="<?php echo $cat['categoria_id'] ?>"><?php echo $cat['nome_cat'] ?></option>
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
                    
                         <?php foreach($categoriasOrg as $dado): ?>                               
                         <?php echo '- '.$dado['nome_cat']; ?>
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
                                Para criar uma categoria <b>PAI</b> como Camisetas e Tênis, deixar o campo "Categoria pai" vazio (em branco).
                            </h6>
                        </div>
                    </div>
                    <br><br>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $render("commerce/footer_painel"); ?>

<script>
  document.getElementById('subCategoria').value = <?php echo $categoria['sub_cat']; ?>;

  $(function () {
    $('.select2').select2()
  })
</script>