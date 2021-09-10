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

class MpCheckTransPrincipalController extends Controller {

    // Checkout com Cartão
    public function checkout(){
        $token           = $_POST['cardData']['token'];
        $idEmissorBanco  = $_POST['cardData']['issuerId'];
        $emissorBanco    = $_POST['cardData']['paymentMethodId'];
        $totalCompra     = $_POST['cardData']['amount'];
        $numParcela      = $_POST['cardData']['installments'];    
        $tipoDocumento   = $_POST['cardData']['identificationNumber']; 
        $numeroDocumento = $_POST['cardData']['identificationType'];
        $email           = $_POST['cardData']['cardholderEmail'];
        $parc            = $_POST[ 'parc'];
        $erros           = '';
        $flag            = false;

        //echo '<pre>';print_r($_POST['cardData']);exit;

        if(empty($token) || empty($idEmissorBanco) || empty($emissorBanco) || empty($tipoDocumento) || empty($totalCompra) || empty($numParcela)){
            $erros .= '<div class="alert alert-danger" role="alert">
                                        Erro 001 durante o pagamento, tente novamente atualizando a pagina!
                                    </div>';
            $flag = true;
        }

        if(empty($numeroDocumento)){
            $erros .= '<div class="alert alert-danger" role="alert">
                                        CPF em branco!
                                    </div>';
            $flag = true;

        }

        if(empty($email)){
            $erros .= '<div class="alert alert-danger" role="alert">
                                        E-mail em branco!
                                    </div>';
            $flag = true;

        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $erros .= '<div class="alert alert-danger" role="alert">
                                        E-mail inválido!
                                    </div>';
            $flag = true;

        }

        if($flag){
            echo json_encode(['error'=> true, 'message'=>$erros]);
            exit;
        }

        $info = new Info;
        $comp = new Compra;

        $id_compra = $comp->addCompra('cartao', $parc, true);

        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        \MercadoPago\SDK::setAccessToken($dados['mp_access_token']);

        $payment = new \MercadoPago\Payment();
        $payment->transaction_amount = (float)$totalCompra;
        $payment->token = $token;
        $payment->description = 'BW Commerce'; //Razão do pagamento ou titulo do item
        $payment->installments = (int)$numParcela;
        $payment->payment_method_id = $emissorBanco;
        $payment->issuer_id = (int)$idEmissorBanco;

        $payer = new \MercadoPago\Payer();
        $payer->email = $email; //$_POST['email'];
        $payer->identification = array( 
            "type" => $tipoDocumento,
            "number" => $numeroDocumento
        );
        $payment->payer = $payer;

        $payment->save(); 

        if($payment->status == 'rejected'){
            // ALTERAR O STATUS DA COMPRA DE ACORDO COM O STATUS DO PAGAMENTO
            // FAZER ISSO TBM COM O PAGSEGURO
        }

        // EXEMPLO DE RETORNO DO MERCADO PAGO = FAIL
        // {
        //     "status": "rejected",
        //     "message": "cc_rejected_other_reason",
        //     "id": 1240930604,
        //     "error": false,
        //     "id_compra": "47"
        // }

        $comp->atuCompra($id_compra, $payment->id);

        $response = array(
            'status' => $payment->status,
            'message' => $payment->status_detail,
            'id' => $payment->id,
            'error' => false,
            'id_compra' => $id_compra
        );
        echo json_encode($response);
        exit;
    }

}
