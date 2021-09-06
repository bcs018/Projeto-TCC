<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\PagSeguro;
use \src\models\commerce\Compra;
use \src\models\commerce\Info;
use \src\models\sitePrincipal\Cadastro;
use src\models\commerce\Carrinho;

class PagamentoController extends Controller {
    // Primeira etapa da finalização da compra - Dados de entrega e calculo de cep
    public function index(){
        $info = new Info;
        $carr = new Carrinho;
        $cada = new Cadastro;

        $estados = $cada->lista_estados();
        $produtos = $carr->listaItens($_SESSION['carrinho']);
        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        //echo '<pre>';print_r($estados);
        
        $this->render('commerce/lay01/pagamento1',['dados'=>$dados,'produtos'=>$produtos, 'estados'=>$estados]);
    }

    // Recebe os dados da entrega referente a primeira parte da finalização da compra
    public function atuDadosEntregaAction($flag){
        $cep         = addslashes($_POST['cep']);
        $rua         = addslashes($_POST['rua']);
        $bairro      = addslashes($_POST['bairro']);
        $numero      = addslashes($_POST['numero']);
        $estado      = addslashes($_POST['estado']);
        $cidade      = addslashes($_POST['cidade']);
        $complemento = (empty($_POST['complemento'])?'':addslashes($_POST['complemento']));

        if(empty($rua) || empty($cep) || empty($bairro) || empty($numero) || empty($estado) || empty($cidade)){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Existem campos necessários para o endereço de entrega não preenchidos!
                                    </div>';

            header("Location: /pagamento");
            exit;
        }

        if(!isset($_SESSION['frete'])){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Calcule o frete para continuar!
                                    </div>';

            header("Location: /pagamento");
            exit;
        }
        
        $cada = new Cadastro;       
        $estados = $cada->lista_estados();

        //echo $estados[$estado - 1]['nome_estado'];

        // Armazenando os dados da entrega na SESSAO
        $_SESSION['dados_entrega'] = [
            'cep'         => $cep,
            'rua'         => $rua,
            'bairro'      => $bairro,
            'numero'      => $numero,
            'estado'      => $estados[$estado - 1]['nome_estado'],
            'cidade'      => $cidade,
            'complemento' => $complemento
        ];
        
        if($flag['flag'] == '0'){
            header("Location: /pagamento/2");
            exit;
        }

        header("Location: /gerar-boleto/2");
        exit;

    }
    
    // Segunda etapa da finalização da compra - Pagamento checkout
    public function pagamentoSecond(){
        $info = new Info;
        $carr = new Carrinho;
        if(!isset($_SESSION['carrinho'])){
            header("Location: /");
        }
        $produtos = $carr->listaItens($_SESSION['carrinho']);

        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        //echo '<pre>';print_r($dados);exit;

        if($dados['tp_recebimento'] == 'pagseguro'){
            //Pegando a sessão do pagseguro
            PagSeguro::setDados();

            try {
                $sessionCode = \PagSeguro\Services\Session::create(
                    \PagSeguro\Configuration\Configure::getAccountCredentials()
                );

                $session = $sessionCode->getResult();
            } catch (\Exception $e) {
                echo "OCORREU ERRO DURANTE O PROCESSO: ".$e->getMessage();
                exit;
            }
            
            $this->render('commerce/lay01/pagamento2',['dados'=>$dados,'produtos'=>$produtos, 'sessionCode'=>$session]);
            exit;

        }else if($dados['tp_recebimento'] == 'mercadopago'){
            // ...
        }else{
            header("Location: /");
        }

    }

    // Boleto -----

    // Segunda parte da geração do boleto
    public function gerarBoletoSecond(){
        $info = new Info;
        $carr = new Carrinho;
        if(!isset($_SESSION['carrinho'])){
            header("Location: /");
        }
        $produtos = $carr->listaItens($_SESSION['carrinho']);

        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        //echo '<pre>';print_r($dados);exit;

        if($dados['tp_recebimento'] == 'pagseguro'){
            //Pegando a sessão do pagseguro
            PagSeguro::setDados();

            try {
                $sessionCode = \PagSeguro\Services\Session::create(
                    \PagSeguro\Configuration\Configure::getAccountCredentials()
                );

                $session = $sessionCode->getResult();
            } catch (\Exception $e) {
                echo "OCORREU ERRO DURANTE O PROCESSO: ".$e->getMessage();
                exit;
            }
            
            $this->render('commerce/lay01/boleto2',['dados'=>$dados,'produtos'=>$produtos, 'sessionCode'=>$session]);
            exit;

        }else if($dados['tp_recebimento'] == 'mercadopago'){
            // ...
        }else{
            header("Location: /");
        }
    }

    // Primeira pagina da geração do boleto (calculo do frete)
    public function gerarBoleto(){
        $info = new Info;
        $carr = new Carrinho;
        $cada = new Cadastro;

        $estados = $cada->lista_estados();
        $produtos = $carr->listaItens($_SESSION['carrinho']);
        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        //echo '<pre>';print_r($estados);
        
        $this->render('commerce/lay01/boleto1',['dados'=>$dados,'produtos'=>$produtos, 'estados'=>$estados]);

    }

    public function fimPagamento($id_compra){
        $info = new Info;
        $comp = new Compra;
        //$carr = new Carrinho;

        $compra   = $comp->listaCompra($id_compra['id']);
        $produtos = $comp->listaProdCompra($id_compra['id']);
        $dados    = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        $this->render('commerce/lay01/final_compra',['dados'=>$dados,'compra'=>$compra, 'produtos'=>$produtos]);
    }
}