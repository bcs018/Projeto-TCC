<?php 

namespace src\models\sitePrincipal;

use \core\Model;

class Notificacao extends Model{
    public function gravaNotificacao($ecommerce_id, $texto, $link, $sub_dominio){
        $sql = "INSERT INTO notificacao_admin (ecommerce_id, texto, link, lido, sub_dominio)
                VALUES (?,?,?,?,?)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $ecommerce_id);
        $sql->bindValue(2, $texto);
        $sql->bindValue(3, $link);
        $sql->bindValue(4, '0');
        $sql->bindValue(5, $sub_dominio);
        $sql->execute();
    }

    public function listanotificacoes(){
        $sql = "SELECT * FROM notificacao_admin WHERE lido = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, '0');
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll();
        }

        return 0;
    }

    public function lerNotificacao($id){
        $sql = "UPDATE notificacao_admin SET lido = ? WHERE notificacao_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, '1');
        $sql->bindValue(2, $id);
        $sql->execute();
    }

    public function lerTdNotificacao(){
        $sql = "UPDATE notificacao_admin SET lido = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, '1');
        $sql->execute(); 
    }
}