<?php
if(!isset($_SESSION['log_admin_c'])){
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
                        <form role="form">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nome categoria</label>
                                    <input type="text" class="form-control" id="nomeCategoria"
                                        placeholder="Insira o nome da categoria">
                                </div>
                                <div class="form-group">
                                    <label>Selecione a subcategoria</label>
                                    <select class="custom-select">
                                        <option>option 1</option>
                                        <option>option 2</option>
                                        <option>option 3</option>
                                        <option>option 4</option>
                                        <option>option 5</option>
                                    </select>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Cadastrar</button>
                            </div>
                        </form>
                    </div> <br>

                    <div class="card card-lightblue">
                        <div class="card-header">
                            <h3 class="card-title"><b>O que é subcategoria?</b></h3>
                        </div>
                        <div class="card-body">
                            <h6>
                                Quando se cria uma categoria com uma subcategoria, significa que aquela categoria a ser
                                criada é filha da subcategoria selecionada,
                                isso possibilita a criação de varias categorias para o produto, exemplo:
                            </h6>
                            <h6>
                                Temos a categoria "Camiseta", e irei criar uma nova categoria chamada "Manga curta",
                                selecionando no campo subcategoria a "Camiseta", então siginifica que
                                na categoria camiseta existe outro tipo de categoria "Manga curta", podendo fazer
                                estrutura de arvores com as categorias, como exemplo:
                            </h6>
                            <h6>
                                --- Camisetas <br>
                                ----- Manga Curta <br>
                                ----- Manga Longa <br>
                                --- Tênis <br>
                                ----- Com Cardaço <br>
                                ----- Sem Cardaço
                            </h6>
                            <h6>
                                No exemplo acima a categoria Manga Curta e Manga Longa possui a subcategoria Camisetas e
                                Com cardaço e Sem Cardaço
                                possui a subcategoria Tênis.
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