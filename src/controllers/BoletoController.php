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

        // if($assinatura->pegarItensValidos($_SESSION['person']['id'])){
        //     $_SESSION['message'] = '<div class="alert alert-danger" role="alert">Você já fez algum pagamento que está em andamento ou pago, ou emitiu um boleto que está dentro da data de vencimento, faça seu LOGIN e verifique!</div><br>';
        //     echo json_encode(['retorno'=>0]);
        //     exit;        
        // }

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
            'notification_url' => 'http://api.webhookinbox.com/i/t4zIoUvj/in/'
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
                    'expire_at' => '2021-04-30', //date("Y-m-d", strtotime("-1 days")),
                    'customer' => $customer
                ]
            ]
        ];

        try{
            $subscription = $api->paySubscription($params, $body);
            
            $assinatura->salvarLinkBoleto($subscription['data']['pdf']['charge'], $dados['id_assinatura']);

            echo json_encode(['retorno'=>1, 'idAss'=>$dados['id_assinatura']]);
            exit; 
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

        // $token = $_POST['notification'];
        $token = '6bfb0b38-f8d1-44a9-bc57-636fd963e12a';
        $params = [
            'token' => $token,
        ];

        try {
            $api = new \Gerencianet\Gerencianet($options);
            $c = $api->getNotification($params, []);
            echo '<pre>';
            print_r($c);exit;

            //Pega a ultima chave do array
            $ultimoIte = end($c['data']);

            $custo_id = $ultimoIte['custom_id'];

            $status = $ultimoIte['status']['current'];

            echo print_r($status);
            exit;

            switch ($status) {
                // Assinatura criada, porém nenhuma cobrança foi paga
                case 'new': 
                    
                    break;
                
                // Forma de pagamento selecionada, aguardando a confirmação do pagamento
                case 'waiting':
                    
                    break;

                // Assinatura ativa. Todas as cobranças estão sendo geradas
                case 'active': 

                    break;
                
                // Pagamento confirmado
                case 'paid':
                    # code...
                    break;
                
                // Não foi possível confirmar o pagamento da cobrança
                case 'unpaid': 

                    break;

                // Assinatura foi cancelada pelo vendedor ou pelo pagador
                case 'canceled': 

                    break;

                // Pagamento devolvido pelo lojista ou pelo intermediador Gerencianet
                case 'refunded': 

                    break;

                // Pagamento em processo de contestação
                case 'contested': 

                    break;

                // Cobrança foi confirmada manualmente
                case 'settled': 

                    break;
                
                default:
                    # code...
                    break;
            }
            if($status == 'paid'){
                //Alterar as tabelas para deixar o usuario ativo e assinatura paga
            }

        } catch (Exception $e) {
            echo "Erro" . $e->getMessage();
        }
    }
}