<?php
namespace src\controllers\sitePrincipal;

use \core\Controller;
use \src\models\Assinatura;

class OpcaoPgmController extends Controller {

    public function escolhaPagamento()
    {   
        $assinatura = new Assinatura;

        if($assinatura->pegarItensValidos($_SESSION['person']['id'])){
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">Você já fez algum pagamento que está em andamento ou pago ou emitiu um boleto que está dentro da data de vencimento!</div><br>';
            header('Location: /crie-sua-loja/pagamento');
            exit;        
        }

        $opcao = addslashes($_POST['opcaoPgm']);

        if($opcao == 'cartao'){
            header("Location: /crie-sua-loja/pagamento/cartao/". $_POST['plan']);
        }elseif($opcao == 'boleto'){
            header("Location: /crie-sua-loja/pagamento/boleto/checkout/". $_POST['plan']);
        }else{
            $_SESSION['message'] = '<div class="alert alert-danger" role="alert">Opção inexistente, escolha entre "Cartão de crédito" ou "Boleto".</div><br>';
            header('Location: /crie-sua-loja/pagamento');        
        }
    }

}