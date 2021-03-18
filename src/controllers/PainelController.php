<?php
namespace src\controllers;

use \core\Controller;
use \src\models\Painel;
use \src\models\Assinatura;


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

        $this->render('sitePrincipal/painel_adm/alterarDadosPessoais', ['title'=>'Alterar dados pessoais']);
    }

    public function alterarDadosPessoais(){
        $nome      = addslashes($_POST['nome']);
        $senha_atu = addslashes($_POST['senha']);
        $senha_nov = addslashes($_POST['senha_nov']);
        $senha_rep = addslashes($_POST['senha_rep']);
        $foto      = addslashes($_FILES['foto']);

        if($nome == '' || empty($nome)){
            echo json_encode(['error'=>1]);
            exit;
        }

        $painel = new Painel;
        $painel->alterarUsuario($_SESSION['log_admin']['id'], $nome, $senha_atu, $senha_nov, $senha_rep, $foto);

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