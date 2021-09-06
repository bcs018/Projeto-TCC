<?php
namespace src\controllers\commerce;

use \core\Controller;
use PagSeguro\Resources\Responsibility\Configuration\File;
use \src\models\commerce\AdminC;
use \src\models\commerce\Produto;
use \src\models\commerce\Marca;
use \src\models\commerce\Info;

/**
 * Controller destinado ao painel de controle dos clientes
 * dos ecommerces
 */

class AdminCController extends Controller {
    public static function listaDadosEcommerce(){
        $login = new AdminC;
        $dados = $login->listaDados($_SESSION['sub_dom']);

        if($dados == false){
            header("Location: /login/c");
            exit;
        }

        $_SESSION['log_admin_c']['nome'] = $dados['nome_usu_ue'];

        return $dados;
    } 

    // -- Pagina principal do painel de controle
    public function painel() {
        $dados = $this->listaDadosEcommerce();

        $this->render('commerce/painel_cli/principal'/*, ['dados'=>$dados]*/);
    }

    public function ediDadosPessoais(){
        $dados = $this->listaDadosEcommerce();
    
        $this->render('commerce/painel_cli/edi_dados_pessoais', ['dados'=>$dados]);
    }

    public function ediDadosPessoaisAction(){
        $nome      = addslashes($_POST['nome']);
        $sobrenome = addslashes($_POST['sobrenome']);
        $celular   = addslashes($_POST['celular']);
        $senha     = addslashes($_POST['altSenha']);
        $senhaRep  = addslashes($_POST['altSenhaRep']);

        $adm = new AdminC;

        if(!empty($senhaRep) && !empty($senha)){
           $adm->ediDadosPessoaisAction($nome, $sobrenome, $celular, $senha, $senhaRep);
        }else{
            $adm->ediDadosPessoaisAction($nome, $sobrenome, $celular);
        }

        header("Location: /cliente/painel/alterar-dados-pessoais");
        exit;

    }

    public function contato(){
        $dados = $this->listaDadosEcommerce();
    
        $this->render('commerce/painel_cli/contato', ['dados'=>$dados]);
    }

    public function pedidos(){
        $adm = new AdminC;

        $dados = $this->listaDadosEcommerce();

        $compras = $adm->listaComprasUsu();

        $this->render('commerce/painel_cli/pedidos', ['dados'=>$dados, 'compras'=>$compras]);
    }

    public function pedido($id){
        $adm = new AdminC;

        $dados = $this->listaDadosEcommerce();

        $pedido = $adm->listaCompraUsu($id['id']);

        $this->render('commerce/painel_cli/pedido', ['dados'=>$dados, 'pedido'=>$pedido]);
    }
}