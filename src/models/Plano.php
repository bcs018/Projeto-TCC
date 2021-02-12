<?php
namespace src\models;
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
        $sql->bindValue(1, $pl['pl']);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch();
        }

        return false;
   
    }

}