<?php
namespace src\controllers\sitePrincipal;

use \core\Controller;
use \src\models\commerce\Compra;

class NotificacaoClientesController extends Controller {
    public function notificacaoGereCard(){
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
            //echo '<pre>';
            //print_r($c);exit;

            //Pega a ultima chave do array
            $ultimoIte = end($c['data']);

            $custo_id = $ultimoIte['custom_id'];

            $status = $ultimoIte['status']['current'];

            //echo $ultimoIte['created_at'];exit;

            // echo $status;
            // exit;

            $compra = new Compra;

            $compra->alteraStatusCompra($status, $custo_id);

            // switch ($status) {
            //     // Assinatura criada, porém nenhuma cobrança foi paga
            //     case 'new': 
                    
            //         break;
                
            //     // Forma de pagamento selecionada, aguardando a confirmação do pagamento
            //     case 'waiting':
            //         $compra->alteraStatusCompra($status, $custo_id);
            //         break;

            //     // Assinatura ativa. Todas as cobranças estão sendo geradas
            //     case 'active': 
            //         $assinatura->atualizaStatus($custo_id, $status, 1);
            //         break;
                
            //     // Pagamento confirmado
            //     case 'paid':
            //         $assinatura->atualizaStatus($custo_id, $status, 1);
            //         break;
                
            //     // Não foi possível confirmar o pagamento da cobrança
            //     case 'unpaid': 
            //         $assinatura->atualizaStatus($custo_id, $status, 0);
            //         break;

            //     // Assinatura foi cancelada pelo vendedor ou pelo pagador
            //     case 'canceled': 
            //         $assinatura->atualizaStatus($custo_id, $status, 0);
            //         break;

            //     // Pagamento devolvido pelo lojista ou pelo intermediador Gerencianet
            //     case 'refunded': 
            //         $assinatura->atualizaStatus($custo_id, $status, 0);
            //         break;

            //     // Pagamento em processo de contestação
            //     case 'contested': 
            //         $assinatura->atualizaStatus($custo_id, $status, 0);
            //         break;

            //     // Cobrança foi confirmada manualmente
            //     case 'settled': 
            //         $assinatura->atualizaStatus($custo_id, $status, 1);
            //         break;

            //     // Assinatura expirada. Todas as cobranças configuradas para a assinatura já foram emitidas
            //     case 'expired': 
            //         $assinatura->atualizaStatus($custo_id, $status, 0);
            //         break;
                
            //     default:
            //         $assinatura->atualizaStatus($custo_id, $status, 0);
            //         break;
            // }


        } catch (\Exception $e) {
            echo "Erro" . $e->getMessage();
        }
    }
}