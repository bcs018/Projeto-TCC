<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Admin;
use \src\models\commerce\Produto;
use \src\models\commerce\Info;
use \src\models\commerce\Cadastro;
use src\models\commerce\Carrinho;

class PagamentoController extends Controller {
    // public function index(){
    //     $tpPgm = $_POST['tpPgm'];

    //     if($tpPgm != 'card' && $tpPgm != 'bol'){
    //         echo json_encode(['erro'=>false]);
    //         exit;
    //     }
    //     if($tpPgm == 'card'){
    //        header("Location: /pagamento");
    //     }

    //     echo json_encode(['erro'=>true]);
    //     exit;
    // }

    public function pagamento(){
        $info = new Info;
        $carr = new Carrinho;

        $produtos = $carr->listaItens($_SESSION['carrinho']);

        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        $this->render('commerce/lay01/pagamento',['dados'=>$dados,'produtos'=>$produtos]);

    }
}