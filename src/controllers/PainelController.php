<?php
namespace src\controllers;

use \core\Controller;

class PainelController extends Controller {
    public function index(){
        $this->render('sitePrincipal/painel_login');
    }
}