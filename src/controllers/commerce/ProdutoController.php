<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Produto;
use \src\models\commerce\Marca;
use \src\models\commerce\Categoria;
use \src\models\commerce\Notificacao;
use \src\controllers\commerce\AdminController;

class ProdutoController extends Controller {
    /**
     * --- PRODUTO
     */

    // View para consulta de produtos
    public function conProduto(){
        $dadosEco = AdminController::listaDadosEcommerce();

        $prod = new Produto;
        $noti  = new Notificacao;

        $qtdNotifi = $noti->qtdNotificacao();

        $dados = $prod->listaProdutos();

       // echo '<pre>';print_r($dados);exit;

        $this->render('commerce/painel_adm/con_produto', ['qtdNoti'=>$qtdNotifi,'control_rec'=>$dadosEco['tp_recebimento'],'dados'=>$dados]);

    }

    // View para cadastro de produtos
    public function cadProduto(){
        $dadosEco = AdminController::listaDadosEcommerce();

        $mar = new Marca;
        $cat = new Categoria;
        $noti  = new Notificacao;

        $qtdNotifi = $noti->qtdNotificacao();

        $dados['marcas']     = $mar->listaMarcas();
        $dados['categorias'] = $cat->listaCategorias();
        $dados['control_rec'] = $dadosEco['tp_recebimento'];

        $this->render('commerce/painel_adm/cad_produto', $dados,['qtdNoti'=>$qtdNotifi]);

    }

    public function ediProduto($id){
        $dadosEco = AdminController::listaDadosEcommerce();

        $prod = new Produto;
        $cate = new Categoria;
        $marc = new Marca;
        $noti  = new Notificacao;

        $qtdNotifi = $noti->qtdNotificacao();

        $dados['produtos']    = $prod->listaProduto(addslashes($id['id']), 1);
        $dados['categorias']  = $cate->listaCategorias();
        $dados['marcas']      = $marc->listaMarcas(); 
        $dados['control_rec'] = $dadosEco['tp_recebimento']; 

        //echo '<pre>';print_r($dados['produtos']);

        //echo '<pre>';print_r($dados['produtos']);exit;

        if(!$dados){
            $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">
                                        Produto inexistente!
                                    </div>';

            header("Location: /admin/painel/produtos");

            exit;
        }

        $this->render('commerce/painel_adm/edi_produto', $dados,['qtdNoti'=>$qtdNotifi]);
    }

    // Edição de produtos da tela de detalhes
    public function ediProdutoAction(){
        $idProd = addslashes($_POST['id']);

        $pro = new Produto;

        if(isset($_FILES['imagem']) && !empty($_FILES['imagem']['tmp_name'][0])){
            if(!$pro->cadProdutoActionSecond($_FILES, $idProd)){
                header('Location: /admin/painel/editar-produto/'.$idProd);
                exit;
            }

        }

        $nomeProd    = addslashes($_POST['nomeProd']);
        $descProd    = addslashes($_POST['descProd']);
        $categoria   = addslashes($_POST['categoria']);
        $marca       = addslashes($_POST['marca']);
        $estoque     = addslashes($_POST['estoque']);
        $preco       = addslashes($_POST['preco']);
        $precoAnt    = addslashes($_POST['precoAnt']);
        $promo       = addslashes($_POST['promo']);
        $novo        = addslashes($_POST['novo']);
        $peso        = floatval(str_replace(',','.', addslashes($_POST['peso'])));
        $altura      = floatval(str_replace(',','.', addslashes($_POST['altura'])));
        $largura     = floatval(str_replace(',','.', addslashes($_POST['largura'])));
        $comprimento = floatval(str_replace(',','.', addslashes($_POST['comprimento'])));
        $diametro    = floatval(str_replace(',','.', addslashes($_POST['diametro'])));

        $pro->ediProdutoAction($nomeProd, $descProd, $categoria, $marca, $estoque, $preco, $precoAnt, $promo, $novo, $idProd, $peso, $altura, $largura, $comprimento, $diametro);
        
        header('Location: /admin/painel/editar-produto/'.$idProd);

        exit;
    }

