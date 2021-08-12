<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Produto;
use \src\models\commerce\Info;
use \src\controllers\commerce\AdminController;

class CarrinhoController extends Controller {

    public function index(){
        $info = new Info;
        $prod = new Produto;

        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        if(isset($_SESSION['carrinho'])){
           
        }

        $this->render('commerce/lay01/carrinho', ['dados'=>$dados]);
    }

    public function addCarrinho(){
        $prod = new Produto;

        $produto = $prod->listaProduto(addslashes(intval($_POST['id_produto'])));

        if(empty($_POST['id_produto']) || !$produto){
            $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">
                                       Produto inexistente!
                                    </div>';
            header("Location: /");
            exit;
        }


        // if(!$produto){
        //     $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">
        //                                Produto inexistente!
        //                             </div>';
        //     header("Location: /");
        // }

        // Sessão que guarda os produtos do carrinho, sendo o id do prod. como chave e o valor como quant. do produto
        $_SESSION['carrinho'][] = $_POST['id_produto'];

        header("Location: /carrinho");
        exit;
    }

}