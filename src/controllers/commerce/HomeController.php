<?php
namespace src\controllers\commerce;

use \core\Controller;
use src\models\commerce\Carrinho;
use \src\models\commerce\Info;
use \src\models\commerce\Produto;
use \src\models\commerce\Marca;
use \src\models\commerce\Categoria;

class HomeController extends Controller {

    public function index() {
        $info = new Info;
        $prod = new Produto;
        $marc = new Marca;
        $carr = new Carrinho;

        $dados    = $info->pegaDadosCommerce($_SESSION['sub_dom']);
        $produtos = $prod->listaProdutosImg('DESC');
        $marcas   = $marc->listaMarcas();
        if(isset($_SESSION['carrinho'])){
            $carrinho = $carr->listaItens($_SESSION['carrinho']);
        }else{
            $carrinho = false;
        }

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
                                                                'marcasImg'  => $imgMarcas,
                                                                'carrinho'   => $carrinho
                                                            ]);
    }

    public function visProduto($id){
        $prod = new Produto;
        $cate = new Categoria;
        $info = new Info;
        $carr = new Carrinho;

        $dados   = $info->pegaDadosCommerce($_SESSION['sub_dom']);
        $produto = $prod->listaProduto(addslashes($id['id']), 1);

        if(isset($_SESSION['carrinho'])){
            $carrinho = $carr->listaItens($_SESSION['carrinho']);
        }else{
            $carrinho = false;
        }
        
        if(!$produto){
            $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">
                                        Produto inexistente!
                                    </div><br>';

            header("Location: /");

            exit;
        }

        $produtos      = $prod->listaProdutos();
        $produtoRel    = $prod->listaProdutosRelacionados($produto[0]['categoria_id']);
        $categoriaProd = $cate->listaCategoriaOrganizada($produto[0]['categoria_id']);

        $this->render('commerce/'.$dados['layout'].'/produto', [
                                                                'produtos'    => $produtos,
                                                                'produto'     => $produto,
                                                                'produtosRel' => $produtoRel,
                                                                'categoria'   => $categoriaProd,
                                                                'dados'       => $dados,
                                                                'carrinho'    => $carrinho
                                                            ]);

    }

    public function produtos(){
        $prod = new Produto;
        $info = new Info;
        $carr = new Carrinho;

        if(isset($_SESSION['carrinho'])){
            $carrinho = $carr->listaItens($_SESSION['carrinho']);
        }else{
            $carrinho = false;
        }


        $dados   = $info->pegaDadosCommerce($_SESSION['sub_dom']);
        $produtos = $prod->listaProdutosImg('ASC');

        $this->render('commerce/'.$dados['layout'].'/produtos', [
                                                                'produtos' => $produtos,
                                                                'carrinho' => $carrinho,
                                                                'dados'    => $dados
                                                            ]);

    }

    public function produtosCategoria($id){
        $prod = new Produto;
        $info = new Info;
        $carr = new Carrinho;

        $dados   = $info->pegaDadosCommerce($_SESSION['sub_dom']);
        $produtos = $prod->listaProdutosRelacionados($id['id']);

        if(isset($_SESSION['carrinho'])){
            $carrinho = $carr->listaItens($_SESSION['carrinho']);
        }else{
            $carrinho = false;
        }

        $this->render('commerce/'.$dados['layout'].'/produtos', [
            'produtos' => $produtos,
            'carrinho' => $carrinho,
            'dados'    => $dados
        ]);

    }

    public function sobre() {
        $this->render('sobre');
    }

    public function sobreP($args) {
        print_r($args);
    }

}