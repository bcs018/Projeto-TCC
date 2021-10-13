<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\AdminC;

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

        return $dados;
    } 

    // -- Pagina principal do painel de controle
    public function painel() {
        $dados = $this->listaDadosEcommerce();
        $adm = new AdminC;

        $qtdCompra = $adm->listaQtdProdCompra();

        $this->render('commerce/painel_cli/principal', ['qtdCompra'=>$qtdCompra['qtd']] /*, ['dados'=>$dados]*/);
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
        
        $con = new AdminC;

        $contato = $con->listaContato();
    
        $this->render('commerce/painel_cli/contato', ['dados'=>$dados, 'contato'=>$contato]);
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

    public function marcarRecebido(){
        $adm = new AdminC;

        $dados = $this->listaDadosEcommerce();

        $id = addslashes($_POST['id']);

        $adm->marcarRecebido($id);

        echo json_encode(['ret'=>true]);
    }
}