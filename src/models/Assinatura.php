<?php 

namespace src\models;
use \core\Model;
use \src\models\Plano;

class Assinatura extends Model{

    public function inserirAss($POST){
        $id_transacao = filter_var($POST['id'], FILTER_SANITIZE_SPECIAL_CHARS);
        $id_usu = $_SESSION['person']['id'];
        if(isset($POST['cupom'])){
            $cupom = '';
        }else{
            $cupom = filter_var($POST['cupom'], FILTER_SANITIZE_SPECIAL_CHARS);
        }
        $tp_pgm = 'pagsegurockttransparente';
        $statusPgm = 0;

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

        //VALIDAR O CUPOM DE DESCONTO POSTERIORMENTE

        //Inserindo os dados na tabela de assinaturas
        $sql = "INSERT INTO assinatura (usuario_id, cupom_id, valor_total, tipo_pagamento, status_pagamento, cod_transacao)
                VALUES (?,?,?,?,?,?)";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $id_usu);
        $sql->bindValue(2, $cupom);
        $sql->bindValue(3, $plano['preco']);
        $sql->bindValue(4, $tp_pgm);
        $sql->bindValue(5, $statusPgm);
        $sql->bindValue(6, $id_transacao);
        $sql->execute();

        $ddd = substr($usuario['celular'], 1, 2);
        $celular = substr($usuario['celular'], 4, 5);
        $celular .= substr($usuario['celular'], 10, 4);

        $sql = "SELECT * FROM estado WHERE estado_id = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $usuario['estado_id']);
        $sql->execute();

        $estado = $sql->fetch();
        
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

}