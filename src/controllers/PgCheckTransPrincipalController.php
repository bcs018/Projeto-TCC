<?php
namespace src\controllers;

use \core\Controller;
use Exception;
use \src\models\Plano;
use \src\models\Assinatura;

class PgCheckTransPrincipalController extends Controller {
    public function pagamentoPlano($idpl){

        //Pegando a sessão do pagseguro
        try {
            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            $session = $sessionCode->getResult();
        } catch (\Exception $e) {
            echo "OCORREU ERRO DURANTE O PROCESSO: ".$e->getMessage();
            exit;
        }

        $plano = new Plano;
        
        $pl = $plano->pegarItem($idpl['pl']);
        $plano->inserirPlano($idpl['pl']);
        
        $this->render('sitePrincipal/cartaoPgm',  ['plano'=>$pl, 'sessionCode'=>$session]);
    }

    public function checkout(){
        $assinatura = new Assinatura;

        $parc = explode(';', $_POST['parc']);

        $dados = $assinatura->inserirAss($_POST);

        $nome_tit = addslashes($_POST['nome_tit']);
        $cpf = addslashes($_POST['cpf']);

        //Variavel global defineda no Config.php = email do vendedor
        global $pagseguro_seller;

        $preco = floatval($dados['preco']);

        $dados['email'] = 'bwcommerce@outlook.com';
        $dados['token'] = '23E3EEF82A4046C5826279C0A3D2A541';
        $dados['reference'] = $dados['id_assinatura'];
        $dados['name'] = $dados['nome_plano'];
        $dados['charge'] = 'AUTO';
        $dados['period'] = 'MONTHLY';
        $dados['amountPerPayment'] = $dados['preco'];
        $dados['membershipFee'] = 0.00;
        $dados['trialPeriodDuration'] = 0;  
        $dados['trialPeriodDuration'] = 0;  
        $dados['trialPeriodDuration'] = 0;  
        $dados['trialPeriodDuration'] = 0;  
        $dados['trialPeriodDuration'] = 0;  


        $url = 'https://ws.sandbox.pagseguro.uol.com.br/pre-approvals/request';

        $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
        $creditCard->setReceiverEmail($pagseguro_seller);
        //Referenciação da compra do seu site com o pagseguro
        $creditCard->setReference($dados['id_assinatura']);
        $creditCard->setCurrency("BRL");
        $creditCard->addItems()->withParameters(
            $dados['id_plano'],
            $dados['nome_plano'],
            1,
            $preco

        );
        $creditCard->setSender()->setName($dados['nome_cli']);
        $creditCard->setSender()->setEmail($dados['email']);
        $creditCard->setSender()->setDocument()->withParameters('CPF', $dados['cpf']);
        $creditCard->setSender()->setPhone()->withParameters(
            $dados['ddd'],
            $dados['celular']
        );
        $creditCard->setSender()->setHash($_POST['id']);
        
        //No ip como esta em localhost, tem que enviar um ip valido
        $ip = $_SERVER['REMOTE_ADDR'];
        if(strlen($ip) < 9){
            $ip = '127.0.0.1';
        }    
        $creditCard->setSender()->setIp($ip);
        
        $creditCard->setShipping()->setAddress()->withParameters(
            $dados['rua'],
            $dados['numero'],
            $dados['bairro'],
            $dados['cep'],
            $dados['cidade'],
            $dados['estado'],
            'BRA',
            $dados['complemento']
        );

        $creditCard->setBilling()->setAddress()->withParameters(
            $dados['rua'],
            $dados['numero'],
            $dados['bairro'],
            $dados['cep'],
            $dados['cidade'],
            $dados['estado'],
            'BRA',
            $dados['complemento']
        );

        $creditCard->setToken($_POST['cartao_token']);
        $creditCard->setInstallment()->withParameters($parc[0], $parc[1], 12);
        $creditCard->setHolder()->setName($nome_tit);
        $creditCard->setHolder()->setDocument()->withParameters('CPF', $cpf);
        
        $creditCard->setMode('DEFAULT');

        //Url para o pagseguro notificar que o pagamento foi aprovado
        //$creditCard->setNotificationUrl('/notification');

        //$creditCard->setNotificationUrl();

        try{
            $result = $creditCard->register(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            echo json_encode($result);
            exit;
        }catch(Exception $e){
            //Excluindo o ultimo registro inserido da assinatura pois houve erro no pagamento
            $assinatura->excluirItem($dados['id_assinatura']);

            echo json_encode(array('error'=>true, 'msg'=>$e->getMessage()));
            exit;
        }
    }

    public function notification(){
        header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
        $assinatura = new Assinatura;
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

                //Dependendo do retorno no PS, faz alguma coisa no sistema (FAZER UMA TRATATIVA MELHOR POSTERIORMENTE)
                if($status == 3){
                    $assinatura->aprovarCompra($ref);
                }elseif($status == 5 || $status == 6 || $status == 7 || $status == 8 || $status == 9){
                    $assinatura->bloquearCompra($ref);
                }else{
                    $assinatura->analiseCompra($ref);
                }

            }
        } catch (Exception $e) {
            //throw $th;
        }    
    }
}