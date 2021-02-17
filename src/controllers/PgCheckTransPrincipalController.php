<?php
namespace src\controllers;

use \core\Controller;
use \src\models\Plano;
use \src\models\Assinatura;

class PgCheckTransPrincipalController extends Controller {
    public function pagamentoPlano($idpl){

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
        
        $pl = $plano->pegarItem($idpl);
        $plano->inserirPlano($idpl);
        
        $this->render('sitePrincipal/pagamentoPlano',  ['plano'=>$pl, 'sessionCode'=>$session]);
    }

    public function checkout(){
        $assinatura = new Assinatura;

        $assinatura->inserirAss($_POST);

    }
}