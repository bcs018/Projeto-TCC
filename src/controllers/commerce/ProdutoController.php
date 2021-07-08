<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Produto;
use \src\models\commerce\Marca;
use \src\models\commerce\Categoria;
use \src\controllers\commerce\AdminController;

class ProdutoController extends Controller {
    /**
     * --- PRODUTO
     */

    // View para consulta de produtos
    public function conProduto(){
        AdminController::listaDadosEcommerce();

        $prod = new Produto;

        $dados = $prod->listaProdutos();

        $this->render('commerce/painel_adm/con_produto', ['dados'=>$dados]);

    }

    // View para cadastro de produtos
    public function cadProduto(){
        AdminController::listaDadosEcommerce();

        $mar = new Marca;
        $cat = new Categoria;

        $dados['marcas']     = $mar->listaMarcas();
        $dados['categorias'] = $cat->listaCategorias();

        $this->render('commerce/painel_adm/cad_produto', $dados);

    }

    // PAREI AQUI, FAZER UM FOREACH NAS IMAGENS NA VIEW con_detalhe_prod
    public function conProdutoDetalhe($id){
        AdminController::listaDadosEcommerce();

        $prod = new Produto;

        $dados = $prod->listaProduto(addslashes($id['id']));

        $this->render('commerce/painel_adm/con_detalhe_prod', $dados);
    }

    // Cadastro de produtos
    public function cadProdutoActionFirst(){
        $nomeProd   = addslashes($_POST['nomeProd']);
        $descProd   = addslashes($_POST['descProd']);
        $categoria  = addslashes($_POST['categoria']);
        $marca      = addslashes($_POST['marca']);
        $estoque    = addslashes($_POST['estoque']);
        $preco      = addslashes($_POST['preco']);
        $precoAnt   = addslashes($_POST['precoAnt']);
        $promo      = addslashes($_POST['promo']);
        $novo       = addslashes($_POST['novo']);

        $cad = new Produto;
        $dados = $cad->cadProdutoActionFirst($nomeProd, $descProd, $categoria, $marca, $estoque, $preco, $precoAnt, $promo, $novo);

        if(isset($_SESSION['message']))
            $dados['message'] = $_SESSION['message'];
        else 
            $dados['message'] = '';

        unset($_SESSION['message']);

        echo json_encode($dados);

        //header("Location: /admin/painel/cadastrar-produtos");
        exit;
    }

    public function cadProdutoSecond($id){
        AdminController::listaDadosEcommerce();

        $prod = new Produto;

        if(!$prod->listaProduto($id['id'])){
            $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">
                                        Produto inexistente!
                                    </div>';

            header("Location: /admin/painel/produtos");

            exit;
        }

        $this->render('commerce/painel_adm/cad_produto_2', $id);
    }

    public function cadProdutoActionSecond(){

        if(isset($_FILES['imagem'])){
            $img = new Produto;
            
            if($img->cadProdutoActionSecond($_FILES, addslashes($_POST['id']))){
                header("Location: /admin/painel/produtos");

                exit;
            }
            header("Location: /admin/painel/cadastrar-produtos/".addslashes($_POST['id']));
            
        }

    }

}