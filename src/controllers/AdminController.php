<?php
namespace src\controllers;

use \core\Controller;
use Exception;
use \src\models\Plano;
use \src\models\Assinatura;

class AdminController extends Controller {

    public function index(){
        $this->render('sitePrincipal\login', ['tpLogin'=>'Informe seu login']);    
    }

    public function validarLogin(){
        
    }

}