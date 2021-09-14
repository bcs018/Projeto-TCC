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

        // unset($_SESSION['frete']);
        // unset($_SESSION['login_cliente_ecommerce']);
        
        $valores = $carr->somaValor();

        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);
        //echo '<pre>'; print_r($dados);

        if(!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0){
            $carrinho = '<br><div class="alert alert-info" role="alert">
                            Não há produtos em seu carrinho!
                         </div>';

            $this->render('commerce/'.$dados['layout'].'/carrinho', ['dados'=>$dados, 'carrinho'=>$carrinho, 'control'=>true]);
            exit;
        }
        //unset($_SESSION['login_cliente_ecommerce']);
        //print_r($valores);

        $carrinho = $carr->listaItens($_SESSION['carrinho']);

        //echo '<pre>'; print_r($_SESSION['frete']);

        $this->render('commerce/'.$dados['layout'].'/carrinho', ['dados'=>$dados, 'carrinho'=>$carrinho, 'valores'=>$valores, 'control'=>false]);
    }

    // public function pagamento(){
    //     $info = new Info;

    //     $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);
        
    //     $this->render('commerce/lay01/pagamento', ['dados'=>$dados/*, 'carrinho'=>$carrinho, 'valores'=>$valores, 'control'=>false*/]);
    // }

    public function calcFrete(){
        $carr = new Carrinho;
        $info = new Info;

        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        $frete = [];

        if(isset($_POST['id']))
            $id = $_POST['id'];
        else 
            $id = 0;

        if(!empty($_POST['cep'])){
            $cep = intval(str_replace('-','', $_POST['cep']));
            $frete = $carr->calculaFrete($cep, $dados['cep'], $id);
            $_SESSION['frete'] = $frete;
        }

        // if(!empty($_SESSION['frete'])){
        //     $frete = $_SESSION['frete'];
        // }

        echo json_encode($frete);
        exit;
    }

    public function verUsuarioLogado(){
        if(isset($_SESSION['login_cliente_ecommerce'])){  
            echo json_encode(['log'=>true]);
            exit;
        }
 
        $_SESSION['message'] = '<div class="alert alert-info" role="alert">
                                    Faça login para continuar!
                                </div>';
        echo json_encode(['log'=>false]);
        exit;
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

    // Calcula o preço total por produto
    public function calPrecoProduto(){
        $prod = new Produto;

        $id = $_POST['id'];
        $qt = $_POST['qt'];

        $produto = $prod->listaProduto($id);

        $valor = floatval($produto[0]['preco']) * $qt;

        $_SESSION['carrinho'][$id] = $qt;

        echo json_encode(['valor'=>number_format($valor, 2, ',','.')]);
        exit;
    }

    public function calTotalProduto(){
        $carr = new Carrinho;

        echo json_encode($carr->somaValor());
    }

    // Deleta a sessão do frete para fazer o calculo correto quando o usuario não informa nada no campo do CEP
    public function delSessaoFrete(){
        unset($_SESSION['frete']);

        echo json_encode(['deletado'=>'deletado']);
    }

}