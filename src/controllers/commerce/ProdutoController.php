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

        $this->render('commerce/painel_adm/cad_produto_2', $id);
    }

    public function cadProdutoActionSecond(){

        if(isset($_FILES['imagem'])){
            if(count($_FILES['imagem']['tmp_name']) > 0){
                for($i=0; $i < count($_FILES['imagem']['tmp_name']); $i++){
                    $tpArq = explode('/', $_FILES['imagem']['type'][$i]);

                    $nomeArq = $_SESSION['id_sub_dom'].md5($_FILES['imagem']['name'][$i].rand(0,999).time()).'.'.$tpArq[1];

                    move_uploaded_file($_FILES['imagem']['tmp_name'][$i], '../assets/commerce/images_commerce/'.$nomeArq);
                }
            }
        }
    }
}