<?php 

namespace src\models\commerce;

use \core\Model;

class Compra extends Model{

    public function addCompra($tp_pagamento){
        $sql = 'INSERT INTO compra (usuario_id, cupom_id, ecommerce_id, total_compra, tipo_pagamento, status_pagamanto)
                VALUES (?,?,?,?,?,?)';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['login_cliente_ecommerce']);
        $sql->bindValue(2, 1);
        $sql->bindValue(3, $_SESSION['id_sub_dom']);
        $sql->bindValue(4, $_SESSION['total']);
        $sql->bindValue(5, $tp_pagamento);
        $sql->bindValue(6, '0');
        
        if($sql->execute()){
            $id_compra = $this->db->lastInsertId();

            $sql = 'INSERT INTO transacao_compra (compra_id, valor_pago, cod_transacao)
            VALUES (?,?,?)';
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $id_compra);
            $sql->bindValue(2, $_SESSION['total']);
            $sql->bindValue(3, $id_compra);

            if($sql->execute()){
                return $id_compra;
            }
        }

        return false;
    }

    public function delCompra($id){
        $sql = 'DELETE FROM compra WHERE compra_id = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        
        if($sql->execute()){
            $sql = 'DELETE FROM transacao_compra WHERE compra_id = ?';
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $id);

            if($sql->execute()){
                return true;
            }
        }

        return false;
    }

}