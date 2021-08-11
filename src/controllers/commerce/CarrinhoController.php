<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Categoria;
use \src\models\commerce\Info;
use \src\controllers\commerce\AdminController;

class CarrinhoController extends Controller {

    public function index(){
        $info = new Info;

        $dados    = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        $this->render('commerce/lay01/carrinho', ['dados'=>$dados]);
    }

}