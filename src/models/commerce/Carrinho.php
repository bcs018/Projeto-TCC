<?php 

namespace src\models\commerce;

use \core\Model;
use \src\models\commerce\Produto;
use \src\models\commerce\Categoria;

class Carrinho extends Model{

    public function listaItens($carrinho){
        $prod = new Produto;

        foreach($carrinho as $id => $qt){
            $produtos[] = current($prod->listaProduto($id));
        }

       return $produtos;
    }

}