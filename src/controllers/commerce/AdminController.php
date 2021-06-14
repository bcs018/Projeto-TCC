<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Admin;

class AdminController extends Controller {

    /**
     * Rotas de GET
     */

    public function index() {
        $this->render('commerce/lay01/login_adm');
    }

    public function painel() {
        $login = new Admin;
        $dados = $login->listaDados($_SESSION['sub_dom']);

        if($dados == false){
            header("Location: /admin");
        }

        $_SESSION['log_admin_c']['nome'] = $dados['nome'];

        $this->render('commerce/painel_adm/principal', ['dados'=>$dados]);
    }

    public function conMarca(){
        $login = new Admin;
        $dados = $login->listaDados($_SESSION['sub_dom']);

        if($dados == false){
            header("Location: /admin");
        }

        $_SESSION['log_admin_c']['nome'] = $dados['nome'];

        $this->render('commerce/painel_adm/con_marca', ['dados'=>$dados]);
    }

    public function cadMarca(){
        $login = new Admin;
        $dados = $login->listaDados($_SESSION['sub_dom']);
    
        if($dados == false){
            header("Location: /admin");
        }

        $this->render('commerce/painel_adm/cad_marca', ['dados'=>$dados]);
    }

    public function conCategoria(){
        $login = new Admin;
        $dados = $login->listaDados($_SESSION['sub_dom']);
    
        if($dados == false){
            header("Location: /admin");
        }

        $this->render('commerce/painel_adm/con_categoria', ['dados'=>$dados]);

    }

    public function cadCategoria(){
        $login = new Admin;
        $dados = $login->listaDados($_SESSION['sub_dom']);
    
        if($dados == false){
            header("Location: /admin");
        }

        $this->render('commerce/painel_adm/cad_categoria', ['dados'=>$dados]);

    }

    public function conProduto(){
        $login = new Admin;
        $dados = $login->listaDados($_SESSION['sub_dom']);
    
        if($dados == false){
            header("Location: /admin");
        }

        $this->render('commerce/painel_adm/con_produto', ['dados'=>$dados]);

    }

    public function cadProduto(){
        $login = new Admin;
        $dados = $login->listaDados($_SESSION['sub_dom']);
    
        if($dados == false){
            header("Location: /admin");
        }

        $this->render('commerce/painel_adm/cad_produto', ['dados'=>$dados]);

    }

    /**
     * Rotas de POST
     */

    public function cadProdutoActionFirst(){
        $nomeProd = addslashes($_POST['nomeProd']);
        $descProd = addslashes($_POST['descProd']);
        $estoque  = addslashes($_POST['estoque']);
        $preco    = addslashes($_POST['preco']);
        $precoAnt = addslashes($_POST['precoAnt']);
        $promo    = addslashes($_POST['promo']);
        $novo     = addslashes($_POST['novo']);

        $cad = new Admin;
        $cad->cadProdutoActionFirst($nomeProd, $descProd, $estoque, $preco, $precoAnt, $promo, $novo);


            header("Location: /admin/painel/cadastrar-produtos");

            exit;
        }

        if($_POST[''])


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