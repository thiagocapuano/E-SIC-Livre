<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

	include_once("../inc/autenticar.php");
	checkPerm("LSTGRP");
	
	//função de validação dos dados do formulario do cadastro de usuario -------------------
	function validaDados()
	{
		global $erro;
		global $acao;
		global $nome;
		global $descricao;
		global $idgrupo;
		global $ativo;		
				
		if (empty($nome))
		{
			$erro = "Nome não informado.";
			return false;
		}
		else if (empty($descricao))
		{
			$erro = "Descrição não informada.";
			return false;
		}


		//verifica se ja existe registro cadastrado com a informaçao passada ---
		if ($acao=="Incluir")
			$sql = "select * from sis_grupo where nome = '$nome'";
		else
			$sql = "select * from sis_grupo where nome = '$nome' and idgrupo <> $idgrupo";
			
		if(mysqli_num_rows(execQuery($sql)) > 0)
		{
			$erro = "Nome do perfil já existe no cadastro.";
			return false;
		}
		//-----------------------------------------------------------------------
		
		return true;
	}
	
	function limpaDados()
	{
		global $acao;
		global $nome;
		global $idgrupo;		
		global $descricao;
		global $ativo;		
		
		$acao 	   = "Incluir";
		$nome 	   = "";
		$idgrupo   = "";
		$descricao = "";
		$ativo     = "";
		
	}
	
	//------------------------------------------------------------------------------------------
	$erro	= "";

        //recupera valores do formulario
        $acao		= (empty($_POST["acao"]))?"Incluir":$_POST["acao"];
        $idgrupo	= $_POST["idgrupo"];
        $nome		= $_POST["nome"];
        $descricao      = $_POST["descricao"];
        $ativo	        = $_POST["ativo"];
        
	//se tiver sido postado informação do formulario
	if ($_POST['acao'])
	{
		
		//verifica ação do usuario
		switch ($acao)
		{
			//se for uma inclusao
			case "Incluir":
				checkPerm("INSGRP");
				
				if(validaDados())
				{
					$sql="INSERT INTO sis_grupo (nome,descricao,ativo, idusuarioinclusao, datainclusao) 
							VALUES ('$nome', '$descricao', ".(($ativo=="2")?"0":"1").", ".getSession('uid').",NOW())";
					
					if (execQuery($sql))
					{
						logger("Perfil Adicionado com Sucesso.");  
						limpaDados();
					}
					else
					{
						$erro = "Ocorreu um erro ao incluir Perfil.";
					}
				}
				break;
			//se for uma alteração
			case "Alterar":  		
				checkPerm("UPTGRP");	
				
				if(validaDados())
				{
					$sql = "UPDATE sis_grupo set 
                                                    nome='$nome',
                                                    descricao = '$descricao',
                                                    ativo=".(($ativo=="2")?"0":"1").",
                                                    idusuarioalteracao = ".getSession('uid').",
                                                    dataalteracao = NOW()
						WHERE idgrupo =$idgrupo ";

					if (execQuery($sql))
					{
						logger("Perfil alterado com sucesso");  
						limpaDados();
					}
					else
					{
					
						$erro = "Ocorreu um erro ao alterar perfil.";
					}
				}
				break;
		}
	}

?>