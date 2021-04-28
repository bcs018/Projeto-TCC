<?php
namespace src\models;
use \core\Model;

class SelecionaSite extends Model{

    public function listaSubDominio($sub){
        $sql = "SELECT * FROM ecommerce_usu
                WHERE sub_dominio = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $sub);
        $sql->execute();

        if($sql->rowCount() == 0){
            return 0;
        }

        return $sql->fetch();
    }

}