<?php
namespace src\controllers\sitePrincipal;

use \core\Controller;
use src\models\commerce\AdminC;
use src\models\commerce\Notificacao;
use \src\models\sitePrincipal\Painel;
use \src\models\sitePrincipal\Assinatura;


class PainelController extends Controller {

    public function index(){
        if(!isset($_SESSION['log_admin']['id'])){
            header("Location: /admin-potlid");
            exit;
        }

        $pan = new Painel;

        $this->render('sitePrincipal/painel_adm/principal', ['qtd'=>$pan->qtdClientes(), 'qtdHj'=>$pan->qtdClientesHoje()]);

    }

    public function alterarDadosPessoaisView(){
        if(!isset($_SESSION['log_admin'])){
            header("Location: /admin-potlid");
            exit;
        }

        $this->render('sitePrincipal/painel_adm/alterarDadosPessoais', ['titleView'=>'Alterar dados pessoais']);
    }

    public function novoPlano(){
        if(!isset($_SESSION['log_admin'])){
            header("Location: /admin-potlid");
            exit;
        }

        $this->render('sitePrincipal/painel_adm/novoPlano', ['titleView'=>'Criar novo plano']);
    }

    public function clientes(){
        if(!isset($_SESSION['log_admin'])){
            header("Location: /admin-potlid");
            exit;
        }

        $painel = new Painel;

        $this->render('sitePrincipal/painel_adm/clientes', ['titleView'=>'Clientes','clientes'=>$painel->listaClientes()]);
    }

    public function vendasPagar(){
        if(!isset($_SESSION['log_admin'])){
            header("Location: /admin-potlid");
            exit;
        }

        $ven = new Painel;

        $vendas = $ven->vendasPagar();

        $this->render('sitePrincipal/painel_adm/vendas_pagar', ['titleView'=>'Vendas à pagar','vendas'=>$vendas]);
    }

    public function vendaPagar($id){
        if(!isset($_SESSION['log_admin'])){
            header("Location: /admin-potlid");
            exit;
        }

        $ven = new Painel;

        $venda = $ven->vendaPagar($id['id']);

        // Valor do juros p/ subtrair no total da venda a receber
        if($venda['tipo_pagamento'] == 'cartao'){
            $juros_receb = ($venda['total_compra']*0.0499)+0.29;
        }else{
            $juros_receb = 2.99;
        }
        
        $this->render('sitePrincipal/painel_adm/venda_pagar', ['juros'=>$juros_receb, 'venda'=>$venda]);
    }

    public function transferirVenda(){
        $id = addslashes($_POST['id']);
        $tran = addslashes($_POST['tran']);
        $valor = (isset($_POST['valor']))?$_POST['valor']:'';
        
        $ven = new Painel;
        $not = new Notificacao;

        $ven->marcarTransferido($id, $tran);

        if(isset($_POST['valor'])){
            $not->gravaNotificacao(intval($_POST['idEco']), 'Você recebeu o valor de '.$_POST['valor'].' referente a venda '.$id.'!', '/admin/painel/venda/'.$id);
        }

        echo json_encode(['ret'=>true]);
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

    public function ativarUsu($id){
        $painel = new Painel;

        if($painel->altAtivo($id['id'], '1')){
            echo json_encode(['ret'=>true]);
            exit;
        }
        
        echo json_encode(['ret'=>false]);
        exit;
    }

    public function inativarUsu($id){
        $painel = new Painel;

        if($painel->altAtivo($id['id'], '0')){
            echo json_encode(['ret'=>true]);
            exit;
        }
        
        echo json_encode(['ret'=>false]);
        exit;
    }

    public function relVendas(){
        if(!isset($_SESSION['log_admin'])){
            header("Location: /admin-potlid");
            exit;
        }

        $painel = new Painel;

        if(isset($_POST['data_ini']) && !empty($_POST['data_ini']) && isset($_POST['data_fim']) && !empty($_POST['data_fim'])){
            $rel = $painel->relatorioVendas($_POST['data_ini'], $_POST['data_fim']);

            $this->render('sitePrincipal/painel_adm/relVendas', ['rel'=>$rel, 'ini'=>$_POST['data_ini'], 'fim'=>$_POST['data_fim']]);
            exit;
        }


        $rel = $painel->relatorioVendas('2000-01-01', date('Y-m-d'));

        $this->render('sitePrincipal/painel_adm/relVendas', ['rel'=>$rel, 'ini'=>'2000-01-01', 'fim'=>date('Y-m-d')]);

    }

    public function relVendasAction(){
        if(!isset($_SESSION['log_admin'])){
            header("Location: /admin-potlid");
            exit;
        }

        $painel = new Painel;

        $rel = $painel->relatorioVendas('0000-00-00', date('Y-m-d'));

        $this->render('sitePrincipal/painel_adm/relVendas', ['rel'=>$rel]);

    }

    public function addUsuario(){
        if(!isset($_SESSION['log_admin'])){
            header("Location: /admin-potlid");
            exit;
        }

        $this->render('sitePrincipal/painel_adm/add_usuario');
    }

    public function addUsuarioAction(){
        if(!empty($_POST['nome']) && !empty($_POST['login']) && !empty($_POST['senha']) && !empty($_POST['senhaRep'])){
            if($_POST['senha'] != $_POST['senhaRep']){
                $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                            Senhas não batem!
                                        </div>';
                header("Location: /painel/add-usuario");
                exit;
            }

            $adm = new Painel;

            $adm->addUsuario(addslashes($_POST['nome']), addslashes($_POST['login']), addslashes($_POST['senha']));

            header("Location: /painel/add-usuario");
            exit;
        }

        $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                    Existem campos obrigatórios não preenchidos!
                                </div>';
                                
        header("Location: /painel/add-usuario");
        exit;
                    
    }

    public function alterarSenha(){

    }

    public function alterarfoto(){

    }
}