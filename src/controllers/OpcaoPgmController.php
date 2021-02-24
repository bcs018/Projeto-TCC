<?php
namespace src\controllers;

use \core\Controller;

class OpcaoPgmController extends Controller {

    public function escolhaPagamento()
    {   
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