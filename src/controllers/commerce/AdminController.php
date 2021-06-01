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
            header("Location: /admin");
        }

        $_SESSION['log_admin_c']['nome'] = $dados['nome'];

        $this->render('commerce/painel_adm/principal', ['dados'=>$dados]);
    }

    
    public function sair(){
        unset($_SESSION['log_admin_c']);
        header("Location: /admin");
    }

    public function addProduto(){
        $login = new Admin;
        $dados = $login->listaDados($_SESSION['sub_dom']);

        if($dados == false){
            header("Location: /admin");
        }

        $_SESSION['log_admin_c']['nome'] = $dados['nome'];

        $this->render('commerce/painel_adm/add_produto', ['dados'=>$dados]);
    }

}