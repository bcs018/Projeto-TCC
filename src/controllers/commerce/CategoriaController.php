<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Categoria;
use \src\controllers\commerce\AdminController;

class CategoriaController extends Controller {
    /**
     * --- CATEGORIA
     */

    // View para consulta de categorias 
    public function conCategoria(){
        AdminController::listaDadosEcommerce();
        $cate = new Categoria;

        $this->render('commerce/painel_adm/con_categoria', ['dados'=>$cate->listaCategoriasOrganizadas()]);

    }

    // View para cadastro de categorias
    public function cadCategoria(){
        AdminController::listaDadosEcommerce();

        $cate = new Categoria;

        $this->render('commerce/painel_adm/cad_categoria', ['catOrga'=>$cate->listaCategoriasOrganizadas(), 'cat'=>$cate->listaCategorias()]);

    }

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

        $cadCat = new Categoria;
        $dados = $cadCat->cadCategoria($nomeCategoria, $subCategoria);

        header("Location: /admin/painel/cadastrar-categorias");

        exit;
     }
}