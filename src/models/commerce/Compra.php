<?php 

namespace src\models\commerce;

use \core\Model;

class Compra extends Model{

    public function addCompra($tp_pagamento, $parc){
        $sql = 'INSERT INTO compra (usuario_id, cupom_id, ecommerce_id, total_compra, subtotal_compra, frete_compra, tipo_pagamento, status_pagamanto, cep_entrega, rua_entrega, bairro_entrega, numero_entrega, estado_entrega, cidade_entrega, complemento_entrega)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['login_cliente_ecommerce']);
        $sql->bindValue(2, 1);
        $sql->bindValue(3, $_SESSION['id_sub_dom']);
        $sql->bindValue(4, $_SESSION['total']);
        $sql->bindValue(5, $_SESSION['subtotal']);
        $sql->bindValue(6, floatval(str_replace(',','.',$_SESSION['frete']['preco'])));
        $sql->bindValue(7, $tp_pagamento);
        $sql->bindValue(8, '0');
        $sql->bindValue(9, $_SESSION['dados_entrega']['cep']);
        $sql->bindValue(10, $_SESSION['dados_entrega']['rua']);
        $sql->bindValue(11, $_SESSION['dados_entrega']['bairro']);
        $sql->bindValue(12, $_SESSION['dados_entrega']['numero']);
        $sql->bindValue(13, $_SESSION['dados_entrega']['estado']);
        $sql->bindValue(14, $_SESSION['dados_entrega']['cidade']);
        $sql->bindValue(15,(isset($_SESSION['dados_entrega']['complemento'])?$_SESSION['dados_entrega']['complemento']:''));
        
        if($sql->execute()){
            $id_compra = $this->db->lastInsertId();

            $sql = 'INSERT INTO transacao_compra (compra_id, valor_pago, cod_transacao, parcela)
                    VALUES (?,?,?,?)';
            $sql = $this->db->prepare($sql);
            $sql->bindValue(1, $id_compra);
            $sql->bindValue(2, $_SESSION['total']);
            $sql->bindValue(3, $id_compra);
            $sql->bindValue(4, $parc[0].'x de R$'.number_format($parc[1]),2,',','.');

            if($sql->execute()){
                unset($_SESSION['dados_entrega']);
                unset($_SESSION['total']);
                unset($_SESSION['subtotal']);
                unset($_SESSION['frete']);

                foreach($_SESSION['carrinho'] as $key => $c){
                    $sql = 'INSERT INTO compra_prod (produto_id, compra_id, quantidade)
                            VALUES (?,?,?)';
                    $sql = $this->db->prepare($sql);
                    $sql->bindValue(1, $key);
                    $sql->bindValue(2, $id_compra);
                    $sql->bindValue(3, $c);
                    $sql->execute();
                }
                unset($_SESSION['carrinho']);
                
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

    public function listaCompra($id){
        $sql = 'SELECT * FROM compra c
                JOIN transacao_compra tc
                ON c.compra_id = tc.compra_id
                WHERE c.compra_id = ? AND c.ecommerce_id = ? AND c.usuario_id = ?';
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->bindValue(2, $_SESSION['id_sub_dom']);
        $sql->bindValue(3, $_SESSION['login_cliente_ecommerce']);
        
        if($sql->execute()){
            return $sql->fetch();
        }

        $_SESSION['message'] = '<div class="alert alert-danger" role="alert">
                                    Algo aconteceu de errado, compra inexistente!
                                </div>';
        return false;

}

}