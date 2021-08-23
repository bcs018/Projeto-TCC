<?php
namespace src\controllers\commerce;

use \core\Controller;
use PagSeguro\Resources\Responsibility\Configuration\File;
use \src\models\commerce\Admin;
use \src\models\commerce\Produto;
use \src\models\commerce\Marca;
use \src\models\commerce\Info;

class AdminCController extends Controller {
    // -- Pagina principal do painel de controle
    public function painel() {
        //$dados = $this->listaDadosEcommerce();

        $this->render('commerce/painel_cli/principal'/*, ['dados'=>$dados]*/);
    }
}