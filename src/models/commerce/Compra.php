<?php 

namespace src\models\commerce;

use \core\Model;

class Compra extends Model{

    public function inserirCompra($tp_pagamento){
        $sql = 'INSERT INTO compra (usuario_id, cupom_id, ecommerce_id, total_compra, tipo_pagamento, status_pagamanto)
                VALUES (?,?,?,?,?,?)';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['login_cliente_ecommerce']);
        $sql->bindValue(2, '0');
        $sql->bindValue(3, $_SESSION['id_sub_dom']);
        $sql->bindValue(4, $_SESSION['total']);
        $sql->bindValue(5, $tp_pagamento);
        $sql->bindValue(6, 0);
        $sql->execute( );

        return $this->db->lastInsertId();
    }

}