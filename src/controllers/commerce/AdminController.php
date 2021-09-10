<?php
namespace src\controllers\commerce;

use \core\Controller;
use PagSeguro\Resources\Responsibility\Configuration\File;
use \src\models\commerce\Admin;
use \src\models\commerce\Produto;
use \src\models\commerce\Marca;
use \src\models\commerce\Info;

class AdminController extends Controller {

    // public function index() {
    //     $this->render('commerce/lay01/login_adm');
    // }

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

        $this->render('commerce/painel_adm/principal', ['control_rec'=>$dados['tp_recebimento'],'dados'=>$dados]);
    }

    public function ediDadosPessoais(){
        $dados = $this->listaDadosEcommerce();
        $est = new Admin;
        $estados = $est->lista_estados();

        $this->render('commerce/painel_adm/edi_dados_pessoais', ['control_rec'=>$dados['tp_recebimento'],'dados'=>$dados, 'estados'=>$estados]);
    }

    public function addNovoUsu(){
        $dados = $this->listaDadosEcommerce();
        $est = new Admin;
        $estados = $est->lista_estados();

        $this->render('commerce/painel_adm/add_usuario', ['control_rec'=>$dados['tp_recebimento'], 'dados'=>$dados, 'estados'=>$estados]);
    }

    public function layout(){
        $dados = AdminController::listaDadosEcommerce();

        $pro = new Produto;
        $mar = new Marca;
        $inf = new Info;

        $dados    = $inf->pegaDadosCommerce($_SESSION['sub_dom']);
        $produtos = $pro->listaProdutos();
        $marcas   = $mar->listaMarcas();

        $this->render('commerce/painel_adm/layout', ['control_rec'=>$dados['tp_recebimento'], 'produtos'=>$produtos, 'marcas'=>$marcas, 'dados'=>$dados]);
    }

    public function cadDadosRecebimento(){
        $dados = AdminController::listaDadosEcommerce();

        $this->render('commerce/painel_adm/dados_recebimento', ['control_rec'=>$dados['tp_recebimento'],'dados'=>$dados]);
    }

    public function cadDadosRecebimentoAction(){
        $tknpagseguro   = addslashes($_POST['tknpagseguro']);
        $emailpagseguro = addslashes($_POST['emailpagseguro']);
        $pkmpago        = addslashes($_POST['pkmpago']);
        $tknmpago       = addslashes($_POST['tknmpago']);

        $admin = new Admin;

        $admin->cadDadosRecebimentoAction($tknpagseguro, $emailpagseguro, $pkmpago, $tknmpago);

        header("Location: /admin/painel/cadastrar-dados-recebimento");
    }

    public function ediLayoutAction(){
        $_SESSION['message'] = '';
        $adm = new Admin;
        $ban = new Produto;
        $mar = new Marca;

        if(isset($_FILES['banner']) && !empty($_FILES['banner']['tmp_name'])){
            $ban->addBannerProdAction($_FILES['banner'], addslashes($_POST['produtoId']));
        }

        if(isset($_FILES['logo']) && !empty($_FILES['logo']['tmp_name'])){
            $adm->addLogoAction($_FILES['logo']);
        }

        if(isset($_FILES['ico']) && !empty($_FILES['ico']['tmp_name'])){
            $adm->addIcoAction($_FILES['ico']);
        }

        if(isset($_FILES['marca']) && !empty($_FILES['marca']['tmp_name'])){
            $mar->addImagemMarcaAction($_FILES['marca'], addslashes($_POST['marcaId']));
        }

        if(isset($_POST['cor']) || !empty($_POST['cor'])){
            $adm->addCorSec(addslashes($_POST['cor']));
        }

        if(isset($_POST['corRodape']) || !empty($_POST['corRodape'])){
            $adm->addCorRodape(addslashes($_POST['corRodape']));
        }

        
        header("Location: /admin/painel/layout");
    }

    public function addNovoUsuAction(){
        $nome        = addslashes($_POST['nome']);
        $sobrenome   = addslashes($_POST['sobrenome']);
        $login       = addslashes($_POST['login']);
        $email       = addslashes($_POST['email']);
        $celular     = addslashes($_POST['celular']);
        $cep         = addslashes($_POST['cep']);
        $rua         = addslashes($_POST['rua']);
        $bairro      = addslashes($_POST['bairro']);
        $numero      = addslashes($_POST['numero']);
        $cidade      = addslashes($_POST['cidade']);
        $estado      = addslashes($_POST['estado']);
        $complemento = addslashes($_POST['complemento']);
        $senha       = addslashes($_POST['senha']);
        $senhaRep    = addslashes($_POST['senhaRep']);

        $usu = new Admin;
        $usu->addNovoUsuAction($nome, $sobrenome, $login, $email, $celular, $cep, $rua, $bairro, $numero, $cidade, $estado, $complemento, $senha, $senhaRep);

        header("Location: /admin/painel/add-novo-usuario");

        exit;
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

    // public function logar() {
    //     $login = new Admin;
    //     $dados = $login->verificarLogin($_SESSION['sub_dom'], $_POST['login'], $_POST['pass']);

    //     if($dados == false){
    //         header("Location: /admin");
    //         exit;
    //     }

    //     header("Location: /admin/painel");

    //     exit;

    // }

    // public function sair(){
    //     unset($_SESSION['log_admin_c']);
    //     header("Location: /admin");
    // }

    
}