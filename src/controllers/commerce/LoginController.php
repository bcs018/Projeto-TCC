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

        //$this->render('commerce/'.$dados['layout'].'/login_cliente', ['control'=>$control]);
        $this->render('commerce/painel_cli/login_cliente', ['control'=>$control]);
    }

    // Login do Empreendedor
    public function login() {
        $info = new Info;
        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        //$this->render('commerce/'.$dados['layout'].'/login_adm');
        $this->render('commerce/painel_adm/login_adm');
    }

    // Login do Empreendedor
    public function loginAction() {
        $log = new Login;
        $info = new Info;
        
        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        if($dados['ativo'] == '0'){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Você não possui mais acesso a plataforma. <br>
                                        regularize seus débitos ou entre em contato com PotLid Commerce!
                                    </div>';
            header("Location: /admin");
            exit;          
        }

        $ret = $log->loginAction($_SESSION['sub_dom'], $_POST['login'], $_POST['pass']);

        if($ret == false){
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

        $info = new Info;
        
        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        if($dados['ativo'] == '0'){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Este site está temporariamente desativado. <br>
                                        Entre em contato com '.$dados['nome_fantasia'].' para melherores explicações!
                                    </div>';
            header("Location: /login");
            exit;          
        }

        $log = new Login;

        $log->loginCAction($login, $senha, $control);
    }

    public function sair(){
        unset($_SESSION['log_admin']);
        unset($_SESSION['credencial']);
        header("Location: /admin");
    }

    public function sairC(){
        unset($_SESSION['log_admin_c']);
        unset($_SESSION['login_cliente_ecommerce']);
        unset($_SESSION['credencial_c']);
        header("Location: /login/c");
    }

}