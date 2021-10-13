<?php
namespace src\controllers\commerce;

use \core\Controller;
use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;
use Exception;
use \src\models\commerce\Produto;
use \src\models\commerce\Compra;
use \src\models\commerce\Info;
use \src\models\commerce\Cadastro;
use src\models\commerce\Carrinho;
use src\models\commerce\Notificacao;

class GereCheckTransPrincipalController extends Controller {
    public function checkout_gere(){
        $info = new Info;
        $carr = new Carrinho;
        $cada = new Cadastro;
        $comp = new Compra;
        $not  = new Notificacao;
        $prod = new Produto;

        $dados = $info->pegaDadosCommerce($_SESSION['sub_dom']);
        $produtos = $carr->listaItens($_SESSION['carrinho']);
        $usuario = $cada->listaUsuario($_SESSION['login_cliente_ecommerce']);

        $parcela = explode(';',$_POST['parcela']);

        $parc[0] = $parcela[0];
        $parc[1] = str_replace('.','',$parcela[1]);
        $parc[1] = str_replace(',','.',$parc[1]);

        $id_compra = $comp->addCompra('cartao', $parc);    

        $clientId = 'Client_Id_45d786d57022418c71a1feb6ad04879689729f59'; // insira seu Client_Id, conforme o ambiente (Des ou Prod)
        $clientSecret = 'Client_Secret_6d7692cf8197942b09eceea1b155981c39825d29'; // insira seu Client_Secret, conforme o ambiente (Des ou Prod)
        

        $options = [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'sandbox' => true // altere conforme o ambiente (true = Homologação e false = producao)
        ];

        $paymentToken = $_POST['paymentToken']; // payment_token obtido na 1ª etapa (através do Javascript único por conta Gerencianet)

        foreach($produtos as $p){
            $items[] = [
                'name' => $p['nome_pro'], // nome do item, produto ou serviço
                'amount' => intval($_SESSION['carrinho'][$p[0]]), // quantidade
                'value' => intval($p['preco'])*100 // valor (1000 = R$ 10,00) (Obs: É possível a criação de itens com valores negativos. Porém, o valor total da fatura deve ser superior ao valor mínimo para geração de transações.)
            ];
        }

        $frete = floatval(str_replace(',','.', $_SESSION['frete']['preco']));

        $shippings[] = [
            "name"=>'FRETE',
            "value"=>$frete*100
        ];

        $metadata = array(
                            'custom_id' => $id_compra,
                            'notification_url'=>'http://potlid.com.br/notificacao/gerencianet'
                        );
       
        $ddd_usu = substr($usuario['celular_ue'],1,2);
        $cel_usu = substr($usuario['celular_ue'],4,5).substr($usuario['celular_ue'],10,4);
    
        $customer = [
            'name' => $usuario['nome_usu_ue'].' '.$usuario['sobrenome'], // nome do cliente
            'cpf' => $usuario['cpf_ue'], // cpf do cliente
            'phone_number' => $ddd_usu.$cel_usu, // telefone do cliente
            'email' => $usuario['email_ue'], // endereço de email do cliente
            'birth' => '1997-06-18' // data de nascimento do cliente
        ];

        $billingAddress = [
            'street' => $dados['rua'],
            'number' => $dados['numero'],
            'neighborhood' => $dados['bairro'],
            'zipcode' => $dados['cep'],
            'city' => $dados['cidade'],
            'state' => 'MG'
        ];

        $discount = [
            'type' => 'currency',
            'value' => 1
        ];

        // $configurations = [
        //     'fine' => 200,
        //     'interest' => 33
        // ];


        $credit_card = [
            'customer' => $customer,
            'installments' => intval($parcela[0]), // número de parcelas em que o pagamento deve ser dividido
            'discount' =>$discount,
            'billing_address' => $billingAddress,
            'payment_token' => $paymentToken,
            'message' => 'teste\nteste\nteste\nteste'
        ];

        $payment = [
            'credit_card' => $credit_card // forma de pagamento (credit_card = cartão)
        ];

        $body = [
            'items' => $items,
            'shippings'=>$shippings,
            'metadata' =>$metadata,
            'payment' => $payment
        ];

        try {
            $api = new Gerencianet($options);
            $pay_charge = $api->oneStep([],$body);

            $comp->atuCompra($id_compra, $pay_charge['data']['charge_id'],'0', $pay_charge['data']['status']);
            $not->gravaNotificacao($_SESSION['id_sub_dom'], 'Nova venda realizada através de cartão!', '/admin/painel/venda/'.$id_compra);
            // echo '<pre>';
            // print_r($pay_charge);
            // echo '<pre>';exit;
            // -- Atualizando o estoque
            $produtos = $carr->listaItens($_SESSION['carrinho']);

            foreach($produtos as $p){
                $prod->ediEstoque($p[0], intval($p['estoque'] - $_SESSION['carrinho'][$p[0]]));
            }
            // --

            unset($_SESSION['frete']);
            unset($_SESSION['carrinho']);
            unset($_SESSION['subtotal']);
            unset($_SESSION['total']);
            unset($_SESSION['dados_entrega']);

            echo json_encode(['id_compra'=>$id_compra]);
            exit;

            // echo '<pre>';
            // print_r($pay_charge);
            // echo '<pre>';
        } catch (GerencianetException $e) {
            $comp->delCompra($id_compra);
            echo json_encode(array('error'=>true, 'msg'=>'Cód:'.$e->code.' Erro:'.$e->error.' ErroMsg:'.$e->errorDescription));
            exit;
            // print_r($e->code);
            // print_r($e->error);
            // print_r($e->errorDescription);
        } catch (Exception $e) {
            $comp->delCompra($id_compra);
            echo json_encode(array('error'=>true, 'msg'=>$e->getMessage()));
            exit;

            // print_r($e->getMessage());
        }
    }
    
}