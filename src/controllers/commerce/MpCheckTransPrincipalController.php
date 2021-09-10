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

        //echo '<pre>';print_r($_POST['cardData']);exit;

        if(empty($token) || empty($idEmissorBanco) || empty($emissorBanco) || empty($tipoDocumento) || empty($totalCompra) || empty($numParcela)){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Erro 001 durante o pagamento, tente novamente atualizando a pagina!
                                    </div>';
            
        }

        if(empty($numeroDocumento)){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        CPF em branco!
                                    </div>';
        }

        \MercadoPago\SDK::setAccessToken("TEST-6863185104180239-090800-f737fca299bc2244dcdf24a739522f5f-219670214");

        $payment = new \MercadoPago\Payment();
        $payment->transaction_amount = (float)$totalCompra;
        $payment->token = $token;
        $payment->description = 'Alguma descrição qualquer'; //Razão do pagamento ou titulo do item
        $payment->installments = (int)$numParcela;
        $payment->payment_method_id = $emissorBanco;
        $payment->issuer_id = (int)$idEmissorBanco;

        $payer = new \MercadoPago\Payer();
        $payer->email = 'test_user_61744996@testuser.com'; //$_POST['email'];
        $payer->identification = array( 
            "type" => $tipoDocumento,
            "number" => $numeroDocumento
        );
        $payment->payer = $payer;

        $payment->save(); 

        $response = array(
            'status' => $payment->status,
            'message' => $payment->status_detail,
            'id' => $payment->id
        );
        echo json_encode($response);
        exit;
    }

}
