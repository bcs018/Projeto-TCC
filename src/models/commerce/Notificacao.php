<?php 

namespace src\models\commerce;

use \core\Model;

class Notificacao extends Model{
    public function gravaNotificacao($ecommerce_id, $texto, $link){
        $sql = "INSERT INTO notificacao (ecommerce_id, texto, link, lido)
                VALUES (?,?,?,?)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $ecommerce_id);
        $sql->bindValue(2, $texto);
        $sql->bindValue(3, $link);
        $sql->bindValue(4, '0');
        $sql->execute();
    }

    public function qtdNotificacao(){
        $sql = "SELECT COUNT(*) as 'qtd' FROM notificacao
                WHERE ecommerce_id = ? AND lido = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, '0');
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch();
        }

        return 0;
    }
}
