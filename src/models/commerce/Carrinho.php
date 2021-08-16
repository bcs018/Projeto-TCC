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

    public function calculaFrete($cepDestino, $cepOrigem){
        $array = [
            'preco' => 0,
            'data'  => ''
        ];

        $dadosProd = $this->listaItens($_SESSION['carrinho']);

        $nVlPeso = 0;
        $nVlComprimento = 0;
        $nVlAltura = 0;
        $nVlLargura = 0;
        $nVlDiametro = 0;
        $nVlValorDeclarado = 0;

        foreach($dadosProd as $item){
            $nVlPeso += floatval($dadosProd['peso']);
            $nVlComprimento += floatval($dadosProd['comprimento']);
            $nVlAltura += floatval($dadosProd['altura']);
            $nVlLargura += floatval($dadosProd['largura']);
            $nVlDiametro += floatval(($dadosProd['diametro']));
            $nVlValorDeclarado += floatval($dadosProd['preco']);  // Colocar Vezes a quantidade
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
            // Tipo de envio, PAC = 41106, Sedex = 40010....
            'nCdServico' => '40010',
            'sCepOrigem' => $cepOrigem,
            'sCepDestino' => $cepDestino,
            'nVlPeso'     => $nVlPeso,
            'nCdFormato'  => '1',
            'nVlComprimento' => $nVlComprimento,
            'nVlAltura' => $nVlAltura,
            'nVlLargura' => $nVlLargura,
            'nVlDiametro' => $nVlDiametro,
            'sCdmaoPropria' => 'N',
            'nVlValorDeclarado' => $nVlValorDeclarado,
            'sCdAvisoRecebimento' => 'N',
            'StrRetorno' => 'xml'
        ];

        $url = 'http://ws.correios.com.br/calculador/CalcPrecoprazo.aspx';
        $data = http_build_query($data);

        $ch = curl_init($url.'?'.$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $r = curl_exec($ch);
        $r = simplexml_load_string($r);

        $array['preco'] = current($r->cServico->Valor);
        $array['data'] = current($r->cServico->PrazoEntrega);

        return $array;
    }

}