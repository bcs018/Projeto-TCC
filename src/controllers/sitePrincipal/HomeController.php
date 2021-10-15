<?php
namespace src\controllers\sitePrincipal;

use \core\Controller;
use \src\models\sitePrincipal\Plano;
use \src\models\sitePrincipal\Xmlapi;

class HomeController extends Controller {

    public function index() {   
        ini_set('default_charset','UTF-8');

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