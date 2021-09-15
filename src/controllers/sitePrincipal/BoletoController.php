<?php
namespace src\controllers\sitePrincipal;

use \core\Controller;
use Exception;
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;
use \src\models\sitePrincipal\Plano;
use \src\models\sitePrincipal\Assinatura;

class BoletoController extends Controller {

    public function checkout($idpl){
        $assinatura = new Assinatura;
        $plano = new Plano;

        if($assinatura->pegarItensValidos($_SESSION['person']['id'])){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">Você já fez algum pagamento que está em andamento ou pago, ou emitiu um boleto que está dentro da data de vencimento, faça seu LOGIN e verifique!</div><br>';
            echo json_encode(['retorno'=>0]);
            exit;        
        }

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
            'notification_url' => 'http://bcnoticias.000webhostapp.com/boleto/notification'
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
            exit;
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
                    'expire_at' => date("Y-m-d", strtotime('+3 days')),
                    //'expire_at' => date("Y-m-d"),
                    'customer' => $customer
                ]
            ]
        ];

        try{
            $subscription = $api->paySubscription($params, $body);
            
            $assinatura->salvarLinkBoleto($subscription['data']['pdf']['charge'], $dados['id_assinatura']);

            unset($_SESSION['messageFree']);

            echo json_encode(['retorno'=>1, 'idAss'=>$dados['id_assinatura']]);
            exit; 
        }catch(GerencianetException $e){
            print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);
        }
    }

    public function obrigado($id){
        $boleto = new Assinatura;

        $link = $boleto->pegarBoleto($id['id']);

        $this->render('sitePrincipal/obrigado', ['link'=>$link['link_boleto']]);
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
        //$token = '6bfb0b38-f8d1-44a9-bc57-636fd963e12a';
        $params = [
            'token' => $token,
        ];

        try {
            $api = new \Gerencianet\Gerencianet($options);
            $c = $api->getNotification($params, []);
            //echo '<pre>';
            //print_r($c);exit;

            //Pega a ultima chave do array
            $ultimoIte = end($c['data']);

            $custo_id = $ultimoIte['custom_id'];

            $status = $ultimoIte['status']['current'];

            //echo $ultimoIte['created_at'];exit;

            // echo $status;
            // exit;

            $assinatura = new Assinatura;

            switch ($status) {
                // Assinatura criada, porém nenhuma cobrança foi paga
                case 'new': 
                    
                    break;
                
                // Forma de pagamento selecionada, aguardando a confirmação do pagamento
                case 'waiting':
                    $assinatura->atualizaStatus($custo_id, $status, 1);
                    break;

                // Assinatura ativa. Todas as cobranças estão sendo geradas
                case 'active': 
                    $assinatura->atualizaStatus($custo_id, $status, 1);
                    break;
                
                // Pagamento confirmado
                case 'paid':
                    $assinatura->atualizaStatus($custo_id, $status, 1);
                    break;
                
                // Não foi possível confirmar o pagamento da cobrança
                case 'unpaid': 
                    $assinatura->atualizaStatus($custo_id, $status, 0);
                    break;

                // Assinatura foi cancelada pelo vendedor ou pelo pagador
                case 'canceled': 
                    $assinatura->atualizaStatus($custo_id, $status, 0);
                    break;

                // Pagamento devolvido pelo lojista ou pelo intermediador Gerencianet
                case 'refunded': 
                    $assinatura->atualizaStatus($custo_id, $status, 0);
                    break;

                // Pagamento em processo de contestação
                case 'contested': 
                    $assinatura->atualizaStatus($custo_id, $status, 0);
                    break;

                // Cobrança foi confirmada manualmente
                case 'settled': 
                    $assinatura->atualizaStatus($custo_id, $status, 1);
                    break;

                // Assinatura expirada. Todas as cobranças configuradas para a assinatura já foram emitidas
                case 'expired': 
                    $assinatura->atualizaStatus($custo_id, $status, 0);
                    break;
                
                default:
                    $assinatura->atualizaStatus($custo_id, $status, 0);
                    break;
            }


        } catch (Exception $e) {
            echo "Erro" . $e->getMessage();
        }
    }
}