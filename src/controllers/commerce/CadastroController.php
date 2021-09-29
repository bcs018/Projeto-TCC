<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Info;
use \src\models\commerce\Cadastro;
use \src\models\commerce\Carrinho;

class CadastroController extends Controller {

    public function index() {
        $info = new Info;
        $carr = new Carrinho;

        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        if($dados['ativo'] == '0'){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        <center><b>Este site está temporariamente desativado para as operações. <br>
                                        Entre em contato com '.$dados['nome_fantasia'].' para melherores explicações!</center></b>
                                    </div>';

            header("Location: /");
            exit;
        }

        if(isset($_SESSION['carrinho'])){
            $carrinho = $carr->listaItens($_SESSION['carrinho']);
        }else{
            $carrinho = false;
        }

        $this->render('commerce/'.$dados['layout'].'/cadastro',['dados'=>$dados, 'control_rec'=>$dados['tp_recebimento'], 'carrinho'=>$carrinho]);
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