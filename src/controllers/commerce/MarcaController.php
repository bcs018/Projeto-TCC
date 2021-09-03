<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Marca;
use \src\controllers\commerce\AdminController;

class MarcaController extends Controller {
    /**
     * --- MARCAS
     */

     // Lista todas as marcas
     public function conMarca(){
        $dadosEco = AdminController::listaDadosEcommerce();

        $mar = new Marca;
        $dados = $mar->listaMarcas($_SESSION['sub_dom']);

        $this->render('commerce/painel_adm/con_marca', ['dados'=>$dados, 'control_rec'=>$dadosEco['tp_recebimento']]);
    }

    // View para cadastrar marca
    public function cadMarca(){
        $dadosEco = AdminController::listaDadosEcommerce();
    
        $this->render('commerce/painel_adm/cad_marca',['control_rec'=>$dadosEco['tp_recebimento']]);
    }

    // View para editar marca
    public function ediMarca($id){
        $dadosEco = AdminController::listaDadosEcommerce();
        
        $edit = new Marca;
        $dados = $edit->listaMarca(addslashes($id['id']));

        if (!$dados){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Marca não encontrada!
                                    </div>';
            header("Location: /admin/painel/marcas");
            exit;
        }

        $this->render('commerce/painel_adm/edi_marca', ['dados'=>$dados, 'control_rec'=>$dadosEco['tp_recebimento']]);

    }

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

        $mar = new Marca;
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

        $mar = new Marca;
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

        $edit = new Marca;
        $edit->ediMarca($id, $nomeMarca);

        header("Location: /admin/painel/marcas");
        exit;
    }

    public function excImgMarcaAction($idMarca){
        $mar = new Marca;
        $mar->excImgMarcaAction($idMarca['id']);
        
        header("Location: /admin/painel/editar-marca/".$idMarca['id']);
        exit;
    }
}