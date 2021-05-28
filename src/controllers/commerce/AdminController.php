<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Admin;

class AdminController extends Controller {

    public function index() {
        $this->render('commerce/lay01/login_adm');
    }

    public function logar() {
        $login = new Admin;
        $dados = $login->verificarLogin($_SESSION['sub_dom'], $_POST['login'], $_POST['pass']);

        if($dados == false){
            header("Location: /admin");
            exit;
        }

        header("Location: /admin/painel");

        exit;

    }

    public function painel() {
        $login = new Admin;
        $dados = $login->listaDados($_SESSION['sub_dom']);

        if($dados == false){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Algo deu errado, faça login novamente!
                                    </div>';
            header("Location: /admin");
        }

        $_SESSION['log_admin_c']['nome'] = $dados['nome'];

        $this->render('commerce/principal_painel', ['dados'=>$dados]);
    }

}