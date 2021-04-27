<?php 

namespace src\models;
use \core\Model;
use \src\models\Plano;

class Assinatura extends Model{

    public function inserirAss($POST = 0){
        if($POST != 0){
            $id_transacao = filter_var($POST['id'], FILTER_SANITIZE_SPECIAL_CHARS);
            $tp_pgm = 'pagsegurockttransparente';
        }else{
            $id_transacao = null;
            $tp_pgm = 'boleto';
        }

        $id_usu = $_SESSION['person']['id'];

        if(isset($POST['cupom']) && !empty($POST['cupom'])){
            $cupom = filter_var($POST['cupom'], FILTER_SANITIZE_SPECIAL_CHARS);
        }else{
            $cupom = null;
        }
        $statusPgm = 1;

        //Pegar o valor do plano fazendo select na tabela de ecommerce
        $sql = "SELECT * FROM ecommerce_usu WHERE usuario_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['person']['id']);
        $sql->execute();

        $idPlano = $sql->fetch();

        $pl  = new Plano;
        $usu = new Cadastro;

        $plano   = $pl->pegarItem($idPlano['plano_id']);
        $usuario = $usu->pegarItem($_SESSION['person']['id']);

        if(empty($plano)){
            echo json_encode(['error'=>1, 'message'=>'Existe dados inválidos, atualize a página e tente novamente!']);
            exit;
        }

        $ddd = substr($usuario['celular'], 1, 2);
        $celular = substr($usuario['celular'], 4, 5);
        $celular .= substr($usuario['celular'], 10, 4);

        $sql = "SELECT * FROM estado WHERE estado_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $usuario['estado_id']);
        $sql->execute();

        $estado = $sql->fetch();

        //VALIDAR O CUPOM DE DESCONTO POSTERIORMENTE

        //Inserindo os dados na tabela de assinaturas
        $sql = "INSERT INTO assinatura (usuario_id, cupom_id, valor_total, tipo_pagamento, status_pagamento, cod_transacao, data_transacao, hora_transacao)
                VALUES (?,?,?,?,?,?,?,?)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id_usu);
        $sql->bindValue(2, $cupom);
        $sql->bindValue(3, $plano['preco']);
        $sql->bindValue(4, $tp_pgm);
        $sql->bindValue(5, $statusPgm);
        $sql->bindValue(6, $id_transacao);
        $sql->bindValue(7, date("Y/m/d"));
        $sql->bindValue(8, date("H:i:s"));
        $sql->execute();


        //echo "Id_usu: ".gettype($id_usu). " Cupom: ". $cupom. " Preco plano: ".gettype(floatval($plano['preco'])). " Tp pgm: ".gettype($tp_pgm). " StatusPgm: ".$statusPgm. " Id_transacao: ".$id_transacao;exit;
        
        $dados = [
                    'id_plano'     => $idPlano['plano_id'], 
                    'nome_plano'   => $plano['nome_plano'],
                    'id_assinatura'=> $this->db->lastInsertId(),
                    'preco'        => $plano['preco'],

                    'nome_cli'     => $usuario['nome']." ".$usuario['sobrenome'],
                    'email'        => $usuario['email'],
                    'cpf'          => $usuario['cpf'],
                    'ddd'          => $ddd,
                    'celular'      => $celular,
                    'rua'          => $usuario['rua']  ,
                    'numero'       => $usuario['numero'],
                    'bairro'       => $usuario['bairro'],
                    'cep'          => $usuario['cep'],
                    'cidade'       => $usuario['cidade'],
                    'estado'       => $estado['nome_estado'], 
                    'complemento'  => $usuario['complemento']
                ];

        return $dados;
    }

    public function pegarItem($id){
        $sql = "SELECT * FROM assinatura WHERE usuario_id = ? 
                ORDER BY assinatura_id DESC LIMIT 1";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        if($sql->rowCount() == 0){
            return false;
        }

        return $sql->fetch();
    }

    public function pegarItensValidos($id){
        $sql = "SELECT * FROM assinatura WHERE usuario_id = ?
                AND status_pagamento IN(1,2,3,4)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        }

        return false;
    }

    public function pegarItemAss($id){
        $sql = "SELECT * FROM assinatura WHERE assinatura_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        if($sql->rowCount() == 0){
            return false;
        }

        return $sql->fetch();
    }

    public function excluirItem($id){
        $sql = "DELETE FROM assinatura WHERE assinatura_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
    }

    public function aprovarCompra($id){
        /**
        * Status
        * 1 - Aguardando pagamento
        * 2 - Em analise - Paga mas n foi aprovado de cara
        * 3 - Paga
        * 4 - Disponivel - Disponivel para saque
        * 5 - Em disputa
        * 6 - Dinheiro foi devolvido
        * 7 - Compra cancelada
        * 8 - Debitado - Dinheiro daquela compra foi devolvida na disputa
        * 9 - Retenção temporaria - Quando o cara liga para o cartão e fala que nao reconhece a compra
        */
        $sql = "UPDATE assinatura SET status_pagamento = ? WHERE assinatura_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, 3);
        $sql->bindValue(2, $id);
        $sql->execute();

        $sql = "SELECT * FROM assinatura WHERE assinatura_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        $idUsu = $sql->fetch();

        $sql = "UPDATE usuario SET ativo = ? WHERE usuario_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, 1);
        $sql->bindValue(2, $idUsu['usuario_id']);
        $sql->execute();
    }

    public function bloquearCompra($id){
        $sql = "UPDATE assinatura SET status_pagamento = ? WHERE assinatura_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, 0);
        $sql->bindValue(2, $id);
        $sql->execute();

        $sql = "SELECT * FROM assinatura WHERE assinatura_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        $idUsu = $sql->fetch();

        $sql = "UPDATE usuario SET ativo = ? WHERE usuario_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, 0);
        $sql->bindValue(2, $idUsu['usuario_id']);
        $sql->execute();
    }

    public function analiseCompra($id){
        $sql = "UPDATE assinatura SET status_pagamento = ? WHERE assinatura_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, 2);
        $sql->bindValue(2, $id);
        $sql->execute();

        $sql = "SELECT * FROM assinatura WHERE assinatura_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        $idUsu = $sql->fetch();

        $sql = "UPDATE usuario SET ativo = ? WHERE usuario_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, 0);
        $sql->bindValue(2, $idUsu['usuario_id']);
        $sql->execute();
    }

    public function salvarLinkBoleto($link, $id){
        $sql = "UPDATE assinatura SET link_bol = ? WHERE assinatura_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $link);
        $sql->bindValue(2, $id);
        $sql->execute();
    }

}