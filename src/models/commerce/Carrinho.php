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
        //echo '<pre>';print_r($dadosProd);
        $nVlPeso = 0;
        $nVlComprimento = 0;
        $nVlAltura = 0;
        $nVlLargura = 0;
        $nVlDiametro = 0;
        $nVlValorDeclarado = 0;

        foreach($dadosProd as $item){
            $nVlPeso += floatval($item['peso']);
            $nVlComprimento += floatval($item['comprimento']);
            $nVlAltura += floatval($item['altura']);
            $nVlLargura += floatval($item['largura']);
            $nVlDiametro += floatval(($item['diametro']));
            $nVlValorDeclarado += floatval($item['preco']);  // Colocar Vezes a quantidade
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

        //echo $nVlValorDeclarado;

        // $data = [
        //     // Tipo de envio, PAC = 41106, Sedex = 40010....
        //     'nCdEmpresa' => '',
        //     'sDsSenha' => '',
        //     'nCdServico' => '04014',
        //     'sCepOrigem' => $cepOrigem,
        //     'sCepDestino' => $cepDestino,
        //     'nVlPeso'     => $nVlPeso,
        //     'nCdFormato'  => 1,
        //     'nVlComprimento' => $nVlComprimento,
        //     'nVlAltura' => $nVlAltura,
        //     'nVlLargura' => $nVlLargura,
        //     'nVlDiametro' => $nVlDiametro,
        //     'sCdMaoPropria' => 'n',
        //     'nVlValorDeclarado' => 0,
        //     'sCdAvisoRecebimento' => 'n'
        //     //'StrRetorno' => 'xml'
        // ];

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

        //echo $r;exit;
        echo $cepOrigem.'<br>';
        echo $cepDestino.'<br>';
        echo $nVlPeso.'<br>';
        echo $nVlComprimento.'<br>';
        echo $nVlAltura.'<br>';
        echo $nVlLargura.'<br>';
        echo $nVlDiametro.'<br>';exit;


        $array['preco'] = current($r->cServico->Valor);
        $array['data'] = current($r->cServico->PrazoEntrega);
        //$array['erro'] = current($r->cServico->Erro);

        return $array;
    }

}