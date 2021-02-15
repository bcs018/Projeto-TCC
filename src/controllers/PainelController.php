<?php
namespace src\controllers;

use \core\Controller;
use \src\models\Painel;


class PainelController extends Controller {
    public function index(){
        $painel = new Painel;

        $usu = $painel->listaDadosUsuario($_SESSION['log']['id']);
        $plano = $painel->listaDadosPlano($_SESSION['log']['id']);

        $dados = [
                  'usuario'=>$usu,
                  'plano'=>$plano
                 ];

        $this->render('sitePrincipal/painel_login', $dados);
    }
}