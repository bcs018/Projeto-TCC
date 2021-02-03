<?php 

namespace src\models;
use \core\Model;

class Cadastro extends Model{

    public function lista_estados(){
        $sql = "SELECT * FROM estado";
        $sql = $this->db->query($sql)->fetchAll();

        return $sql;
    }

}
