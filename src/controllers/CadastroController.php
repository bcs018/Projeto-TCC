<?php
namespace src\controllers;

use \core\Controller;
use \src\models\Home;

class CadastroController extends Controller {

    public function index() {
        $this->render('sitePrincipal/crialoja');
    }

}