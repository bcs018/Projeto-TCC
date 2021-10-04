<?php 

namespace src\models\sitePrincipal;
use \core\Model;
use \src\models\sitePrincipal\Plano;

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
        $sql = "SELECT * FROM ecommerce_usu eu
                JOIN ecom_usua ecu
                ON eu.ecommerce_id = ecu.ecommerce_id
                JOIN usuario u 
                ON u.usuario_id = ecu.usuario_id
                WHERE u.usuario_id = ?";
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
        
        $not = new Notificacao;

        $not->gravaNotificacao($idPlano['ecommerce_id'], 'Novo cliente cadastrado em sua loja!', '', $idPlano['sub_dominio']);

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

    public function atualizaStatus($idCompra, $status, $ativo){
        $sql = "UPDATE assinatura SET status_pagamento = ? WHERE assinatura_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $status);
        $sql->bindValue(2, $idCompra);
        $sql->execute();

        $sql = "SELECT * FROM assinatura WHERE assinatura_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $idCompra);
        $sql->execute();

        $idUsu = $sql->fetch();

        $sql = "UPDATE usuario SET ativo = ? WHERE usuario_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $ativo);
        $sql->bindValue(2, $idUsu['usuario_id']);
        $sql->execute();
    }

    public function salvarLinkBoleto($link, $id){
        $sql = "INSERT INTO boleto (assinatura_id, link_boleto) VALUES (?,?)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->bindValue(2, $link);
        $sql->execute();
    }

    public function pegarBoleto($id){
        $sql = "SELECT * FROM boleto WHERE assinatura_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();

        return $sql->fetch();
    }

}