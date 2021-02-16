<?php
namespace src\controllers;

use \core\Controller;
use \src\models\Plano;

class PgCheckTransPrincipalController extends Controller {
    public function pagamentoPlano($pl){

        //Pegando a sessão do pagseguro
        try {
            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            $session = $sessionCode->getResult();
        } catch (\Exception $e) {
            echo "OCORREU ERRO DURANTE O PROCESSO: ".$e->getMessage();
            exit;
        }

        $plano = new Plano;
        $pl = $plano->pegarItem($pl);
        
        $this->render('sitePrincipal/pagamentoPlano',  ['plano'=>$pl, 'sessionCode'=>$session]);
    }

    public function checkout(){
        
    }
}