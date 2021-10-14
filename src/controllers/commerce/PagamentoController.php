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

        if(isset($_SESSION['carrinho'])){
            $carrinho = $carr->listaItens($_SESSION['carrinho']);
        }else{
            $carrinho = false;
        }

        //echo '<pre>';print_r($estados);
        
        $this->render('commerce/'.$dados['layout'].'/pagamento1',['dados'=>$dados,'produtos'=>$produtos, 'estados'=>$estados, 'carrinho'=>$carrinho]);
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

            if($flag['flag'] == 0)
                header("Location: /pagamento");
            else
                header("Location: /gerar-boleto");
            exit;
        }

        $carr = new Carrinho;
        $produtos = $carr->listaItens($_SESSION['carrinho']);

        // -- Verificando se a qtd solicitada é maior que a qtd no estoque
        $i = false;
        $_SESSION['message'] = '';

        foreach($produtos as $p){
            if($_SESSION['carrinho'][$p[0]] > $p['estoque']){
                $_SESSION['message'] .= '<div class="alert alert-danger" role="alert">
                                            Produto '.$p['nome_pro'].' possui '.$p['estoque'].' em estoque 
                                            e você solicitou '.$_SESSION['carrinho'][$p[0]].', por favor, 
                                            revisse a quantidade e tente novamente!
                                        </div>';
                $i = true;
            }
        }

        if($i){
            if($flag['flag'] == 0)
                header("Location: /pagamento");
            else
                header("Location: /gerar-boleto");
            
            exit;
        }

        // --

        if(!isset($_SESSION['frete'])){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Calcule o frete para continuar!
                                    </div>';
            if($flag['flag'] == 0)
                header("Location: /pagamento");
            else
                header("Location: /gerar-boleto");
            
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
        if(isset($_SESSION['carrinho'])){
            $carrinho = $carr->listaItens($_SESSION['carrinho']);
        }else{
            $carrinho = false;
        }
/*
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
            
            $this->render('commerce/'.$dados['layout'].'/pagamento2',['dados'=>$dados,'produtos'=>$produtos, 'sessionCode'=>$session, 'carrinho'=>$carrinho]);
            exit;

        }else if($dados['tp_recebimento'] == 'mercadopago'){
            $this->render('commerce/'.$dados['layout'].'/pagamento2',['dados'=>$dados,'produtos'=>$produtos, 'carrinho'=>$carrinho]);
            exit;
        }else if ($dados['tp_recebimento'] == 'gerencianet'){*/
            $this->render('commerce/'.$dados['layout'].'/pagamento2',['dados'=>$dados,'produtos'=>$produtos, 'carrinho'=>$carrinho]);
        // }else{
        //     header("Location: /");
        // }

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
        if(isset($_SESSION['carrinho'])){
            $carrinho = $carr->listaItens($_SESSION['carrinho']);
        }else{
            $carrinho = false;
        }

        // if($dados['tp_recebimento'] == 'pagseguro'){
        //     //Pegando a sessão do pagseguro
        //     PagSeguro::setDados();

        //     try {
        //         $sessionCode = \PagSeguro\Services\Session::create(
        //             \PagSeguro\Configuration\Configure::getAccountCredentials()
        //         );

        //         $session = $sessionCode->getResult();
        //     } catch (\Exception $e) {
        //         echo "OCORREU ERRO DURANTE O PROCESSO: ".$e->getMessage();
        //         exit;
        //     }
            
        //     $this->render('commerce/'.$dados['layout'].'/boleto2',['dados'=>$dados,'produtos'=>$produtos, 'sessionCode'=>$session, 'carrinho'=>$carrinho]);
        //     exit;

        // }else if($dados['tp_recebimento'] == 'mercadopago'){          
             $this->render('commerce/'.$dados['layout'].'/boleto2',['dados'=>$dados,'produtos'=>$produtos, 'carrinho'=>$carrinho]);
        //     exit;
        // }else{
        //     header("Location: /");
        // }
    }

    // Primeira pagina da geração do boleto (calculo do frete)
    public function gerarBoleto(){
        $info = new Info;
        $carr = new Carrinho;
        $cada = new Cadastro;

        $estados = $cada->lista_estados();
        $produtos = $carr->listaItens($_SESSION['carrinho']);
        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        if(isset($_SESSION['carrinho'])){
            $carrinho = $carr->listaItens($_SESSION['carrinho']);
        }else{
            $carrinho = false;
        }

        //echo '<pre>';print_r($estados);
        
        $this->render('commerce/'.$dados['layout'].'/boleto1',['dados'=>$dados,'produtos'=>$produtos, 'estados'=>$estados, 'carrinho'=>$carrinho]);

    }

    public function fimPagamento($id_compra){
        $info = new Info;
        $comp = new Compra;
        $carr = new Carrinho;

        if(isset($_SESSION['carrinho'])){
            $carrinho = $carr->listaItens($_SESSION['carrinho']);
        }else{
            $carrinho = false;
        }

        $compra   = $comp->listaCompra($id_compra['id']);
        $produtos = $comp->listaProdCompra($id_compra['id']);
        $dados    = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        $this->render('commerce/'.$dados['layout'].'/final_compra',['dados'=>$dados,'compra'=>$compra, 'produtos'=>$produtos, 'carrinho'=>$carrinho]);
    }



    public function criaCliente(){

        $header = [
            'Authorization: Bearer TEST-6863185104180239-090800-f737fca299bc2244dcdf24a739522f5f-219670214',
            'Content-Type: application/json'
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.mercadopago.com/users/test_user');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['site_id'=>'MLB']));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $r = curl_exec($ch);

        curl_close($ch);

        echo '<pre>';
        print_r($r);

        exit;


        // curl -X POST \
        // -H "Content-Type: application/json" \
        // -H 'Authorization: Bearer PROD_ACCESS_TOKEN' \
        // "https://api.mercadopago.com/users/test_user" \
        // -d '{"site_id":"MLB"}';
    }
}