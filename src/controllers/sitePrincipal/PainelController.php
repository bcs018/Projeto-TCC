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

        $pan = new Painel;

        $this->render('sitePrincipal/painel_adm/principal', ['qtd'=>$pan->qtdClientes(), 'qtdHj'=>$pan->qtdClientesHoje()]);

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

    public function clientes(){
        if(!isset($_SESSION['log_admin'])){
            header("Location: /admin-bwcommerce");
            exit;
        }

        $painel = new Painel;

        $this->render('sitePrincipal/painel_adm/clientes', ['titleView'=>'Clientes','clientes'=>$painel->listaClientes()]);
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
            header("Location: /admin-bwcommerce");
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
            header("Location: /admin-bwcommerce");
            exit;
        }

        $painel = new Painel;

        $rel = $painel->relatorioVendas('0000-00-00', date('Y-m-d'));

        $this->render('sitePrincipal/painel_adm/relVendas', ['rel'=>$rel]);

    }

    public function alterarNome(){

    }

    public function alterarSenha(){

    }

    public function alterarfoto(){

    }
}