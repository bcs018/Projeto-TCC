<?php
namespace src\controllers\commerce;

use \core\Controller;
use PagSeguro\Resources\Responsibility\Configuration\File;
use \src\models\commerce\AdminC;
use \src\models\commerce\Produto;
use \src\models\commerce\Marca;
use \src\models\commerce\Info;

/**
 * Controller destinado ao painel de controle dos clientes
 * dos ecommerces
 */

class AdminCController extends Controller {
    public static function listaDadosEcommerce(){
        $login = new AdminC;
        $dados = $login->listaDados($_SESSION['sub_dom']);

        if($dados == false){
            header("Location: /login/c");
            exit;
        }

        $_SESSION['log_admin_c']['nome'] = $dados['nome_usu_ue'];

        return $dados;
    } 

    // -- Pagina principal do painel de controle
    public function painel() {
        $dados = $this->listaDadosEcommerce();

        $this->render('commerce/painel_cli/principal'/*, ['dados'=>$dados]*/);
    }
}