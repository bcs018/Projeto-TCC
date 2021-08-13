<?php 

namespace src\models\commerce;

use \core\Model;
use \src\models\commerce\Carrinho;

class Info extends Model{

    // Pega todas as informações do site do ecommerce definido na url
    public function pegaDadosCommerce($sub){
        $sql = "SELECT * FROM ecommerce_usu WHERE sub_dominio = ?";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(1, $sub);
        $sql->execute();

        if($sql->rowCount() > 0){
            return $sql->fetch();
        }

        return false;
    }

    // Função feita nesse controller porque é usado no header
    // Retorna o subtotal dos itens do carrinho
    public function somaValor(){
        if(isset($_SESSION['carrinho'])){
            $carr = new Carrinho;

            $produtos = $carr->listaItens($_SESSION['carrinho']);

            $subtotal = 0;

            foreach($produtos as $item){
                $subtotal += ((floatval($item['preco'])) * $_SESSION['carrinho'][$item[0]]);
            }

            return $subtotal;
        }
    }

}