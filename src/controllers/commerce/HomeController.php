<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Info;
use \src\models\commerce\Produto;
use \src\models\commerce\Marca;
use \src\models\commerce\Categoria;

class HomeController extends Controller {

    public function index() {
        $info = new Info;
        $prod = new Produto;
        $marc = new Marca;
        $cate = new Categoria;

        $dados    = $info->pegaDadosCommerce($_SESSION['sub_dom']);
        $produtos = $prod->listaProdutosImg('DESC');
        $marcas   = $marc->listaMarcas();
        $produtosBanner = array();
        $imgMarcas = array();

        // Pegando somente as marcas que possuem imagens
        if(!empty($marcas)){
            foreach($marcas as $m){
                if($m['marca_img'] != '0'){
                    $imgMarcas[] = $m;
                }
            }
        }

        // Pegando somente os produtos que possuem banner
        if(!empty($produtos)){
            foreach($produtos as $p){
                if($p['banner_img'] != '0'){
                    $produtosBanner[] = $p;
                }
            }
        }

        if($dados['logotipo'] != '0'){
            $_SESSION['logo'] = $dados['logotipo'];
        }
        if($dados['ico'] != '0'){
            $_SESSION['ico'] = $dados['ico'];
        }

        $this->render('commerce/'.$dados['layout'].'/home', [
                                                                'dados'      => $dados, 
                                                                'produtos'   => $produtos, 
                                                                'prodBanner' => $produtosBanner,
                                                                'marcasImg'  => $imgMarcas
                                                            ]);
    }

    public function sobre() {
        $this->render('sobre');
    }

    public function sobreP($args) {
        print_r($args);
    }

}