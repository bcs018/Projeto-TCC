<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Admin;
use \src\models\commerce\Produto;
use \src\models\commerce\Info;
use \src\models\commerce\Cadastro;
use \src\models\commerce\Login;

class LoginController extends Controller {
    // Login do Cliente do ecommerce
    public function loginC($control=[]){
        //print_r($control);exit;

        $this->render('commerce/lay01/login_cliente', ['control'=>$control]);
    }

    // Login do Empreendedor
    public function login() {
        $this->render('commerce/lay01/login_adm');
    }

    // Login do Empreendedor
    public function loginAction() {
        $log = new Login;
        $dados = $log->loginAction($_SESSION['sub_dom'], $_POST['login'], $_POST['pass']);

        if($dados == false){
            header("Location: /admin");
            exit;
        }

        header("Location: /admin/painel");

        exit;

    }

    // Login do cliente do ecommerce
    public function loginCAction(){
        $login   = addslashes($_POST['login']);
        $senha   = addslashes($_POST['senha']);
        if($_POST['control'] == ''){
            $control = [];
        }else{
            $control['control'] = addslashes($_POST['control']);
        }

        $log = new Login;

        $log->loginCAction($login, $senha, $control);
    }

    public function sair(){
        unset($_SESSION['log_admin_c']);
        header("Location: /admin");
    }

}