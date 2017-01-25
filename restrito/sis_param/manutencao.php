<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

	include_once("../inc/autenticar.php");
	checkPerm("LSTPARAM");
	
	//função de validação dos dados do formulario do cadastro de usuario -------------------
	function validaDados()
	{
		global $erro;
		global $acao;
		global $sistema;
		global $diretorioarquivos;
		global $urlarquivos;		
				
		if (empty($sistema))
		{
			$erro = "SISTEMA não informado.";
			return false;
		}
		else if (empty($diretorioarquivos))
		{
			$erro = "Diretorio de Arquivos não informado.";
			return false;
		}
		else if (empty($urlarquivos))
		{
			$erro = "URL dos Arquivos não informado.";
			return false;
		}
		
		//verifica se ja existe registro cadastrado com a informaçao passada ---
		if ($acao=="Incluir")
		{
			$sql = "select * from sis_param where sistema = '$sistema'";
			
			if(mysqli_num_rows(execQuery($sql)) > 0)
			{
				$erro = "Nome do Sistema já existe no cadastro.";
				return false;
			}
		}
		//-----------------------------------------------------------------------
		
		return true;
	}
	
	function limpaDados()
	{
		global $acao;
		global $sistema;
		global $diretorioarquivos;
		global $urlarquivos;		
		
		$acao 	   = "Incluir";
		$sistema   = "";
		$idgrupo   = "";
		$diretorioarquivos = "";
		$urlarquivos     = "";
		
	}
	
	//------------------------------------------------------------------------------------------
	$acao	= "Incluir";
	$erro	= "";
	
	//se tiver sido postado informação do formulario
	if ($_POST['acao'])
	{
		//recupera valores do formulario
		$acao			   = $_POST["acao"];
		$sistema		   = $_POST["sistema"];
		$diretorioarquivos = $_POST["diretorioarquivos"];
		$urlarquivos	   = $_POST["urlarquivos"];
		
		//verifica ação do usuario
		switch ($acao)
		{
			//se for uma inclusao
			case "Incluir":
				checkPerm("INSPARAM");
				
				if(validaDados())
				{
					$sql="INSERT INTO sis_param (sistema,diretorioarquivos,urlarquivos) 
							VALUES ('$sistema', '$diretorioarquivos', '$urlarquivos')";
					
					if (execQuery($sql))
					{
						logger("PARAMETRO DE SISTEMA Adicionado com Sucesso.");  
						limpaDados();
					}
					else
					{
						$erro = "Ocorreu um erro ao incluir PARAMETRO.".$sql;
					}
				}
				break;
			//se for uma alteração
			case "Alterar":  		
				checkPerm("UPTPARAM");	
				
				if(validaDados())
				{
					$sql = "UPDATE sis_param set 
								diretorioarquivos = '$diretorioarquivos',
								urlarquivos='$urlarquivos'
							WHERE sistema = '$sistema' ";

					if (execQuery($sql))
					{
						logger("PARAMETRO DE SISTEMA Alterado com Sucesso ");  
						limpaDados();
					}
					else
					{
					
						$erro = "Ocorreu um erro ao alterar PARAMETRO DE SISTEMA.";
					}
				}
				break;
		}
	}

?>