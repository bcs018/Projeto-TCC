<?php 

namespace src\models\commerce;

use \core\Model;
use \src\models\commerce\Info;

/**
 * Classe de configuração do PagSeguro
 */

class Pesquisa extends Model{
    public function pesquisa($txt){
        $sql = "SELECT p.produto_id, p.nome_pro, p.ecommerce_id, p.preco, p.preco_antigo, p.banner_img, pi.pi_id, pi.produto_id, pi.url FROM produto p 
                LEFT JOIN produto_imagem pi
                ON pi.produto_id = p.produto_id
                WHERE p.ecommerce_id = ?  AND p.ativo = ? and nome_pro LIKE ? ORDER BY p.produto_id asc;";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $_SESSION['id_sub_dom']);
        $sql->bindValue(2, '1');
        $sql->bindValue(3, '%'.$txt.'%');
        $sql->execute();
        
        if($sql->rowCount() > 0){
            $produtos = $sql->fetchAll();
            $produtosNovo = array();
            $i = null;

            foreach($produtos as $p){
                // Colocando o p[0] porque nao está vindo o id no primeiro array
                if($i != $p[0]){
                    $i = $p[0];
                    $produtosNovo[] = $p;
                }
            }

            return $produtosNovo;
        }

        $_SESSION['message'] = '<div class="alert alert-info" role="alert">
                                    Não há produtos relacionado com essa pesquisa: '.$txt.'
                                </div>';

        return false;
        
    }
}