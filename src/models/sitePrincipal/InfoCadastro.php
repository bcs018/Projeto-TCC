<?php 

namespace src\models\sitePrincipal;
use \core\Model;

class InfoCadastro extends Model{
    public function listaDadosUsuario($id){
        $sql = "SELECT * FROM usuario WHERE usuario_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        return $sql->fetch();
    }

    public function listaDadosPlano($id){
        $sql = "SELECT e.ecommerce_id, e.usuario_id, e.plano_id, e.sub_dominio, e.nome_fantasia, p.nome_plano, p.descricao_plano, p.preco, p.plano_id 
                FROM ecommerce_usu  e
                LEFT JOIN plano p 
                ON e.plano_id = p.plano_id
                WHERE e.usuario_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        return $sql->fetch(); 
    }
}