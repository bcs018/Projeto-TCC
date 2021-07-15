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
        $dados = $this->listaDadosEcommerce();
        $est = new Admin;
        $estados = $est->lista_estados();

        $this->render('commerce/painel_adm/edi_dados_pessoais', ['dados'=>$dados, 'estados'=>$estados]);
    }

    public function ediDadosPessoaisAction(){
        $nome        = addslashes($_POST['nome']);
        $sobrenome   = addslashes($_POST['sobrenome']);
        $celular     = addslashes($_POST['celular']);
        $cep         = addslashes($_POST['cep']);
        $rua         = addslashes($_POST['rua']);
        $bairro      = addslashes($_POST['bairro']);
        $numero      = addslashes($_POST['numero']);
        $cidade      = addslashes($_POST['cidade']);
        $estado      = addslashes($_POST['estado']);
        $complemento = addslashes($_POST['complemento']);
        $senha       = addslashes($_POST['altSenha']);
        $senhaRep    = addslashes($_POST['altSenhaRep']);
        $idUsu       = addslashes($_POST['id']);

        $cep = explode('-', $cep);
        $cep = $cep[0].$cep[1];

        $edi = new Admin;
        $edi->ediDadosPessoaisAction($idUsu, $nome, $sobrenome, $celular, $cep, $rua, $bairro, $numero, $cidade, $estado, $complemento, $senha, $senhaRep);

        header("Location: /admin/painel/alterar-dados-pessoais");

        exit;

        // echo $nome       .'<br>';
        // echo $sobrenome  .'<br>';
        // echo $celular    .'<br>';
        // echo $cep        .'<br>';
        // echo $rua        .'<br>';
        // echo $bairro     .'<br>';
        // echo $numero     .'<br>';
        // echo $cidade     .'<br>';
        // echo $estado     .'<br>';
        // echo $complemento.'<br>';
        // echo $senha      .'<br>';
        // echo $senhaRep   .'<br>';


    }

    public function consultarCep(){
        $cep = addslashes($_POST['cep']);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://viacep.com.br/ws/'.$cep.'/json/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $dados = curl_exec($ch);

        curl_close($ch);

        echo $dados;

        exit;
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