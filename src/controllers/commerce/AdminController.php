<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Admin;

class AdminController extends Controller {

    public function index() {
        $this->render('commerce/lay01/login_adm');
    }

    // -- Função para pegar informações do ecommerce de cada cliente
    public static function listaDadosEcommerce(){
        $login = new Admin;
        $dados = $login->listaDados($_SESSION['sub_dom']);

        if($dados == false){
            header("Location: /admin");
            exit;
        }

        $_SESSION['log_admin_c']['nome'] = $dados['nome'];

        return $dados;
    }

    // -- Pagina principal do painel de controle
    public function painel() {
        $dados = $this->listaDadosEcommerce();

        $this->render('commerce/painel_adm/principal'/*, ['dados'=>$dados]*/);
    }

    public function ediDadosPessoais(){
        $this->listaDadosEcommerce();

        $this->render('commerce/painel_adm/edi_dados_pessoais'/*, ['dados'=>$dados]*/);

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

    public function sair(){
        unset($_SESSION['log_admin_c']);
        header("Location: /admin");
    }
}