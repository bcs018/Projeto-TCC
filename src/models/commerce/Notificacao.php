<?php 

namespace src\models\commerce;

use \core\Model;

class Notificacao extends Model{
    public function gravaNotificacao($ecommerce_id, $texto, $link, $usu_ecommerce='0'){
        $sql = "INSERT INTO notificacao (ecommerce_id, texto, link, lido, usu_ecommerce)
                VALUES (?,?,?,?,?)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, intval($ecommerce_id));
        $sql->bindValue(2, $texto);
        $sql->bindValue(3, $link);
        $sql->bindValue(4, '0');
        $sql->bindValue(5, $usu_ecommerce);
        $sql->execute();
    }

    // public function qtdNotificacao(){
    //     $sql = "SELECT COUNT(*) as 'qtd' FROM notificacao
    //             WHERE ecommerce_id = ? AND lido = ?";
    //     $sql = $this->db->prepare($sql);
    //     $sql->bindValue(1, $_SESSION['id_sub_dom']);
    //     $sql->bindValue(2, '0');
    //     $sql->execute();

    //     if($sql->rowCount() > 0){
    //         return $sql->fetch();
    //     }

    //     return 0;
    // }

    // Lista notificações do usuario do ecommerce - Tab usuario
    public function listanotificacoes(){
        $sql = "SELECT * FROM notificacao
                WHERE ecommerce_id = ? AND lido = ? AND usu_ecommerce = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, '0');
        $sql->bindValue(3, '0');
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll();
        }

        return 0;
    }

    // Lista notificações do usuario cliente do ecommerce - Tab usuario_ecommerce
    public function listanotificacoesCli(){
        $sql = "SELECT * FROM notificacao
                WHERE ecommerce_id = ? AND lido = ? AND usu_ecommerce = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, '0');
        $sql->bindValue(3, $_SESSION['login_cliente_ecommerce']);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll();
        }

        return 0;
    }

    public function lerNotificacao($id){
        $sql = "UPDATE notificacao SET lido = ? WHERE ecommerce_id = ? AND notificacao_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, '1');
        $sql->bindValue(2, $_SESSION['id_sub_dom']);
        $sql->bindValue(3, $id);
        $sql->execute();
    }

    // Ler tds notificações do usuario do ecommerce - Tab usuario
    public function lerTdNotificacao(){
        $sql = "UPDATE notificacao SET lido = ? WHERE ecommerce_id = ? AND usu_ecommerce = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, '1');
        $sql->bindValue(2, $_SESSION['id_sub_dom']);
        $sql->bindValue(3, 0);
        $sql->execute(); 
    }

    // Ler tds notificações do usuario cliente do ecommerce - Tab usuario_ecommerce
    public function lerTdNotificacaoCli(){
        $sql = "UPDATE notificacao SET lido = ? WHERE ecommerce_id = ? AND usu_ecommerce = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, '1');
        $sql->bindValue(2, $_SESSION['id_sub_dom']);
        $sql->bindValue(3, $_SESSION['login_cliente_ecommerce']);
        $sql->execute(); 
    }
}
