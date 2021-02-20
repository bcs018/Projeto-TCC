<?php
namespace src\controllers;

use \core\Controller;
use \src\models\Plano;

class OpcaoPgmController extends Controller {

    public function index($idPlano){
        $plano = new Plano;
        $plano->inserirPlano($idPlano['pl']);
        $pl = $plano->pegarItem($idPlano['pl']);

        //Ira abrir a pagina de para escolher o tipo de pagamento, ao selecionar e enviar caira no metodo abaixo para abrir a pagina certa
        $this->render('sitePrincipal/pagamentoOpcao',  ['plano'=>$pl]);
    }

    public function escolhaPagamento($idPlano, $opPgm){
        $plano = new Plano;
        
        $pl = $plano->pegarItem($idPlano['pl']);

        if($opPgm == 1){
            $this->render('sitePrincipal/pagamentoPlano',  ['plano'=>$pl]);
        }else{
            // Fazer o boleto
        }
    }

}