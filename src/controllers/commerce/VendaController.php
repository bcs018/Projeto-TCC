<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Compra;
use \src\models\commerce\Info;
use \src\models\commerce\Venda;
use src\models\commerce\Carrinho;
use src\models\commerce\Notificacao;
use src\models\commerce\Produto;

class VendaController extends Controller {
    public function vendasPendendes(){
        $dados = AdminController::listaDadosEcommerce();

        $inf   = new Info;
        $ven   = new Venda;

        $dados     = $inf->pegaDadosCommerce($_SESSION['sub_dom']);
        $vendas    = $ven->listaVendasPendentes();

        $this->render('commerce/painel_adm/vendas_pendentes', ['vendas'=>$vendas, 'control_rec'=>$dados['tp_recebimento'],'dados'=>$dados]);
    }

    public function vendaPendente($id){
        $dados = AdminController::listaDadosEcommerce();

        $inf   = new Info;
        $ven   = new Venda;
        $dados     = $inf->pegaDadosCommerce($_SESSION['sub_dom']);
        $venda     = $ven->listaVendaPendente($id['id']);

        if($venda == 0){
            header("Location: /admin/painel/vendas-pendentes");
            exit;
        }

        $this->render('commerce/painel_adm/venda_pendente', ['venda'=>$venda, 'control_rec'=>$dados['tp_recebimento'],'dados'=>$dados]);
    }

    public function marcarEnviado(){
        $id = addslashes($_POST['id']);

        $ven = new Venda;
        $com = new Compra;
        $noti  = new Notificacao;

        $ven->marcarEnviado($id, '1');
        $id_usu = $com->listaCompraNotify($id);
        $noti->gravaNotificacao($_SESSION['id_sub_dom'], 'Sua compra foi despachada pelo vendedor!', '/cliente/painel/meus-pedidos/'.$id, $id_usu['usuario_id']);

        echo json_encode(['ret'=>true]);
    }

    public function marcarNEnviado(){
        $id = addslashes($_POST['id']);

        $ven = new Venda;

        $ven->marcarEnviado($id, '0');

        echo json_encode(['ret'=>true]);

    }
}