    public function conDetalheProduto($id){
        $dadosEco = AdminController::listaDadosEcommerce();

        $prod = new Produto;
        $cate = new Categoria;
        $marc = new Marca;
        $noti  = new Notificacao;

        $qtdNotifi = $noti->qtdNotificacao();

        $dados['produtos']    = $prod->listaProduto(addslashes($id['id']),1);
        $dados['categorias']  = $cate->listaCategorias();
        $dados['marcas']      = $marc->listaMarcas();
        $dados['control_rec'] = $dadosEco['tp_recebimento'];

        //echo '<pre>';print_r($dados['produtos']);exit;

        if(!$dados){
            $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">
                                        Produto inexistente!
                                    </div>';

            header("Location: /admin/painel/produtos");

            exit;
        }

        $this->render('commerce/painel_adm/con_detalhe_prod', $dados,['qtdNoti'=>$qtdNotifi]);
    }

    // Cadastro de produtos
    public function cadProdutoActionFirst(){
        $nomeProd    = addslashes($_POST['nomeProd']);
        $descProd    = addslashes($_POST['descProd']);
        $categoria   = addslashes($_POST['categoria']);
        $marca       = addslashes($_POST['marca']);
        $estoque     = addslashes($_POST['estoque']);
        $preco       = addslashes($_POST['preco']);
        $precoAnt    = addslashes($_POST['precoAnt']);
        $promo       = addslashes($_POST['promo']);
        $novo        = addslashes($_POST['novo']);
        $peso        = floatval(str_replace(',','.', addslashes($_POST['peso'])));
        $altura      = floatval(str_replace(',','.', addslashes($_POST['altura'])));
        $largura     = floatval(str_replace(',','.', addslashes($_POST['largura'])));
        $comprimento = floatval(str_replace(',','.', addslashes($_POST['comprimento'])));
        $diametro    = floatval(str_replace(',','.', addslashes($_POST['diametro'])));

        $cad = new Produto;
        $dados = $cad->cadProdutoActionFirst($nomeProd, $descProd, $categoria, $marca, $estoque, $preco, $precoAnt, $promo, $novo, $peso, $altura, $largura, $comprimento, $diametro);

        if(isset($_SESSION['message']))
            $dados['message'] = $_SESSION['message'];
        else 
            $dados['message'] = '';

        unset($_SESSION['message']);

        echo json_encode($dados);

        //header("Location: /admin/painel/cadastrar-produtos");
        exit;
    }

    public function cadProdutoSecond($id){
        $dadosEco = AdminController::listaDadosEcommerce();

        $prod = new Produto;
        $noti  = new Notificacao;

        $qtdNotifi = $noti->qtdNotificacao();

        if(!$prod->listaProduto($id['id'])){
            $_SESSION['message'] = '<br><div class="alert alert-danger" role="alert">
                                        Produto inexistente!
                                    </div>';

            header("Location: /admin/painel/produtos");

            exit;
        }

        $this->render('commerce/painel_adm/cad_produto_2', $id,['qtdNoti'=>$qtdNotifi]);
    }

    public function cadProdutoActionSecond(){

        if(isset($_FILES['imagem'])){
            $img = new Produto;
            
            if($img->cadProdutoActionSecond($_FILES, addslashes($_POST['id']))){
                header("Location: /admin/painel/produtos");

                exit;
            }
            header("Location: /admin/painel/cadastrar-produtos/".addslashes($_POST['id']));
            
        }

    }

    public function excImagem($ids){
        $img = new Produto;

        $img->excImagem(addslashes($ids['idimg']), addslashes($ids['idprod']));

        header("Location: /admin/painel/editar-produto/".$ids['idprod']);
        
        exit;
    }

    public function excBanner($ids){
        $ban = new Produto;

        $ban->excBanner(addslashes($ids['idprod']), $ids['nomeban']);

        header("Location: /admin/painel/editar-produto/".$ids['idprod']);
        
        exit;
    }

    public function excProduto($id){
        $prod = new Produto;

        $prod->excProduto($id['id']);

        header("Location: /admin/painel/produtos");
        
        exit;
    }

}