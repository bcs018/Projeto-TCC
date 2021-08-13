<?php 

namespace src\models\commerce;

use \core\Model;
use \src\models\commerce\Produto;


class Carrinho extends Model{

    public function listaItens($carrinho){
        $prod = new Produto;
        $produtos = [];

        foreach($carrinho as $id => $qt){
            $produtos[] = current($prod->listaProduto($id));
        }

       return $produtos;
    }

}