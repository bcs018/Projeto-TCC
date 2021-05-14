<?php
namespace src\controllers\sitePrincipal;

use \core\Controller;
use \src\models\sitePrincipal\Login;

class LoginController extends Controller {

    public function index(){
        $this->render('sitePrincipal/login', ['tpLogin'=>'Informe seu CPF', 'user'=>'user', 'tpText'=>'number']);
    }

    public function admin(){
        $this->render('sitePrincipal\login', ['tpLogin'=>'Informe seu login', 'user'=>'admin', 'tpText'=>'text']);    
    }

    public function validarUser(){
        $login = new Login;

        if($login->validarLoginUser($_POST['pass'], $_POST['user'])){            
            header("Location: /info-cadastro");
            exit;
        }

        $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">CPF e/ou senha incorretos!</div>';
        header("Location: /login");
        exit;
    }

    public function validarAdmin(){
        $login = new Login;

        if($login->validarLoginAdmin($_POST['pass'], $_POST['user'])){
            header("Location: /painel/admin");
            exit;
        }

        $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">Usuário e/ou senha incorretos!</div>';
        header("Location: /login");
        exit;
    }

    public function sair(){
        unset($_SESSION['log']);
        header("Location: /login");
    }

    public function sairAdmin(){
        unset( $_SESSION['log_admin']);
        header("Location: /admin-bwcommerce");
    }
}