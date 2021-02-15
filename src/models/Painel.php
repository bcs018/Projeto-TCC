<?php 

namespace src\models;
use \core\Model;

class Painel extends Model{
    public function listaDadosUsuario($id){
        $sql = "SELECT * FROM usuario WHERE usuario_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        return $sql->fetch();
    }

    public function listaDadosPlano($id){
        $sql = "SELECT * FROM ecommerce_usu WHERE usuario_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        'select e.ecommerce_id, e.usuario_id, e.plano_id, e.sub_dominio, e.nome_fantasia, p.nome_plano, p.descricao_plano, p.preco 
        from ecommerce_usu  e
        left join plano p 
        on e.plano_id = p.plano_id;'

        return $sql->fetch();
    }
}