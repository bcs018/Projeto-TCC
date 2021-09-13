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

    // Checkout com Cartão
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
        $id_compra = $comp->addCompra('cartao', $parc);

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

        foreach($produtos as $p){
            $creditCard->addItems()->withParameters(
                $p[0], //id do produto
                $p['nome_pro'],
                $_SESSION['carrinho'][$p[0]], //qtd
                // preço pdt+frete*qtd
                floatval($p['preco'])/**$_SESSION['carrinho'][$p[0]]*/
            );
        }

        $creditCard->addItems()->withParameters(
            999999, //id do produto
            'FRETE',
            1, //qtd
            $frete
        );

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

            // switch ($result->getStatus()) {
            //     case '1':
            //         # code...
            //         break;
                
            //     default:
            //         # code...
            //         break;
            // }

            $comp->atuCompra($id_compra, $result->getCode(),'0', $result->getStatus());

            unset($_SESSION['frete']);
            unset($_SESSION['carrinho']);
            unset($_SESSION['subtotal']);
            unset($_SESSION['total']);
            unset($_SESSION['dados_entrega']);

            echo json_encode(['id_compra'=>$id_compra]);
            exit;
        }catch(Exception $e){
            //Excluindo o ultimo registro inserido da compra pois houve erro no pagamento
            $comp->delCompra($id_compra);

            echo json_encode(array('error'=>true, 'msg'=>$e->getMessage()));
            exit;
        }
    }

    // Checkout com Boleto
    public function checkoutBol(){
        $dados = PagSeguro::setDados();
        $comp = new Compra;
        $carr = new Carrinho;
        $cada = new Cadastro;

        $produtos = $carr->listaItens($_SESSION['carrinho']);
        $id_compra = $comp->addCompra('boleto');

        $frete = floatval(str_replace(',','.', $_SESSION['frete']['preco']));

        if(!$id_compra){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Erro 001 ao fazer pagamento, atualize a página e tente novamente!
                                    </div>';
            return false;
        }

        $usuario = $cada->listaUsuario($_SESSION['login_cliente_ecommerce']);

        $ddd_usu = substr($usuario['celular_ue'],1,2);
        $cel_usu = substr($usuario['celular_ue'],4,5).substr($usuario['celular_ue'],10,4);

        //Instantiate a new Boleto Object
        $boleto = new \PagSeguro\Domains\Requests\DirectPayment\Boleto();

        // Set the Payment Mode for this payment request
        $boleto->setMode('DEFAULT');

        /**
         * @todo Change the receiver Email
         */
        $boleto->setReceiverEmail($dados['ps_email']); 

        // Set the currency
        $boleto->setCurrency("BRL");

        // Add an item for this payment request
        foreach($produtos as $p){
            $boleto->addItems()->withParameters(
                $p[0],
                $p['nome_pro'],
                $_SESSION['carrinho'][$p[0]],
                floatval($p['preco'])
            );
        }

        // Add an item for this payment request
        $boleto->addItems()->withParameters(
            999999, //id do produto
            'FRETE',
            1, //qtd
            $frete
        );

        // Set a reference code for this payment request. It is useful to identify this payment
        // in future notifications.
        $boleto->setReference($id_compra);

        //set extra amount
        //$boleto->setExtraAmount(11.5);

        // Set your customer information.
        // If you using SANDBOX you must use an email @sandbox.pagseguro.com.br
        $boleto->setSender()->setName($usuario['nome_usu_ue'].' '.$usuario['sobrenome']);
        $boleto->setSender()->setEmail($usuario['email_ue']);

        $boleto->setSender()->setPhone()->withParameters(
            $ddd_usu,
            $cel_usu
        );

        $boleto->setSender()->setDocument()->withParameters(
            'CPF',
            $usuario['cpf_ue']
        );

        $boleto->setSender()->setHash($_POST['id']);

        //No ip como esta em localhost, tem que enviar um ip valido
        $ip = $_SERVER['REMOTE_ADDR'];
        if(strlen($ip) < 9){
            $ip = '127.0.0.1';
        }    
        $boleto->setSender()->setIp($ip);

        // Set shipping information for this payment request
        $boleto->setShipping()->setAddress()->withParameters(
            $_SESSION['dados_entrega']['rua'],
            $_SESSION['dados_entrega']['numero'],
            $_SESSION['dados_entrega']['bairro'],
            str_replace('-','',$_SESSION['dados_entrega']['cep']),
            $_SESSION['dados_entrega']['cidade'],
            $_SESSION['dados_entrega']['estado'],
            'BRA',
            $_SESSION['dados_entrega']['complemento']
        );

        // If your payment request don't need shipping information use:
        // $boleto->setShipping()->setAddressRequired()->withParameters('FALSE');

        try {
            //Get the crendentials and register the boleto payment
            $result = $boleto->register(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            // You can use methods like getCode() to get the transaction code and getPaymentLink() for the Payment's URL.
            //echo "<pre>";
            // print_r($result->getCode());
            // print_r($result->getPaymentLink());

            $comp->atuCompra($id_compra, $result->getCode(), $result->getPaymentLink(), $result->getStatus());

            unset($_SESSION['frete']);
            unset($_SESSION['carrinho']);
            unset($_SESSION['subtotal']);
            unset($_SESSION['total']);
            unset($_SESSION['dados_entrega']);

            echo json_encode(['id_compra'=>$id_compra]);
        } catch (Exception $e) {
            echo "</br> <strong>";
            die($e->getMessage());
        }
    }

    public function notification(){
        header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
        
        $comp = new Compra;

        try {
            //Verifica se foi enviada as informações do retorno da compra
            if(\PagSeguro\Helpers\Xhr::hasPost()){
                $r = \PagSeguro\Services\Transactions\Notification::check(
                    \PagSeguro\Configuration\Configure::getAccountCredentials()
                );

                $ref = $r->getReference();
                /**
                 * Status
                 * 1 - Aguardando pagamento
                 * 2 - Em analise - Paga mas n foi aprovado de cara
                 * 3 - Paga
                 * 4 - Disponivel - Disponivel para saque
                 * 5 - Em disputa
                 * 6 - Dinheiro foi devolvido
                 * 7 - Compra cancelada
                 * 8 - Debitado - Dinheiro daquela compra foi devolvida na disputa
                 * 9 - Retenção temporaria - Quando o cara liga para o cartão e fala que nao reconhece a compra
                 */
                $status = $r->getStatus();

                $arquivo = "retorno.txt";
                
                //Variável $fp armazena a conexão com o arquivo e o tipo de ação.
                $fp = fopen($arquivo, "a+");

                //Escreve no arquivo aberto.
                fwrite($fp, $ref);
                
                //Fecha o arquivo.
                fclose($fp);

                //Dependendo do retorno no PS, faz alguma coisa no sistema (FAZER UMA TRATATIVA MELHOR POSTERIORMENTE)
                // if($status == 3){
                //     $comp->alteraStatusCompra($ref);
                // }elseif($status == 5 || $status == 6 || $status == 7 || $status == 8 || $status == 9){
                //     $assinatura->bloquearCompra($ref);
                // }else{
                //     $assinatura->analiseCompra($ref);
                // }

            }
        } catch (Exception $e) {
            //throw $th;
        }    
    }
}