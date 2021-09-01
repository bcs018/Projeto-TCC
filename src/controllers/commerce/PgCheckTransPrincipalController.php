<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\PagSeguro;
use \src\models\commerce\Compra;
use \src\models\commerce\Info;
use \src\models\commerce\Cadastro;
use src\models\commerce\Carrinho;
use Exception;

use function PHPSTORM_META\type;

class PgCheckTransPrincipalController extends Controller {

    public function checkout(){
        $dados = PagSeguro::setDados();

        $parc = explode(';', addslashes($_POST['parc']));
        $nome_tit = addslashes($_POST['nome_card']);
        $cpf = addslashes($_POST['cpf']);
        //email do vendedor
        $pagseguro_seller = $dados['ps_email'];
        $code = $dados['ps_token'];

        $comp = new Compra;
        $carr = new Carrinho;
        $cada = new Cadastro;

        $produtos = $carr->listaItens($_SESSION['carrinho']);
        $id_compra = $comp->addCompra('cartao');

        $frete = floatval(str_replace(',','.', $_SESSION['frete']['preco']));


        // $options = [
        //     'amount' => $parc[1], //Required
        //     'card_brand' => 'visa', //Optional
        //     'max_installment_no_interest' => 12 //Optional
        // ];
        
        // try {
        //     $result = \PagSeguro\Services\Installment::create(
        //         \PagSeguro\Configuration\Configure::getAccountCredentials(),
        //         $options
        //     );
        
        //     echo "<pre>";
        //     print_r($result->getInstallments());exit;
        // } catch (Exception $e) {
        //     die($e->getMessage());
        // }



        if(!$id_compra){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Erro 001 ao fazer pagamento, atualize a página e tente novamente!
                                    </div>';
            return false;
        }

        $usuario = $cada->listaUsuario($_SESSION['login_cliente_ecommerce']);

        $ddd_usu = substr($usuario['celular_ue'],1,2);
        $cel_usu = substr($usuario['celular_ue'],4,5).substr($usuario['celular_ue'],10,4);

        // echo "DDD: ".$ddd_usu;
        // echo "cel: ".$cel_usu;exit;
    
        //echo '<pre>';print_r($produtos);exit;

        $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
        $creditCard->setReceiverEmail($pagseguro_seller);

        //Referenciação da compra do seu site com o pagseguro
        $creditCard->setReference($id_compra);
        $creditCard->setCurrency("BRL");

        $i = false;

        foreach($produtos as $p){
            $creditCard->addItems()->withParameters(
                $p[0], //id do produto
                $p['nome_pro'],
                $_SESSION['carrinho'][$p[0]], //qtd
                ($i==false?$p['preco']+$frete:$p['preco'])
            );
            $i=true;
        }
        $creditCard->setSender()->setName($usuario['nome_usu_ue'].' '.$usuario['sobrenome']);
        $creditCard->setSender()->setEmail($usuario['email_ue']);
        $creditCard->setSender()->setDocument()->withParameters('CPF', $usuario['cpf_ue']);
        $creditCard->setSender()->setPhone()->withParameters(
            $ddd_usu,
            $cel_usu
        );
        $creditCard->setSender()->setHash($_POST['id']);
        
        //No ip como esta em localhost, tem que enviar um ip valido
        $ip = $_SERVER['REMOTE_ADDR'];
        if(strlen($ip) < 9){
            $ip = '127.0.0.1';
        }    
        $creditCard->setSender()->setIp($ip);
        
        $creditCard->setShipping()->setAddress()->withParameters(
            $_SESSION['dados_entrega']['rua'],
            $_SESSION['dados_entrega']['numero'],
            $_SESSION['dados_entrega']['bairro'],
            str_replace('-','',$_SESSION['dados_entrega']['cep']),
            $_SESSION['dados_entrega']['cidade'],
            $_SESSION['dados_entrega']['estado'],
            'BRA',
            $_SESSION['dados_entrega']['complemento']
        );

        $creditCard->setBilling()->setAddress()->withParameters(
            $_SESSION['dados_entrega']['rua'],
            $_SESSION['dados_entrega']['numero'],
            $_SESSION['dados_entrega']['bairro'],
            str_replace('-','',$_SESSION['dados_entrega']['cep']),
            $_SESSION['dados_entrega']['cidade'],
            $_SESSION['dados_entrega']['estado'],
            'BRA',
            $_SESSION['dados_entrega']['complemento']
        );

        $creditCard->setToken($_POST['cartao_token']);
        $creditCard->setInstallment()->withParameters(intval($parc[0]), $parc[1], 12);

        $creditCard->setHolder()->setName($nome_tit);
        $creditCard->setHolder()->setDocument()->withParameters('CPF', $cpf);
        
        $creditCard->setMode('DEFAULT');

        //Url para o pagseguro notificar que o pagamento foi aprovado
        //$creditCard->setNotificationUrl('http://www.bw.com.br/notification');

        //$creditCard->setNotificationUrl();

        try{
            $result = $creditCard->register(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            // unset($_SESSION['frete']);
            // unset($_SESSION['carrinho']);
            // unset($_SESSION['subtotal']);
            // unset($_SESSION['total']);
            // unset($_SESSION['dados_entrega']);

            echo json_encode($result);
            exit;
        }catch(Exception $e){
            //Excluindo o ultimo registro inserido da compra pois houve erro no pagamento
            $comp->delCompra($id_compra);

            echo json_encode(array('error'=>true, 'msg'=>$e->getMessage()));
            exit;
        }
    }

    // public function notification(){
    //     header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
    //     $assinatura = new Assinatura;
    //     try {
    //         //Verifica se foi enviada as informações do retorno da compra
    //         if(\PagSeguro\Helpers\Xhr::hasPost()){
    //             $r = \PagSeguro\Services\Transactions\Notification::check(
    //                 \PagSeguro\Configuration\Configure::getAccountCredentials()
    //             );

    //             $ref = $r->getReference();
    //             /**
    //              * Status
    //              * 1 - Aguardando pagamento
    //              * 2 - Em analise - Paga mas n foi aprovado de cara
    //              * 3 - Paga
    //              * 4 - Disponivel - Disponivel para saque
    //              * 5 - Em disputa
    //              * 6 - Dinheiro foi devolvido
    //              * 7 - Compra cancelada
    //              * 8 - Debitado - Dinheiro daquela compra foi devolvida na disputa
    //              * 9 - Retenção temporaria - Quando o cara liga para o cartão e fala que nao reconhece a compra
    //              */
    //             $status = $r->getStatus();

    //             //Dependendo do retorno no PS, faz alguma coisa no sistema (FAZER UMA TRATATIVA MELHOR POSTERIORMENTE)
    //             if($status == 3){
    //                 $assinatura->aprovarCompra($ref);
    //             }elseif($status == 5 || $status == 6 || $status == 7 || $status == 8 || $status == 9){
    //                 $assinatura->bloquearCompra($ref);
    //             }else{
    //                 $assinatura->analiseCompra($ref);
    //             }

    //         }
    //     } catch (Exception $e) {
    //         //throw $th;
    //     }    
    // }
}