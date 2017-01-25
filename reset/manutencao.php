<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

	include_once("../class/solicitante.class.php");	
	
	
	
	$erro="";
	
	if($_POST['btsub'])
	{
		$cpfcnpj = $_POST['cpfcnpj'];
		
		$solicitante = new Solicitante();
		
		if (!$solicitante->resetaSenha($cpfcnpj))
			$erro = $solicitante->getErro();
		else
			$erro = "Caro(a) ".$solicitante->getNome().", sua senha foi redefinida com sucesso. A nova senha foi enviada para o seu e-mail: ".$solicitante->getEmail();

		$solicitante = null;
	}
?>

