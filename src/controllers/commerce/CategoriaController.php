<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Categoria;
use \src\models\commerce\Notificacao;
use \src\controllers\commerce\AdminController;

class CategoriaController extends Controller {
    /**
     * --- CATEGORIA
     */

    // View para consulta de categorias 
    public function conCategoria(){
        $dadosEco = AdminController::listaDadosEcommerce();
        $cate = new Categoria;
        $noti  = new Notificacao;

        $qtdNotifi = $noti->qtdNotificacao();

        $this->render('commerce/painel_adm/con_categoria', ['qtdNoti'=>$qtdNotifi,'control_rec'=>$dadosEco['tp_recebimento'], 'dados'=>$cate->listaCategoriasOrganizadas()]);

    }

    // View para cadastro de categorias
    public function cadCategoria(){
        $dadosEco = AdminController::listaDadosEcommerce();
        $noti  = new Notificacao;

        $qtdNotifi = $noti->qtdNotificacao();

        $cate = new Categoria;

        $this->render('commerce/painel_adm/cad_categoria', ['qtdNoti'=>$qtdNotifi,'control_rec'=>$dadosEco['tp_recebimento'],'catOrga'=>$cate->listaCategoriasOrganizadas(), 'cat'=>$cate->listaCategorias()]);

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

     public function ediCategoria($id){
        $dadosEco = AdminController::listaDadosEcommerce();
        
        $edit = new Categoria;
        $categoria     = $edit->listaCategoria(addslashes($id['id']));
        $categoriasOrg = $edit->listaCategoriasOrganizadas();
        $categorias    = $edit->listaCategorias();
        $noti  = new Notificacao;

        $qtdNotifi = $noti->qtdNotificacao();

        if (!$categoria){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Categoria não encontrada!
                                    </div>';
            header("Location: /admin/painel/categorias");
            exit;
        }

        $this->render('commerce/painel_adm/edi_categoria', ['categorias'=>$categorias,'categoriasOrg'=>$categoriasOrg,'categoria'=>$categoria,'qtdNoti'=>$qtdNotifi,'control_rec'=>$dadosEco['tp_recebimento']]);
     }

     public function excCategoriaAction($id){
        if(!isset($id) || empty($id)){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Erro ao excluir categoria, atualize a página e tente novamente!
                                    </div>';
            header("Location: /admin/painel/categoria");
            exit;
        }

        $exc = new Categoria;

        if(!$exc->listaCategoria(addslashes($id['id']))){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Categoria não encontrada!
                                    </div>';
            header("Location: /admin/painel/categorias");
            exit;
        }

        $exc->excCategoria(addslashes($id['id']));

        header("Location: /admin/painel/categorias");
     }

     public function ediCategoriaAction(){
        $nomeCat = addslashes($_POST['nomeCategoria']);
        $idCat   = addslashes($_POST['id']);
        $sub = addslashes($_POST['subCategoria']);

        $edit = new Categoria;
        $edit->ediCategoria($idCat, $nomeCat, $sub);

        header("Location: /admin/painel/categorias");              

     }
}