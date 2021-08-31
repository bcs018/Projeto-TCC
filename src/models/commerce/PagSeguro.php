<?php 

namespace src\models\commerce;

use \core\Model;
use \src\models\commerce\Info;

class PagSeguro extends Model{
    public static function setDados(){
        $info = new Info;
        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        \PagSeguro\Library::initialize();
        \PagSeguro\Library::cmsVersion()->setName($dados['nome_fantasia'])->setRelease("1.0.0");
        \PagSeguro\Library::moduleVersion()->setName($dados['nome_fantasia'])->setRelease("1.0.0");

        return $dados;
    }
}