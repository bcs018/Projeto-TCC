<?php
namespace src\controllers;

use \core\Controller;
use \src\models\Painel;
use \src\models\Assinatura;


class PainelController extends Controller {
    public function index(){
        if(!isset($_SESSION['log'])){
            header("Location: /login");
            exit;
        }

        $painel = new Painel;
        $ass = new Assinatura;
        
        $usu = $painel->listaDadosUsuario($_SESSION['log']['id']);
        $plano = $painel->listaDadosPlano($_SESSION['log']['id']);
        $assinatura = $ass->pegarItem($_SESSION['log']['id']);

        $dados = [
                  'usuario'    =>$usu, 
                  'plano'      =>$plano,
                  'assinatura' =>$assinatura                  
                 ];

        $this->render('sitePrincipal/painel_login', $dados);
    }

    public function admin(){
        if(!isset($_SESSION['log_admin'])){
            header("Location: /login");
            exit;
        }

        $this->render('sitePrincipal/painel_admin');

    }
}