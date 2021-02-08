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

}