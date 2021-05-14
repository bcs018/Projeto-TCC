<?php
namespace src\controllers\sitePrincipal;

use \core\Controller;
use \src\models\sitePrincipal\Painel;
use \src\models\sitePrincipal\Assinatura;


class PainelController extends Controller {

    public function index(){
        if(!isset($_SESSION['log_admin'])){
            header("Location: /admin-bwcommerce");
            exit;
        }

        $this->render('sitePrincipal/painel_adm/principal');

    }

    public function alterarDadosPessoaisView(){
        if(!isset($_SESSION['log_admin'])){
            header("Location: /admin-bwcommerce");
            exit;
        }

        $this->render('sitePrincipal/painel_adm/alterarDadosPessoais', ['titleView'=>'Alterar dados pessoais']);
    }

    public function novoPlano(){
        if(!isset($_SESSION['log_admin'])){
            header("Location: /admin-bwcommerce");
            exit;
        }

        $this->render('sitePrincipal/painel_adm/novoPlano', ['titleView'=>'Criar novo plano']);
    }

    public function alterarDadosPessoais(){
        $nome      = addslashes($_POST['nome']);
        $senha_atu = addslashes($_POST['senha_atu']);
        $senha_nov = addslashes($_POST['senha_nov']);
        $senha_rep = addslashes($_POST['senha_rep']);

        if(isset($_FILES['photo'])){
            $foto = $_FILES['photo'];
        }else{
            $foto = null;
        }

        $painel = new Painel;
        $ret = $painel->alterarUsuario($_SESSION['log_admin']['id'], $nome, $senha_atu, $senha_nov, $senha_rep, $foto);

        echo json_encode($ret);
        exit;
    }

    public function inserirUsu(){

    }

    public function alterarNome(){

    }

    public function alterarSenha(){

    }

    public function alterarfoto(){

    }
}