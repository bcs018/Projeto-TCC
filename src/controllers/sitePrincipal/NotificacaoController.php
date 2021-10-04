<?php
namespace src\controllers\sitePrincipal;

use \core\Controller;
use \src\models\sitePrincipal\Notificacao;

class NotificacaoController extends Controller {
    public function listaNotificacoes(){
        $not = new Notificacao;

        return $not->listaNotificacoes();
    }

    public function lerNotificacao(){
        $id = $_POST['id'];

        $not = new Notificacao;

        $not->lerNotificacao($id);

        echo json_encode(['ret'=>true]);
        exit;
    }

    public function lerTdNotificacao(){
        $not = new Notificacao;

        $not->lerTdNotificacao();

        echo json_encode(['ret'=>true]);
        exit;
    }
}