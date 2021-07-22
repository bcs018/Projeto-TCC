<?php
namespace src\models\sitePrincipal;
use \core\Model;

class Plano extends Model {

    public function listarPlano(){
        $sql = "SELECT * FROM plano";
        $sql = $this->db->query($sql);

        $sql = $sql->fetchAll();

        return $sql;
    }

    public function pegarItem($pl){
        $sql = "SELECT * FROM plano WHERE plano_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $pl);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch();
        }

        return false;
   
    }

    public function inserirPlano($pl){
        $sql = "UPDATE ecommerce_usu SET plano_id = ? WHERE ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $pl);
        $sql->bindValue(2, $_SESSION['commerce']['id']);
        $sql->execute();
    }

}