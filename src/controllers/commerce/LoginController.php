<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Info;
use \src\models\commerce\Login;

class LoginController extends Controller {
    // Login do Cliente do ecommerce
    public function loginC($control=[]){
        $info = new Info;
        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        $this->render('commerce/'.$dados['layout'].'/login_cliente', ['control'=>$control]);
    }

    // Login do Empreendedor
    public function login() {
        $info = new Info;
        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        $this->render('commerce/'.$dados['layout'].'/login_adm');
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

    public function sairC(){
        unset($_SESSION['log_admin_c']);
        unset($_SESSION['login_cliente_ecommerce']);
        header("Location: /login/c");
    }

}