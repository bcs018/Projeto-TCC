<?php
namespace src\controllers;

use \core\Controller;
use Exception;
use Gerencianet\Exception\GerencianetException;
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

        //Itens do plano
        $item[] = array(
            'name' => 'Plano '.$dados['nome_plano'],
            'amount' => 1,
            'value' => intval($dados['preco'] * 100)
        );

        //Id da compra no seu site e o endereço para notificação
        $metadata = [
            'custom_id' => $dados['id_assinatura'],
            'notification_url' => BASE_URL.'/boleto/notificacao'
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

        try{
            $api = new \Gerencianet\Gerencianet($options);
            $charge = $api->createCharge([], $body);
            
            if($charge['code']=='200'){
                $charge_id = $charge['data']['charge_id'];
                
                $params = [
                    'id'=>$charge_id
                ];

                $customer = [
                    //Dados do cliente
                    'name' => $dados['nome_cli'],
                    'cpf' => $dados['cpf'],
                    'phone_number' => $dados['ddd'].$dados['celular']
                ];

                $bankingBillet = [
                    //Data de vencimento 4 dias após a compra
                    'expire_at' => date('Y-m-d', strtotime('+4 days')),
                    'customer'=> $customer,
                    //Opcional
                    //'message'=>''
                ];

                $payment = [
                    'banking_billet'=>$bankingBillet
                ];

                $body = [
                    'payment'=> $payment
                ];

                try{
                    $charge = $api->payCharge($params, $body);

                    if($charge['code'] == '200'){
                        //Pegando o link do boleto
                        $link = $charge['data']['link'];

                        //Salvar o link do boleto no banco de dados
                        $assinatura->salvarLinkBoleto($link, $dados['id_assinatura']);

                        header("Location: /crie-sua-loja/pagamento/obrigado/".$dados['id_assinatura']);
                    }
                }catch(Exception $e){
                    //Excluindo o ultimo registro inserido da assinatura pois houve erro no pagamento
                    $assinatura->excluirItem($dados['id_assinatura']);

                    echo "ERRO ". $e->getMessage();
                    exit;
                }
            }
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
}