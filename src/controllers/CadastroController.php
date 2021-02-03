<?php
namespace src\controllers;

use \core\Controller;
use \src\models\Cadastro;

class CadastroController extends Controller {

    public function index() {
        $cadastro = new Cadastro;
        $estados = $cadastro->lista_estados();

        $this->render('sitePrincipal/crialoja', ['estados'=>$estados]);
    }

}