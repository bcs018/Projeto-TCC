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
        $produtos = $prod->listaProdutosImg('DESC');
        $produtosBanner = array();

        if(!empty($produtos)){
            foreach($produtos as $p){
                if($p['banner_img'] != '0'){
                    $produtosBanner[] = $p;
                }
            }
        }

        $this->render('commerce/'.$dados['layout'].'/home', ['dados'=>$dados, 'produtos'=>$produtos, 'prodBanner'=>$produtosBanner]);

    }

    public function sobre() {
        $this->render('sobre');
    }

    public function sobreP($args) {
        print_r($args);
    }

}