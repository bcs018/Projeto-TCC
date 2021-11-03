<?php 

namespace src\models\commerce;

use \core\Model;
use src\models\sitePrincipal\Email;

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
                WHERE c.ecommerce_id = ? AND c.enviado = ? AND (c.status_pagamento = ? OR  c.status_pagamento = ?)
                GROUP BY c.compra_id;";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, '0');
        $sql->bindValue(3, 'paid');
        $sql->bindValue(4, 'settled');
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

    public function marcarEnviado($id, $enviado, $cod_ras){
        $sql = "UPDATE compra SET enviado = ?, cod_rastreio = ? WHERE compra_id = ? AND ecommerce_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $enviado);
        $sql->bindValue(2, $cod_ras);
        $sql->bindValue(3, $id);
        $sql->bindValue(4, $_SESSION['id_sub_dom']);
        $sql->execute();

        $sql = "SELECT * FROM compra c
                JOIN usuario_ecommerce ue
                ON c.usuario_id = ue.ue_id
                JOIN ecommerce_usu eu
                ON c.ecommerce_id = eu.ecommerce_id
                where c.compra_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        $sql = $sql->fetch();

        $mail = new Email;

        $mail->enviarEmail($sql['nome_fantasia'], $sql['email_ue'], 'Compra n° '.$sql['compra_id'].' enviada', $sql['nome_usu_ue'].' sua compra '.$sql['compra_id'].' acabou de ser despachada pelo vendedor!');
    }
}