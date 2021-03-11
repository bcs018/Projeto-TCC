<?php
namespace src\controllers;

use \core\Controller;
use \src\models\Login;

class LoginController extends Controller {

    public function index(){
        $this->render('sitePrincipal/login', ['tpLogin'=>'Informe seu CPF']);
    }

    public function validar(){
        $login = new Login;

        if($login->validarLogin($_POST['pass'], $_POST['cpf'])){            
            header("Location: /painel");
            exit;
        }

        $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">CPF e/ou senha incorretos!</div>';
        header("Location: /login");
        exit;
    }

    public function sair(){
        unset($_SESSION['log']);
        header("Location: /login");
    }

}