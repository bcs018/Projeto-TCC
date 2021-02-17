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
        
        $this->render('sitePrincipal/pagamentoPlano',  ['plano'=>$pl, 'sessionCode'=>$session]);
    }

    public function checkout(){
        $assinatura = new Assinatura;

        $parc = explode(';', $_POST['parc']);

        $dados = $assinatura->inserirAss($_POST);

        $nome_tit = addslashes($_POST['nome_tit']);
        $cpf = addslashes($_POST['cpf']);

        global $config;

        $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
        $creditCard->setReceiverEmail($config['pagseguro_seller']);
        //Referenciação da compra do seu site com o pagseguro
        $creditCard->setReference($dados['id_assinatura']);
        $creditCard->setCurrency("BRL");
        $creditCard->addItems()->withParameters(
            $dados['id_plano'],
            $dados['nome_plano'],
            1,
            floatval($dados['preco'])

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
        $creditCard->setInstallment()->withParameters($parc[0], $parc[1], $parc[2]);
        $creditCard->setHolder()->setName($nome_tit);
        $creditCard->setHolder()->setDocument()->withParameters('CPF', $cpf);
        
        $creditCard->setMode('DEFAULT');

        try{
            $result = $creditCard->register(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            echo json_encode($result);
            exit;
        }catch(Exception $e){
            echo json_encode(array('error'=>true, 'msg'=>$e->getMessage()));
            exit;
        }

    }
}