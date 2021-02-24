<?php
namespace src\controllers;

use \core\Controller;
use Exception;
use \src\models\Plano;
use \src\models\Assinatura;

class BoletoController extends Controller {
    public function pagamentoPlano($idpl){
        $plano = new Plano;
        
        $pl = $plano->pegarItem($idpl['pl']);
        $plano->inserirPlano($idpl['pl']);
        
        $this->render('sitePrincipal/boletoPgm',  ['plano'=>$pl]);
    }

    public function checkout($idpl){
        $assinatura = new Assinatura;
        $plano = new Plano;

        $dados = $assinatura->inserirAss($_POST);
        $pl = $plano->pegarItem($idpl['pl']);
        $plano->inserirPlano($idpl['pl']);

        //$preco = explode(".", $dados['preco']);
        //$preco = intval($preco[0].$preco[1]);

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
        $items = [
            'name' => $dados['nome_plano'],
            'amount' => 1,
            'value' => ($dados['preco'] * 100)
        ];

        //Id da compra no seu site e o endereço para notificação
        $metadata = [
            'custom_id' => $dados['id_assinatura'],
            'notification_url' => BASE_URL.'boleto/notificacao'
        ];

        //Caso for uma compra com frete, colocar isso abaixo para sair no boleto
        /*$shipping = [
            'name'=> 'FRETE',
            'value'=> //Valor do frete
        ]*/

        //Corpo da reuisição
        $body = [
            'metadata'=>$metadata,
            'items'=>$items
        ];

        try{
            $api = new \Gerencianet\Gerencianet($options);
            $charge = $api->createCharge(array(), $body);

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

                        //Salvar o link do boleto em algum lugar do banco de dados
                        //header("Location: ".$link);

                        $assinatura->salvarLinkBoleto($link, $dados['id_assinatura']);

                        $this->render('sitePrincipal/obrigado',  ['plano'=>$pl, 'link'=>$link]);

                    }
                }catch(Exception $e){
                    //Excluindo o ultimo registro inserido da assinatura pois houve erro no pagamento
                    $assinatura->excluirItem($dados['id_assinatura']);

                    echo "ERRO ". $e->getMessage();
                    exit;
                }
            }
        }catch(Exception $e){
            //Excluindo o ultimo registro inserido da assinatura pois houve erro no pagamento
            $assinatura->excluirItem($dados['id_assinatura']);

            echo 'ERRO AO EMITIR BOLETO'. $e->getMessage();
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