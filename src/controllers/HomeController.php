<?php
namespace src\controllers;

use \core\Controller;
use \src\models\Plano;

class HomeController extends Controller {

    public function index() {   
        $plano = new Plano;
        $planos = $plano->listarPlano();
   
        $this->render('sitePrincipal/home',  ['planos'=>$planos]);
    }

    public function sobre() {
        $this->render('sobre');
    }

    public function sobreP($args) {
        print_r($args);
    }

}