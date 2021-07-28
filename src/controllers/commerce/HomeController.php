<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Info;
use \src\models\commerce\Produto;

class HomeController extends Controller {

    public function index() {
        $info = new Info;
        $prod = new Produto;

        $dados    = $info->pegaDadosCommerce($_SESSION['sub_dom']);
        $produtos = $prod->listaProdutos();

        $this->render('commerce/'.$dados['layout'].'/home', ['dados'=>$dados, 'produtos'=>$produtos]);

    }

    public function sobre() {
        $this->render('sobre');
    }

    public function sobreP($args) {
        print_r($args);
    }

}