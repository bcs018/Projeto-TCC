<?php
namespace src\controllers;

use \core\Controller;
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
        
        $pl = $plano->pegarItem($idpl);
        $plano->inserirPlano($idpl);
        
        $this->render('sitePrincipal/pagamentoPlano',  ['plano'=>$pl, 'sessionCode'=>$session]);
    }

    public function checkout(){
        $assinatura = new Assinatura;

        $parc = explode(';', $_POST['parc']);

        $id_compra = $assinatura->inserirAss($_POST);

        global $config;
        $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
        $creditCard->setReceiverEmail($config['pagseguro_seller']);
        //Referenciação da compra do seu site com o pagseguro
        $creditCard->setReference($id_compra);
        $creditCard->setCurrency("BRL");
        $creditCard->addItems()->withParameters(
            //Id do produto
            //Nome do produto
            //Quantidade
            //Preço

        );
        $creditCard->setSender()->setName(//Nome do cara que comprou);
        $creditCard->setSender()->setEmail(//Email do comprador);
        $creditCard->setSender()->setDocument()->withParameters('CPF', //CPF do comprador);
        $creditCard->setSender()->setPhone()->withParameters(
            //DDD
            //Telefone
        );
        $creditCard->setSender()->setHash($_POST['id']);
        
        //No ip como esta em localhost, tem que enviar um ip invalido
        $ip = $_SERVER['REMOTE_ADDR'];
        if(strlen($ip) < 9){
            $ip = '127.0.0.1';
        }    
        $creditCard->setSender()->setIp($ip);
        
        $creditCard->setShipping()->setAddress()->withParameters(
            //Rua
            //Numero
            //Bairro
            //CEP
            //Cidade
            //Estado
            'BRA'
            //Complemento
        );

        $creditCard->setBilling()->setAddress()->withParameters(
            //Rua
            //Numero
            //Bairro
            //CEP
            //Cidade
            //Estado
            'BRA'
            //Complemento
        );

        $creditCard->setToken($_POST['cartao_token']);
        $creditCard->setInstallment()->withParameters($parc[0], $parc[1], $parc[2]);
        $creditCard->setHolder()->setName(//Nome da pessoa do cartao);
        $creditCard->setHolder()->setDocument()->withParameters('CPF', //CPF do titular);
        
        $creditCard->setMode('DEFAULT');

        try{
            $result = $creditCard->register(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            echo json_encode($result);
            exit;
        }catch(Exception $e){
            echo json_encode(array('error'=>true, 'msg'=>$e->getMessage()));
        }

    }
}