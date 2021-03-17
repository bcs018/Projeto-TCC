<?php
namespace src\controllers;

use \core\Controller;
use \src\models\Painel;
use \src\models\Assinatura;


class PainelController extends Controller {

    public function index(){
        if(!isset($_SESSION['log_admin'])){
            header("Location: /admin-bwcommerce");
            exit;
        }

        $this->render('sitePrincipal/painel_adm/principal');

    }

    public function alterarDadosPessoais(){
        
    }

    public function inserirUsu(){

    }

    public function alterarNome(){

    }

    public function alterarSenha(){

    }

    public function alterarfoto(){

    }
}