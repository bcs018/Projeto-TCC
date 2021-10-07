<?php
namespace src\controllers\commerce;

use \core\Controller;
use \src\models\commerce\Compra;
use \src\models\commerce\Info;
use \src\models\commerce\Cadastro;
use src\models\commerce\Carrinho;
use src\models\commerce\Notificacao;
use src\models\commerce\Produto;

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
        $carr = new Carrinho;
        $prod = new Produto;
        $not  = new Notificacao;

        $id_compra = $comp->addCompra('cartao', $parc, true);

        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        \MercadoPago\SDK::setAccessToken($dados['mp_access_token']);

        $payment = new \MercadoPago\Payment();
        $payment->transaction_amount = (float)$totalCompra;
        $payment->token = $token;
        $payment->description = 'PotLid Commerce'; //Razão do pagamento ou titulo do item
        $payment->installments = (int)$numParcela;
        $payment->payment_method_id = $emissorBanco;
        $payment->issuer_id = (int)$idEmissorBanco;
        $payment->statement_descriptor = $dados['nome_fantasia'];

        $payer = new \MercadoPago\Payer();
        $payer->email = $email; //$_POST['email'];
        $payer->identification = array( 
            "type" => $tipoDocumento,
            "number" => $numeroDocumento
        );
        $payment->payer = $payer;

        $payment->save(); 
        $erros = '';

        // echo '<pre>';
        // print_r($payment);exit;

        if($payment->status == 'rejected'){
            switch ($payment->status_detail) {
                case 'cc_rejected_bad_filled_card_number':
                    $comp->delCompra($id_compra);
                    $erros .= '<div class="alert alert-danger" role="alert">
                                    Revise o número do cartão.
                               </div>';
                    echo json_encode(['error'=> true, 'message'=>$erros]);

                    break;
                
                case 'cc_rejected_bad_filled_date':
                    $comp->delCompra($id_compra);
                    $erros .= '<div class="alert alert-danger" role="alert">
                                    Revise a data de vencimento.
                               </div>';
                    echo json_encode(['error'=> true, 'message'=>$erros]);
                    
                    break;

                case 'cc_rejected_bad_filled_other':
                    $comp->delCompra($id_compra);
                    $erros .= '<div class="alert alert-danger" role="alert">
                                    Revise os dados.
                               </div>';
                    echo json_encode(['error'=> true, 'message'=>$erros]);
                    
                    break;

                case 'cc_rejected_bad_filled_security_code':
                    $comp->delCompra($id_compra);
                    $erros .= '<div class="alert alert-danger" role="alert">
                                    Revise o código de segurança do cartão.
                               </div>';
                    echo json_encode(['error'=> true, 'message'=>$erros]);
                    
                    break;
                
                case 'cc_rejected_card_error':
                case 'cc_rejected_blacklist':
                    $comp->delCompra($id_compra);
                    $erros .= '<div class="alert alert-danger" role="alert">
                                    Não pudemos processar seu pagamento.
                               </div>';
                    echo json_encode(['error'=> true, 'message'=>$erros]);
                    
                    break;

                case 'cc_rejected_call_for_authorize':
                    $comp->delCompra($id_compra);
                    $erros .= '<div class="alert alert-danger" role="alert">
                                    Você deve autorizar a sua operadora do cartão ('.$emissorBanco.') 
                                    o pagamento do valor ao Mercado Pago.
                               </div>';
                    echo json_encode(['error'=> true, 'message'=>$erros]);
                    
                    break;

                case 'cc_rejected_card_disabled':
                    $comp->delCompra($id_compra);
                    $erros .= '<div class="alert alert-danger" role="alert">
                                    Ligue para a operadora para ativar seu cartão. 
                                    O telefone está no verso do seu cartão.
                               </div>';
                    echo json_encode(['error'=> true, 'message'=>$erros]);
                    
                    break;

                case 'cc_rejected_duplicated_payment':
                    $comp->delCompra($id_compra);
                    $erros .= '<div class="alert alert-danger" role="alert">
                                    Você já efetuou um pagamento com esse valor. 
                                    Caso precise pagar novamente, utilize outro cartão 
                                    ou outra forma de pagamento.
                               </div>';
                    echo json_encode(['error'=> true, 'message'=>$erros]);
                    
                    break;

                case 'cc_rejected_high_risk':
                    $comp->delCompra($id_compra);
                    $erros .= '<div class="alert alert-danger" role="alert">
                                    Seu pagamento foi recusado. <br>
                                    Escolha outra forma de pagamento. Recomendamos meios de pagamento em dinheiro.
                               </div>';
                    echo json_encode(['error'=> true, 'message'=>$erros]);
                    
                    break;

                case 'cc_rejected_insufficient_amount':
                    $comp->delCompra($id_compra);
                    $erros .= '<div class="alert alert-danger" role="alert">
                                O '.$emissorBanco.' possui saldo insuficiente.
                               </div>';
                    echo json_encode(['error'=> true, 'message'=>$erros]);
                    
                    break;

                case 'cc_rejected_invalid_installments':
                    $comp->delCompra($id_compra);
                    $erros .= '<div class="alert alert-danger" role="alert">
                                O '.$emissorBanco.' não processa pagamentos em '.$numParcela.' parcelas.
                               </div>';
                    echo json_encode(['error'=> true, 'message'=>$erros]);
                    
                    break;

                case 'cc_rejected_max_attempts':
                    $comp->delCompra($id_compra);
                    $erros .= '<div class="alert alert-danger" role="alert">
                                    Você atingiu o limite de tentativas permitido.
                                    <br>
                                    Escolha outro cartão ou outra forma de pagamento.
                               </div>';
                    echo json_encode(['error'=> true, 'message'=>$erros]);
                    
                    break;

                case 'cc_rejected_other_reason':
                    $comp->delCompra($id_compra);
                    $erros .= '<div class="alert alert-danger" role="alert">
                                '.$emissorBanco.' não processa o pagamento.
                               </div>';
                    echo json_encode(['error'=> true, 'message'=>$erros]);
                    
                    break;

                default:
                    $comp->delCompra($id_compra);
                    $erros .= '<div class="alert alert-danger" role="alert">
                                    Erro 003 ao processar pagamento, contate o administrador.
                               </div>';
                    echo json_encode(['error'=> true, 'message'=>$erros]);

                    break;
            }

        }elseif($payment->status == 'in_process'){
            // -- Atualizando o estoque
            $produtos = $carr->listaItens($_SESSION['carrinho']);
            $not->gravaNotificacao($_SESSION['id_sub_dom'], 'Nova venda realizada através de cartão!', '/admin/painel/venda/'.$id_compra);

            foreach($produtos as $p){
                $prod->ediEstoque($p[0], intval($p['estoque'] - $_SESSION['carrinho'][$p[0]]));
            }

            // --

            unset($_SESSION['frete']);
            unset($_SESSION['carrinho']);
            unset($_SESSION['subtotal']);
            unset($_SESSION['total']);
            unset($_SESSION['dados_entrega']);

            $_SESSION['message'] = '<div class="alert alert-info" role="alert">
                                        Estamos processando seu pagamento.
                                        <br>
                                        Não se preocupe, em menos de 2 dias úteis informaremos 
                                        por e-mail se foi creditado ou se necessitamos de mais 
                                        informação.
                                    </div>';
            $comp->atuCompra($id_compra, $payment->id,'0', $payment->status);

            echo json_encode(['error'=> false, 'id_compra'=>$id_compra]);
            exit;

        }elseif($payment->status == 'approved'){
            // -- Atualizando o estoque
            $produtos = $carr->listaItens($_SESSION['carrinho']);
            $not->gravaNotificacao($_SESSION['id_sub_dom'], 'Nova venda realizada através de cartão!', '/admin/painel/venda/'.$id_compra);

            foreach($produtos as $p){
                $prod->ediEstoque($p[0], intval($p['estoque'] - $_SESSION['carrinho'][$p[0]]));
            }
        
            // --
            
            unset($_SESSION['frete']);
            unset($_SESSION['carrinho']);
            unset($_SESSION['subtotal']);
            unset($_SESSION['total']);
            unset($_SESSION['dados_entrega']);

            $_SESSION['message'] = '<div class="alert alert-success" role="alert">
                                        Pronto, seu pagamento foi aprovado! 
                                        No resumo, você verá a cobrança do valor 
                                        como '.$payment->statement_descriptor.'
                                    </div>';
            $comp->atuCompra($id_compra, $payment->id,'0', $payment->status);

            echo json_encode(['error'=> false, 'id_compra'=>$id_compra]);
            exit;

        }else{
            $comp->delCompra($id_compra);
            $erros .= '<div class="alert alert-danger" role="alert">
                            Erro 004 ao processar pagamento, contate o administrador.
                        </div>';
            echo json_encode(['error'=> true, 'message'=>$erros]);
        }

        exit;
    }

    public function checkout_mpBol(){
        $nome = $_POST['payerFirstName'];
        $sobrenome = $_POST['payerLastName'];
        $email = $_POST['payerEmail'];

        if(empty($nome) || empty($sobrenome) || empty($email)){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                        Existem campos obrigatórios em branco!
                                    </div>';
            header("Location: /gerar-boleto/2");
            return false;
        }

        $info = new Info;
        $carr = new Carrinho;
        $prod = new Produto;
        $cada = new Cadastro;
        $comp = new Compra;
        $not  = new Notificacao;

        //$produtos = $carr->listaItens($_SESSION['carrinho']);
        $id_compra = $comp->addCompra('boleto');
        $usu = $cada->listaUsuario($_SESSION['login_cliente_ecommerce']);

        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);

        \MercadoPago\SDK::setAccessToken($dados['mp_access_token']);

        $payment = new \MercadoPago\Payment();
        $payment->transaction_amount = $_SESSION['total'];
        $payment->description = "Compra ".$dados['nome_fantasia'];
        $payment->payment_method_id = "bolbradesco";
        $payment->payer = array(
            "email"      => $email,
            "first_name" => $nome,
            "last_name"  => $sobrenome,
            "identification" => array(
                "type"   => "CPF",
                "number" => $usu['cpf_ue']
            ),
            "address"=>  array(
                "zip_code"      => $_SESSION['dados_entrega']['cep'],
                "street_name"   => $_SESSION['dados_entrega']['rua'],
                "street_number" => $_SESSION['dados_entrega']['numero'],
                "neighborhood"  => $_SESSION['dados_entrega']['bairro'],
                "city"          => $_SESSION['dados_entrega']['cidade'],
                "federal_unit"  => $_SESSION['dados_entrega']['estado']
            )
        );

        $payment->save();

        $comp->atuCompra($id_compra,$payment->id ,$payment->transaction_details->external_resource_url, $payment->status_detail);

        // -- Atualizando o estoque
        $produtos = $carr->listaItens($_SESSION['carrinho']);
        $not->gravaNotificacao($_SESSION['id_sub_dom'], 'Nova venda realizada através de boleto!', '/admin/painel/venda-pendente/'.$id_compra);

        foreach($produtos as $p){
            $prod->ediEstoque($p[0], intval($p['estoque'] - $_SESSION['carrinho'][$p[0]]));
        }
    
        // --
        
        unset($_SESSION['frete']);
        unset($_SESSION['carrinho']);
        unset($_SESSION['subtotal']);
        unset($_SESSION['total']);
        unset($_SESSION['dados_entrega']);

        header("Location: /pagamento/concluido/".$id_compra);
        exit;

        echo '<pre>';
        print_r($payment);exit;
    }

}
