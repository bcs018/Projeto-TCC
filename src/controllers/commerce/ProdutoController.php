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

        $this->render('commerce/painel_adm/con_produto'/*, ['dados'=>$dados]*/);

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

    // Cadastro de produtos
    public function cadProdutoActionFirst(){
        $nomeProd = addslashes($_POST['nomeProd']);
        $descProd = addslashes($_POST['descProd']);
        $estoque  = addslashes($_POST['estoque']);
        $preco    = addslashes($_POST['preco']);
        $precoAnt = addslashes($_POST['precoAnt']);
        $promo    = addslashes($_POST['promo']);
        $novo     = addslashes($_POST['novo']);

        $cad = new Produto;
        $cad->cadProdutoActionFirst($nomeProd, $descProd, $estoque, $preco, $precoAnt, $promo, $novo);


        header("Location: /admin/painel/cadastrar-produtos");
        exit;
    }
}