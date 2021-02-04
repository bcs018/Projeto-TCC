<?php 

namespace src\models;
use \core\Model;

class Cadastro extends Model{

    public function lista_estados(){
        $sql = "SELECT * FROM estado";
        $sql = $this->db->query($sql)->fetchAll();

        return $sql;
    }

    public function inserir_cad($POST){
        /**
         * Validação dos dados enviado do usuário
         */

        $flag = false;

        $POST['nome_usu']       = filter_var($POST['nome_usu'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['sobrenome_usu']  = filter_var($POST['sobrenome_usu'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['celular']        = filter_var($POST['celular'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['data_nasc']      = filter_var($POST['data_nasc'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['rua_usu']        = filter_var($POST['rua_usu'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['bairro_usu']     = filter_var($POST['bairro_usu'], FILTER_SANITIZE_SPECIAL_CHARS);
        $POST['cep_usu']        = explode("-", $POST['cep_usu']); 
        $POST['cep_usu']        = $POST['cep_usu'][0].$POST['cep_usu'][1];
        $POST['subdominio']     = strip_tags($POST['subdominio']);
        $POST['nome_fan']       = filter_var($POST['nome_fan'], FILTER_SANITIZE_SPECIAL_CHARS);
        
        if(!$this->validaCpf($POST['cpf_usu'])){
           $_SESSION['error'][] = '<div class="alert alert-danger" role="alert">
                                    CPF inválido!
                                  </div>';
            $flag = true;
        }

        if(!filter_var($POST['estado_usu'], FILTER_VALIDATE_INT) || ($POST['estado_usu'] < 1 || $POST['estado_usu'] > 27)){
            $_SESSION['error'][] = '<div class="alert alert-danger" role="alert">
                                      Estado inválido!
                                    </div>';
            $flag = true;
        }

        if(!filter_var($POST['cep_usu'], FILTER_VALIDATE_INT)){
            $_SESSION['error'][] = '<div class="alert alert-danger" role="alert">
                                        CEP inválido!
                                    </div>';
            $flag = true;
        }

        if(!filter_var($POST['num_usu'], FILTER_VALIDATE_INT)){
            $_SESSION['error'][] = '<div class="alert alert-danger" role="alert">
                                      Número inválido!
                                   </div>';
            $flag = true;
        }
                   
        if(!filter_var($POST['email_usu'], FILTER_VALIDATE_EMAIL)){
            $_SESSION['error'][] = '<div class="alert alert-danger" role="alert">
                                       E-mail inválido!
                                   </div>';
            $flag = true;
        }

        //Verificar esse IF ou a função de verificação de CNPJ
        if(!empty($POST['cnpj']) || isset($POST['cnpj'])){
            if(!$this->validaCnpj($POST['cnpj'])){
                $_SESSION['error'][] = '<div class="alert alert-danger" role="alert">
                                        CNPJ inválido!
                                    </div>';
                $flag = true;
            }
        }

        /**
         * Fim da validação
         */

        return $flag;


    }

    private function validaCpf($cpf){
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
        
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    private function validaCnpj($cnpj){
        $num=0;
        $j=0;
			for($i=0; $i<(strlen($cnpj)); $i++)
				{
					if(is_numeric($cnpj[$i]))
						{
							$num[$j]=$cnpj[$i];
							$j++;
						}
				}
			//Etapa 2: Conta os dígitos, um Cnpj válido possui 14 dígitos numéricos.
			if(count($num)!=14)
				{
					$isCnpjValid=false;
				}
			//Etapa 3: O número 00000000000 embora não seja um cnpj real resultaria um cnpj válido após o calculo dos dígitos verificares e por isso precisa ser filtradas nesta etapa.
			if ($num[0]==0 && $num[1]==0 && $num[2]==0 && $num[3]==0 && $num[4]==0 && $num[5]==0 && $num[6]==0 && $num[7]==0 && $num[8]==0 && $num[9]==0 && $num[10]==0 && $num[11]==0)
				{
					$isCnpjValid=false;
				}
			//Etapa 4: Calcula e compara o primeiro dígito verificador.
			else
				{
					$j=5;
					for($i=0; $i<4; $i++)
						{
							$multiplica[$i]=$num[$i]*$j;
							$j--;
						}
					$soma = array_sum($multiplica);
					$j=9;
					for($i=4; $i<12; $i++)
						{
							$multiplica[$i]=$num[$i]*$j;
							$j--;
						}
					$soma = array_sum($multiplica);	
					$resto = $soma%11;			
					if($resto<2)
						{
							$dg=0;
						}
					else
						{
							$dg=11-$resto;
						}
					if($dg!=$num[12])
						{
							$isCnpjValid=false;
						} 
				}
			//Etapa 5: Calcula e compara o segundo dígito verificador.
			if(!isset($isCnpjValid))
				{
					$j=6;
					for($i=0; $i<5; $i++)
						{
							$multiplica[$i]=$num[$i]*$j;
							$j--;
						}
					$soma = array_sum($multiplica);
					$j=9;
					for($i=5; $i<13; $i++)
						{
							$multiplica[$i]=$num[$i]*$j;
							$j--;
						}
					$soma = array_sum($multiplica);	
					$resto = $soma%11;			
					if($resto<2)
						{
							$dg=0;
						}
					else
						{
							$dg=11-$resto;
						}
					if($dg!=$num[13])
						{
							$isCnpjValid=false;
						}
					else
						{
							$isCnpjValid=true;
						}
				}
			//Etapa 6: Retorna o Resultado em um valor booleano.
			return $isCnpjValid;		
    }

}
