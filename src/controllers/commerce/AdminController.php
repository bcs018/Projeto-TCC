<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Admin;

class AdminController extends Controller {

                        /**
                         * ---------------- Rotas de GET ----------------
                         */

    public function index() {
        $this->render('commerce/lay01/login_adm');
    }

    // -- Função para pegar informações do ecommerce de cada cliente
    public function listaDadosEcommerce(){
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

    /**
     * --- MARCAS
     */

     // Lista todas as marcas
    public function conMarca(){
        $this->listaDadosEcommerce();

        $mar = new Admin;
        $dados = $mar->listaMarcas($_SESSION['sub_dom']);

        $this->render('commerce/painel_adm/con_marca', ['dados'=>$dados]);
    }

    // View para cadastrar marca
    public function cadMarca(){
        $this->listaDadosEcommerce();
    
        $this->render('commerce/painel_adm/cad_marca'/*, ['dados'=>$dados]*/);
    }

    // View para editar marca
    public function ediMarca($id){
        $this->listaDadosEcommerce();
        
        $edit = new Admin;
        $dados = $edit->listaMarca(addslashes($id['id']));

        if (!$dados){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Marca não encontrada!
                                    </div>';
            header("Location: /admin/painel/marcas");
            exit;
        }

        $this->render('commerce/painel_adm/edi_marca', ['dados'=>$dados]);

    }

    /**
     * --- CATEGORIA
     */

    // View para consulta de categorias 
    public function conCategoria(){
        $this->listaDadosEcommerce();

        $this->render('commerce/painel_adm/con_categoria'/*, ['dados'=>$dados]*/);

    }

    // View para cadastro de categorias
    public function cadCategoria(){
        $this->listaDadosEcommerce();

        $this->render('commerce/painel_adm/cad_categoria'/*, ['dados'=>$dados]*/);

    }

    /**
     * --- PRODUTO
     */

    // View para consulta de produtos
    public function conProduto(){
        $this->listaDadosEcommerce();

        $this->render('commerce/painel_adm/con_produto'/*, ['dados'=>$dados]*/);

    }

    // View para cadastro de produtos
    public function cadProduto(){
        $this->listaDadosEcommerce();

        $this->render('commerce/painel_adm/cad_produto'/*, ['dados'=>$dados]*/);

    }

                        /**
                         * ---------------- Rotas de POST ----------------
                         */

     /**
      * --- CATEGORIAS
      */

     // Cadastro de categoria
     public function cadCategoriaAction(){
        if(!isset($_POST['nomeCategoria']) || empty($_POST['nomeCategoria']) || !isset($_POST['subCategoria']) ){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Categoria não preenchida, preencha o campo e tente novamente!
                                    </div>';
            header("Location: /admin/painel/cadastrar-categorias");
            exit;
        }

        $nomeCategoria = addslashes($_POST['nomeCategoria']);
        $subCategoria  = addslashes($_POST['subCategoria']);

        $cadCat = new Admin;
        $dados = $cadCat->cadCategoria($nomeCategoria, $subCategoria);

        header("Location: /admin/painel/cadastrar-categorias");

        exit;
     }


    /**
    * --- PRODUTOS
    */

    // Cadastro de produtos
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


        //header("Location: /admin/painel/cadastrar-produtos");
        exit;
    }

    /**
     * --- MARCAS
     */

    // Cadastro de marca
    public function cadMarcaAction(){
        if(!isset($_POST['nomeMarca']) || empty($_POST['nomeMarca'])){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Marca não preenchida, preencha o campo e tente novamente!
                                    </div>';
            header("Location: /admin/painel/cadastrar-marcas");
            exit;
        }

        $nomeMarca = addslashes($_POST['nomeMarca']);

        $mar = new Admin;
        $mar->cadMarca($nomeMarca);

        header("Location: /admin/painel/cadastrar-marcas");
    }

    // Excluir marca
    public function excMarcaAction($id){
        if(!isset($id) || empty($id)){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Erro ao excluir marca, atualize a página e tente novamente!
                                    </div>';
            header("Location: /admin/painel/marcas");
            exit;
        }

        $mar = new Admin;
        $mar->excMarca(addslashes($id['id']));

        header("Location: /admin/painel/marcas");
    }

    // Editar marca
    public function ediMarcaAction(){
        $nomeMarca = addslashes($_POST['nomeMarca']);
        $id        = addslashes($_POST['id']);
        
        if(!isset($id) || empty($id) || !isset($nomeMarca) || empty($nomeMarca)){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Marca não preenchido, atualize a página e tente novamente!
                                    </div>';
            header("Location: /admin/painel/editar-marca/".$id);
            exit;
        }

        $edit = new Admin;
        $edit->ediMarca($id, $nomeMarca);

        header("Location: /admin/painel/marcas");
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