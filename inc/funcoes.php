<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

function isEmail($eMailAddress) 
{
	if (preg_match("/^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,3}$/i", $eMailAddress, $check)) 
		return true;

	return false;
}

function isCnpj($cnpj) 
{
    $cnpj = preg_replace("@[./-]@", "", $cnpj);
    if (strlen($cnpj) <> 14 or !is_numeric($cnpj)) {
        return 0;
    }
    $j = 5;
    $k = 6;
    $soma1 = "";
    $soma2 = "";

    for ($i = 0; $i < 13; $i++) {
        $j = $j == 1 ? 9 : $j;
        $k = $k == 1 ? 9 : $k;
        $soma2 += ( $cnpj{$i} * $k);

        if ($i < 12) {
            $soma1 += ( $cnpj{$i} * $j);
        }
        $k--;
        $j--;
    }

    $digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
    $digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;

    return (($cnpj{12} == $digito1) and ($cnpj{13} == $digito2));
}

function isCpf($cpf)
{
	for( $i = 0; $i < 10; $i++ )
	{
		if ( $cpf ==  str_repeat( $i , 11) or !preg_match("@^[0-9]{11}$@", $cpf ) or $cpf == "12345678909" )
			return false;        
		if ( $i < 9 )
			$soma[]  = $cpf{$i} * ( 10 - $i );
			
		$soma2[] = $cpf{$i} * ( 11 - $i );            
	}
	if(((array_sum($soma)% 11) < 2 ? 0 : 11 - ( array_sum($soma)  % 11 )) != $cpf{9})
		return false;
		
	return ((( array_sum($soma2)% 11 ) < 2 ? 0 : 11 - ( array_sum($soma2) % 11 )) != $cpf{10}) ? false : true;
}	


function check_date($data) {
	list($dia, $mes, $ano) = explode("/", $data);
	
	if (ctype_digit($dia) and ctype_digit($mes) and ctype_digit($ano)) {
		return checkdate($mes, $dia, $ano);
	} else {
		return false;
	}
}

function isDate($data) {
	list($dia, $mes, $ano) = explode("/", $data);
	
	if (ctype_digit($dia) and ctype_digit($mes) and ctype_digit($ano)) {
		return checkdate($mes, $dia, $ano);
	} else {
		return false;
	}
	
	
}

//Transforma data no formato DD/MM/YYYY para YYYY-MM-DD
function dateToBd($data)
{
	if (!empty($data))
		$data = substr($data,6,4) . "-" . substr($data,3,2) . "-" . substr($data,0,2);
	else 
		$data = "";
	
	return $data;
}

//Transforma data no formato YYYY-MM-DD para DD/MM/YYYY
function bdToDate($data)
{
	if (!empty($data))
		if ($data <> "0000-00-00")
			$data = substr($data,8,2) . "/" . substr($data,5,2) . "/" . substr($data,0,4);
		else
			$data = "";
	else 
		$data = "";
	
	
	return $data;
}

//Transforma data no formato DD/MM/YYYY para YYYYMMDD
function dateToInt($data)
{
	if (!empty($data))
		$data = substr($data,6,4) . substr($data,3,2) . substr($data,0,2);
	else 
		$data = "";
	
	return $data;
}

//Transforma aniversario no formato DD/MM para MMDD
function niverToBd($niver)
{
	if (!empty($niver))
		$niver = substr($niver,3,2) . substr($niver,0,2);
	else 
		$niver = "";
	
	return $niver;
}

//Converte para maiúsculas o primeiro caractere de cada palavra fora os artigos listados abaixo.
function ucwords2 ($cadeia){ 
    $cadeia = ucwords(strtolower($cadeia)); 
    $min = array(0=>" a ", 1=>" e ", 2=>" o ", 3=>" da ", 4=>" de ", 5=>" do ", 6=>" das ", 7=>" dos ", 
                 8=>" ao ", 9=>" aos ", 10=>" às ", 11=>" é ", 12=>" à ", 13=>" em ", 14=> " no ",
                 ); 
    $mai = array(0=>" A ", 1=>" E ", 2=>" O ", 3=>" Da ", 4=>" De ", 5=>" Do ", 6=>" Das ", 7=>" Dos ", 
                 8=>" Ao ", 9=>" Aos ", 10=>" Às ", 11=>" É ", 12=>" À ", 13=>" Em ", 14=> " No ", 
                 ); 
                 
                 
    for ($i=0; $i<15; $i++){ 
        $cadeia = str_replace($mai[$i], $min[$i], $cadeia); 
    } 
    return $cadeia; 
}

//retorna string com destaque no valor de busca
//texto: o texto em que a busca procura
//busca: o valor ser procurado dentro de texto
function destacaBusca($texto,$busca) 
{
	$destbusca = "<b>$busca</b>";
	$retorno =  str_ireplace($busca, $destbusca, $texto);
	
	return $retorno;
}

/*redimensiona imagem proporcional a altura passada e retorna a largura redimensionada*/
function getLarguraImg($arquivo, $altura)
{
	list($width, $height) = getimagesize($dir."/".$nomefoto);
	
	$width = ($width*$altura)/$height;
	
	return $width;
}

/*Retorna se a(s) extensao(oes) passadas sao compativeis com o mime do arquivo
$extensoes - pode ser passado uma ou mais extensoes separadas por virgua e dentro de aspas. Ex: $extensoes = "'.pdf','.img'"
*/
function validaTipoArquivo($mime, $extensoes = "'.jpg','.png'")
{
	$sql = "select * from sis_mime where extensao in($extensoes) and mime = '$mime'";
	
	$rs = execQuery($sql);
	
	if(mysqli_num_rows($rs)>0)
		return true;
	else
		return false;
	
}



function getExtensaoArquivo($nomearquivo){
            $aux = explode(".",$nomearquivo);
            return $aux[sizeof($aux)-1];
        }

/*
* Smarty plugin
* -------------------------------------------------------------
* File: function.data.php
* Type: function
* Name: data
* Purpose: mostra data atual
* -------------------------------------------------------------
*/
function smarty_function_data($params, &$smarty)
{
	setlocale(LC_ALL, 'pt_BR');
	if ($params["mascara"]) {
		$mascara = $params["mascara"];
	} else {
		$ds = date("w");
		if ($ds != 0 and $ds != 6) {
			$mascara = "%A-feira, %d de %B de %Y";
		} else {
			$mascara = "%A, %d de %B de %Y";
		}
	}
	$data = strftime($mascara,time())."\n";
	return ucfirst($data);
}


//retorna o valor da variavel de sessão
function getSession($campo)
{
	$sessionlist = $_SESSION[SISTEMA_CODIGO];
	return $sessionlist[$campo];
}

function letrasIniciais($nome,$minusculas = true){
        $nome = ucWords(strtolower($nome)); #ESSA LINHA
        $nome = ereg_replace("Da|De|Di|Do|Du","",$nome); # ESSA Tambem
        preg_match_all('/\s?([A-Z])/',$nome,$matches);
        $ret = implode('',$matches[1]);
        return $minusculas ? strtoupper($ret) : $ret;
}

?>
