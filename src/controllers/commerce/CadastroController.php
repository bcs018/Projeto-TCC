<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Admin;
use \src\models\commerce\Produto;
use \src\models\commerce\Info;
use \src\models\commerce\Cadastro;

class CadastroController extends Controller {

    public function index() {
        $info = new Info;

        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        $this->render('commerce/lay01/cadastro',['dados'=>$dados]);
    }

    public function cadUsuarioAction(){
        $nome      = addslashes($_POST['nome']);
        $sobrenome = addslashes($_POST['sobrenome']);
        $cpf       = addslashes($_POST['cpf']);
        $email     = addslashes($_POST['email']);
        $cel       = addslashes($_POST['cel']);
        $login     = addslashes($_POST['login']);
        $senha     = addslashes($_POST['altSenha']);
        $senhaRep  = addslashes($_POST['altSenhaRep']);

        $cpf = str_replace('.','',$cpf);
        $cpf = str_replace('-','',$cpf);
        $cpf = intval($cpf);

        $cad = new Cadastro;

        $cad->cadUsuarioAction($nome, $sobrenome, $cpf, $email, $senha, $senhaRep, $cel, $login);
        
        header("Location: /cadastrar");
        exit;
    }
}