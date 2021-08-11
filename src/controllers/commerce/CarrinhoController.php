<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Produto;
use \src\models\commerce\Info;
use \src\controllers\commerce\AdminController;

class CarrinhoController extends Controller {

    public function index(){
        $info = new Info;

        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        $this->render('commerce/lay01/carrinho', ['dados'=>$dados]);
    }

    public function addCarrinho(){
        $prod = new Produto;

        if(empty($_POST['id_produto'])){
            $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">
                                       Produto inexistente!
                                    </div>';
            header("Location: /");
        }

        $produto = $prod->listaProduto(addslashes(intval($_POST['id_produto'])));

        if(!$produto){
            $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">
                                       Produto inexistente!
                                    </div>';
            header("Location: /");
        }
    }

}