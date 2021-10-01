<?php 

namespace src\models\commerce;

use \core\Model;

class Venda extends Model{
    public function listaVendasPendentes(){
        $sql = "SELECT * FROM compra c
                JOIN compra_prod cp
                ON c.compra_id = cp.compra_id
                JOIN produto p 
                ON p.produto_id = cp.produto_id 
                JOIN usuario_ecommerce ue 
                ON c.usuario_id = ue.ue_id
                JOIN transacao_compra tc
                ON tc.compra_id = c.compra_id
                WHERE c.ecommerce_id = ? AND c.enviado = ? AND (c.status_pagamento = ? OR c.status_pagamento = ?)
                GROUP BY c.compra_id;";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, '0');
        $sql->bindValue(3, 'approved');
        $sql->bindValue(4, '3');
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll();
        }

        return 0;
    }

    public function listaVendaPendente($id){
        $sql = "SELECT * FROM compra c
                JOIN compra_prod cp
                ON c.compra_id = cp.compra_id
                JOIN produto p 
                ON p.produto_id = cp.produto_id 
                JOIN usuario_ecommerce ue 
                ON c.usuario_id = ue.ue_id
                JOIN transacao_compra tc
                ON tc.compra_id = c.compra_id
                WHERE c.ecommerce_id = ? AND c.compra_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetchAll();
        }

        return 0;
    }

    public function marcarEnviado($id, $enviado){
        $sql = "UPDATE compra SET enviado = ? WHERE compra_id = ? AND ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $enviado);
        $sql->bindValue(2, $id);
        $sql->bindValue(3, $_SESSION['id_sub_dom']);
        $sql->execute();
    }
}