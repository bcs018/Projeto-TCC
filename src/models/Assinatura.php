<?php 

namespace src\models;
use \core\Model;

class Assinatura extends Model{

    public function inserirAss($POST){
        $id_transacao = filter_var($POST['id'], FILTER_SANITIZE_SPECIAL_CHARS);
        $id_usu = $_SESSION['person']['id'];
        $cupom = filter_var($POST['cupom'], FILTER_SANITIZE_SPECIAL_CHARS);
        $tp_pgm = 'pagsegurockttransparente';
        $statusPgm = 0;

        //Pegar o valor do plano fazendo select na tabela de ecommerce
        $sql = "SELECT * FROM ecommerce_usu WHERE usuario_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['person']['id']);
        $sql->execute();

        $idPlano = $sql->fetch();

        //Fazendo consulta no plano para saber o valor
        $sql = "SELECT preco FROM plano WHERE plano_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $idPlano['plano_id']);
        $sql->execute();

        if($sql->rowCount() == 0){
            echo json_encode(['error'=>1, 'message'=>'Existe dados inválidos, atualize a página e tente novamente!']);
            exit;
        }

        $valor_tot = $sql->fetch();

        if(!isset($cupom)){
            $cupom = '';
        }
        //VALIDAR O CUPOM DE DESCONTO POSTERIORMENTE

        //Inserindo os dados na tabela de assinaturas
        $sql = "INSERT INTO assinatura (usuario_id, cupom_id, valor_total, tipo_pagamento, status_pagamento, cod_transacao)
                VALUES (?,?,?,?,?,?)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id_usu);
        $sql->bindValue(2, $cupom);
        $sql->bindValue(3, $valor_tot['preco']);
        $sql->bindValue(4, $tp_pgm);
        $sql->bindValue(5, $statusPgm);
        $sql->bindValue(6, $id_transacao);
        $sql->execute();

        echo json_encode(['error'=>0, 'message'=>'Pagamento realizado com secesso!']);
        exit;
    }

}