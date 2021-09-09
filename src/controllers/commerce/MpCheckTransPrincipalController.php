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
        $titCartao       = $_POST['cardData']['cardholderName'];

        echo '<pre>';print_r($_POST['cardData']);exit;

        if(empty($token) || empty($idEmissorBanco) || empty($emissorBanco) || empty($tipoDocumento) || empty($totalCompra) || empty($numParcela)){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Erro 001 durante o pagamento, tente novamente atualizando a pagina!
                                    </div>';
            
        }

        //if(empty())

        \MercadoPago\SDK::setAccessToken("TEST-6863185104180239-090800-f737fca299bc2244dcdf24a739522f5f-219670214");

        $payment = new \MercadoPago\Payment();
        $payment->transaction_amount = (float)$_POST['transactionAmount'];
        $payment->token = $_POST['token'];
        $payment->description = $_POST['description']; //Razão do pagamento ou titulo do item
        $payment->installments = (int)$_POST['installments'];
        $payment->payment_method_id = $_POST['paymentMethodId'];
        $payment->issuer_id = (int)$_POST['issuer'];

        $payer = new \MercadoPago\Payer();
        $payer->email = $_POST['email'];
        $payer->identification = array( 
            "type" => $_POST['docType'],
            "number" => $_POST['docNumber']
        );
        $payment->payer = $payer;

        $payment->save(); 

        $response = array(
            'status' => $payment->status,
            'message' => $payment->status_detail,
            'id' => $payment->id
        );
        echo json_encode($response);
        
    }

}
