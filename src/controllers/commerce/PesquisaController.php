<?php
namespace src\controllers\commerce;

use \core\Controller;
use src\models\commerce\Pesquisa;
use \src\models\commerce\Info;
use \src\models\commerce\Carrinho;

class PesquisaController extends Controller {

    public function pesquisa(){
        $texto = addslashes($_POST['busca']);

        $pes = new Pesquisa;
        $info = new Info;
        $carr = new Carrinho;

        if(isset($_SESSION['carrinho'])){
            $carrinho = $carr->listaItens($_SESSION['carrinho']);
        }else{
            $carrinho = false;
        }


        $dados   = $info->pegaDadosCommerce($_SESSION['sub_dom']);
        $produtos = $pes->pesquisa($texto);

        $this->render('commerce/'.$dados['layout'].'/produtos', [
                                                                'produtos' => $produtos,
                                                                'carrinho' => $carrinho,
                                                                'dados'    => $dados,
                                                                'txt'      => $texto
                                                            ]);
    }

}