<?php
namespace src\controllers;

use \core\Controller;
use Exception;
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;
use \src\models\Plano;
use \src\models\Assinatura;

class BoletoController extends Controller {

    public function checkout($idpl){
        $assinatura = new Assinatura;
        $plano = new Plano;

        $plano->inserirPlano($idpl['pl']);
        $dados = $assinatura->inserirAss();
        
        global $gerencianet_clientid;
        global $gerencianet_clientsecret;
        global $gerencianet_sandbox;

        //Opções padrao
        $options = [
            'client_id'=>$gerencianet_clientid,
            'client_secret'=>$gerencianet_clientsecret,
            'sandbox'=>$gerencianet_sandbox
        ];

        $body = [
            'name' => 'Plano '.$dados['nome_plano'],
            'interval' => 1,
            'repeats' => null
        ];

        try{
            $api = new Gerencianet($options);
            $plan = $api->createPlan([], $body);
        }catch(GerencianetException $e){
            print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);
        }catch(Exception $e){
            print_r($e->getMessage());
        }

        //Itens do plano
        $item[] = array(
            'name' => 'Plano '.$dados['nome_plano'],
            'amount' => 1,
            'value' => intval($dados['preco'] * 100)
        );

        $items = [
            $item
        ];

        //Id da compra no seu site e o endereço para notificação
        $metadata = [
            'custom_id' => $dados['id_assinatura'],
            'notification_url' => 'http://127.0.0.1/boleto/notificacao'
        ];

        //Caso for uma compra com frete, colocar isso abaixo para sair no boleto
        /*$shipping[] = [
            'name'=> 'FRETE',
            'value'=> //Valor do frete
        ]*/

        //Corpo da reuisição
        $body = [
            'items'=> $item,
            'metadata'=> $metadata
        ];

        $params = [
            'id' => $plan['data']['plan_id']
        ];

        try{
            $subscription = $api->createSubscription($params, $body);
        }catch(GerencianetException $e){
            print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);
        }catch(Exception $e){
            //Excluindo o ultimo registro inserido da assinatura pois houve erro no pagamento
            $assinatura->excluirItem($dados['id_assinatura']);

            echo 'ERRO AO EMITIR BOLETO ';
            print_r($e->getMessage());
            exit;
        }

        $params = [
            'id' => $subscription['data']['subscription_id']
        ];

        $customer = [
            'name' => $dados['nome_cli'],
            'cpf' => $dados['cpf'],
            'phone_number' => $dados['ddd'].$dados['celular']
        ];
        
        $body = [
            'payment' => [
                'banking_billet' => [
                    'expire_at' => date("Y-m-d", strtotime("+5 days")),
                    'customer' => $customer
                ]
            ]
        ];

        try{
            $subscription = $api->paySubscription($params, $body);

            print_r($subscription);
        }catch(GerencianetException $e){
            print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);
        }
    }

    public function obrigado($id){
        $assinatura = new Assinatura;

        $link = $assinatura->pegarItemAss($id['id']);

        $this->render('sitePrincipal/obrigado', ['link'=>$link['link_bol']]);
    }

    public function notification(){
        global $gerencianet_clientid;
        global $gerencianet_clientsecret;
        global $gerencianet_sandbox;

        $options = [
            'client_id'=>$gerencianet_clientid,
            'client_secret'=>$gerencianet_clientsecret,
            'sandbox'=>$gerencianet_sandbox
        ];

        $token = $_POST['notification'];
        $params = [
            'token' => $token,
        ];

        try {
            $api = new \Gerencianet\Gerencianet($options);
            $c = $api->getNotification($params, []);

            //Pega a ultima chave do array
            $ultimoIte = end($c['data']);

            $custo_id = $ultimoIte['custom_id'];

            $status = $ultimoIte['status']['current'];

            //Se foi pago o boleto
            if($status == 'paid'){
                //Alterar as tabelas para deixar o usuario ativo e assinatura paga
            }

        } catch (Exception $e) {
            echo "Erro" . $e->getMessage();
        }
    }

    public function retornaInfo(){
        global $gerencianet_clientid;
        global $gerencianet_clientsecret;
        global $gerencianet_sandbox;

        $options = [
            'client_id'=>$gerencianet_clientid,
            'client_secret'=>$gerencianet_clientsecret,
            'sandbox'=>$gerencianet_sandbox
        ];

        $params = ['limit' => 20, 'offset' => 0];


        try {
            $api = new \Gerencianet\Gerencianet($options);
            $subscription = $api->getPlans($params, []);

            echo "<pre>";
            print_r($subscription);

        } catch (Exception $e) {
            echo "Erro" . $e->getMessage();
        }
    }
}