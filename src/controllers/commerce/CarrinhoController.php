<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Produto;
use \src\models\commerce\Info;
use \src\models\commerce\Carrinho;

class CarrinhoController extends Controller {

    public function index(){
        $info = new Info;
        $prod = new Produto;
        $carr = new Carrinho;

        //unset($_SESSION['carrinho']);

        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        if(!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0){
            $carrinho = '<br><div class="alert alert-info" role="alert">
                            Não há produtos em seu carrinho!
                         </div>';

            $this->render('commerce/lay01/carrinho', ['dados'=>$dados, 'carrinho'=>$carrinho, 'control'=>true]);
            exit;
        }

        $carrinho = $carr->listaItens($_SESSION['carrinho']);

        $this->render('commerce/lay01/carrinho', ['dados'=>$dados, 'carrinho'=>$carrinho, 'control'=>false]);
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

        // Sessão que guarda os produtos do carrinho, sendo o id do prod. como chave e o valor como quant. do produto
        if(!isset($_SESSION['carrinho'])){
            $_SESSION['carrinho'] = [];
        }

        // VErifica se o produto ja está no carrinho
        if(isset($_SESSION['carrinho'][$_POST['id_produto']])){
            $_SESSION['carrinho'][$_POST['id_produto']] += 1;
        }else{
            $_SESSION['carrinho'][$_POST['id_produto']] = 1;
        }

        header("Location: /carrinho");
        exit;
    }

    public function delItem($idProd){
        if(!empty($_SESSION['carrinho']) || count($_SESSION['carrinho']) > 0){
            foreach($_SESSION['carrinho'] as $id => $qt){
                if(isset($_SESSION['carrinho'][$idProd['id']])){
                    unset($_SESSION['carrinho'][$idProd['id']]);

                    header("Location: /carrinho");
                    exit;
                }
            }
        }

        header("Location: /carrinho");
    }

}