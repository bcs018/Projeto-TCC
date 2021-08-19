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

    public function calculaFrete($cepDestino, $cepOrigem, $id=0){
        $array = [
            'preco' => 0,
            'data'  => ''
        ];

        $nVlPeso = 0;
        $nVlComprimento = 0;
        $nVlAltura = 0;
        $nVlLargura = 0;
        $nVlDiametro = 0;
        $nVlValorDeclarado = 0;

        if($id != 0){
            $prod = new Produto;
            $dadosProd = $prod->listaProduto($id);

            $nVlPeso = $dadosProd[0]['peso'];
            $nVlComprimento = $dadosProd[0]['comprimento'];
            $nVlAltura = $dadosProd[0]['altura'];
            $nVlLargura = $dadosProd[0]['largura'];
            $nVlDiametro = $dadosProd[0]['diametro'];
            $nVlValorDeclarado = 0;
    
        }else{

            $dadosProd = $this->listaItens($_SESSION['carrinho']);
            //echo '<pre>';print_r($dadosProd);

            foreach($dadosProd as $item){
                $nVlPeso += floatval($item['peso']);
                $nVlComprimento += floatval($item['comprimento']);
                $nVlAltura += floatval($item['altura']);
                $nVlLargura += floatval($item['largura']);
                $nVlDiametro += floatval(($item['diametro']));
                $nVlValorDeclarado += 0; //floatval($item['preco']) * $_SESSION['carrinho'][$item[0]];  // Colocar Vezes a quantidade
            }
        }

        $soma = $nVlComprimento + $nVlAltura + $nVlLargura;
        if($soma > 200){
            $nVlComprimento = 66;
            $nVlAltura = 66;
            $nVlLargura = 66;
        }

        if($nVlDiametro > 90){
            $nVlDiametro = 90;
        }

        if($nVlPeso > 40){
            $nVlPeso = 40;
        }

        $data = [
            'sCepOrigem'			=> $cepOrigem,
            'sCepDestino'			=> $cepDestino,
            'nVlPeso'				=> $nVlPeso,
            'nCdFormato'			=> 1,
            'nVlComprimento'		=> $nVlComprimento,
            'nVlAltura'			    => $nVlAltura,
            'nVlLargura'			=> $nVlLargura,
            'sCdMaoPropria'		    => 'n',
            'nVlValorDeclarado'	    => 0,
            'sCdAvisoRecebimento'	=> 'n',
            'nCdServico'			=> '04510',
            'nVlDiametro'			=> $nVlDiametro,
            'StrRetorno'			=> 'xml'
        ];

        //$url = 'http://ws.correios.com.br/calculador/CalcPrecoprazo.aspx';
        $url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';

        $data = http_build_query($data);

        $ch = curl_init($url.'?'.$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $r = curl_exec($ch);

        $r = simplexml_load_string($r);

        $array['preco'] = current($r->cServico->Valor);
        $array['data'] = current($r->cServico->PrazoEntrega);
        $array['cep'] = $cepDestino;
        $array['erro'] = current($r->cServico->Erro);
        $array['msgErro'] = current($r->cServico->MsgErro);

        return $array;
    }

    // Retorna o subtotal dos itens do carrinho
    public function somaValor(){
        if(isset($_SESSION['carrinho'])){
            $carr = new Carrinho;

            $produtos = $carr->listaItens($_SESSION['carrinho']);

            $dados['subtotal'] = 0;
            $dados['total'] = 0;

            foreach($produtos as $item){
                $dados['subtotal'] += ((floatval($item['preco'])) * $_SESSION['carrinho'][$item[0]]);
            }

            if(isset($_SESSION['frete'])){
                $dados['total'] = $dados['subtotal'] + floatval(str_replace(',','.',$_SESSION['frete']['preco']));
                //echo $_SESSION['frete']['preco'];
            }else{
                $dados['total'] = $dados['subtotal'];
            }

            $dados['total'] = number_format($dados['total'], 2, ',','.');
            $dados['subtotal'] = number_format($dados['subtotal'], 2, ',','.');

            return $dados;
        }

        return false;
    }

}