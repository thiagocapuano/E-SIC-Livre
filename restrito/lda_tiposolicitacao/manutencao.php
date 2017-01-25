<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

	include_once("../inc/autenticar.php");
        include_once(DIR_CLASSES_LEIACESSO."/solicitacao.class.php");
	checkPerm("LSTGRP");
	
	//função de validação dos dados do formulario do cadastro de usuario -------------------
	function validaDados()
	{
		global $erro;
		global $acao;
		global $nome;
		global $idtiposolicitacao_seguinte;
		global $idtiposolicitacao;
		global $instancia;		
				
		if (empty($nome))
		{
			$erro = "Nome não informado.";
			return false;
		}
		else if (empty($instancia))
		{
			$erro = "Instância não informada.";
			return false;
		}


		//verifica se ja existe registro cadastrado com a informaçao passada ---
		if ($acao=="Incluir")
			$sql = "select * from lda_tiposolicitacao where nome = '$nome'";
		else
			$sql = "select * from lda_tiposolicitacao where nome = '$nome' and idtiposolicitacao <> $idtiposolicitacao";
			
		if(mysqli_num_rows(execQuery($sql)) > 0)
		{
			$erro = "Nome do tipo de instancia já existe no cadastro.";
			return false;
		}
		//-----------------------------------------------------------------------
		//verifica se ja existe registro cadastrado como inicial
		if($instancia == "I")
		{
			if ($acao=="Incluir")
				$sql = "select * from lda_tiposolicitacao where instancia = 'I'";
			else
				$sql = "select * from lda_tiposolicitacao where instancia = 'I' and idtiposolicitacao <> $idtiposolicitacao";
				
			if(mysqli_num_rows(execQuery($sql)) > 0)
			{
				$erro = "Só pode existir uma instância cadastrada como inicial.";
				return false;
			}
		}
		//-----------------------------------------------------------------------
		
		return true;
	}
	
	function limpaDados()
	{
		global $acao;
		global $nome;
		global $idtiposolicitacao;		
		global $idtiposolicitacao_seguinte;
		global $instancia;		
		
		$acao 	   = "Incluir";
		$nome 	   = "";
		$idtiposolicitacao   = "";
		$idtiposolicitacao_seguinte = "";
		$instancia     = "";
		
	}
	
	//------------------------------------------------------------------------------------------
	$erro	= "";

        //recupera valores do formulario
        $acao                       = (empty($_POST["acao"]))?"Incluir":$_POST["acao"];
        $idtiposolicitacao          = $_POST["idtiposolicitacao"];
        $nome                       = $_POST["nome"];
        $idtiposolicitacao_seguinte = ($_POST["idtiposolicitacao_seguinte"]=="-1")?"":$_POST["idtiposolicitacao_seguinte"];
        $instancia                  = $_POST["instancia"];
        
	//se tiver sido postado informação do formulario
	if ($_POST['acao'])
	{
		
		//verifica ação do usuario
		switch ($acao)
		{
			//se for uma inclusao
			case "Incluir":
				checkPerm("INSTIPOSOL");
				
				if(validaDados())
				{
					$sql="INSERT INTO lda_tiposolicitacao (nome, idtiposolicitacao_seguinte,instancia, idusuarioinclusao, datainclusao) 
							VALUES ('$nome', ".(empty($idtiposolicitacao_seguinte)?"null":$idtiposolicitacao_seguinte).", '$instancia', ".getSession('uid').",NOW())";
					
					if (execQuery($sql))
					{
						logger("Tipo de instancia Adicionado com Sucesso.");  
						limpaDados();
					}
					else
					{
						$erro = "Ocorreu um erro ao incluir instancia.".$sql;
					}
				}
				break;
			//se for uma alteração
			case "Alterar":  		
				checkPerm("UPTTIPOSOL");	
				
				if(validaDados())
				{
					$sql = "UPDATE lda_tiposolicitacao set 
                                                    nome='$nome',
                                                    instancia='$instancia',
                                                    idusuarioalteracao = ".getSession('uid').",
                                                    dataalteracao = NOW()
						WHERE idtiposolicitacao =$idtiposolicitacao ";

					if (execQuery($sql))
					{
						logger("Tipo de solicitação alterado com sucesso");  
						limpaDados();
					}
					else
					{
					
						$erro = "Ocorreu um erro ao alterar tipo de solicitação.";
					}
				}
				break;
		}
	}
        else if($_POST['idtiposolicitacao_seguinte'])
        {
            //se for uma ordenação
            checkPerm("UPTTIPOSOL");	

            $sql = "UPDATE lda_tiposolicitacao set 
                        idtiposolicitacao_seguinte = ".(empty($idtiposolicitacao_seguinte)?"null":$idtiposolicitacao_seguinte).",
                        idusuarioalteracao = ".getSession('uid').",
                        dataalteracao = NOW()
                    WHERE idtiposolicitacao =$idtiposolicitacao ";

            
            if (execQuery($sql))
            {
                    logger("Ordem do tipo de solicitação alterado com sucesso");  
                    limpaDados();
            }
            else
            {

                    $erro = "Ocorreu um erro ao alterar tipo de solicitação.";
            }

        }

?>