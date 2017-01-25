<?php 
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

//PAGINACAO - PARTE INICIAL
	
	$total="";
	//retorna a quantidade de registros da consulta
	function execQueryPag($consulta){
		global $total;
		global $limit;

		$consulta = strtolower($consulta);
		
		/*$pos = strpos($consulta, "from") - 1;
		$sql = "select count(*) as total ".substr($consulta,$pos,strlen($consulta));
	
		$resultado = execQuery($sql);
		$row = mysqli_fetch_assoc($resultado);
		$total = $row["total"];*/
		
		$rs = execQuery($consulta);
		$total = mysqli_num_rows($rs);
		
		return execQuery($consulta.$limit);
		
	}
	
	// Declaração da pagina inicial  
	$pagina = $_GET["pagina"];  
	if($pagina == "") 
	{  
		$pagina = "1";  
	} 

	// Maximo de registros por pagina  
	$maximo = 30;
	
	// Calculando o registro inicial  
	$inicio = $pagina - 1;  
	$inicio = $maximo * $inicio;

	$limit = " limit $inicio,$maximo";
	
/* exemplo do uso
	include "paginacaoIni.php";
	
	$sql = "select * from tabela";

	$resultado = execQueryPag($sql);
	
	//inclui o arquivo paginacaoFim.php onde serao exibidos os controles da paginação, tem q ser abaixo da inclusao desse e depois da consulta

*/
	
?>
