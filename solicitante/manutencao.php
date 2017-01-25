<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

	include_once("../inc/autenticar.php");
	//include_once("../class/solicitante.class.php");
	include_once("./solicitante.class.php"); //o mesmo arquivo foi adicionado na pasta solicitante e modigficado para nao interferi no cadastro de usuarios
	
	
	$erro = "";	//grava o erro, se houver, e exibe por meio de alert (javascript) atraves da funcao getErro() chamada no arquivo do formulario. ps: a função é declara em inc/security.php

	
	//se tiver sido postado informação do formulario
	if($_POST['acao'])
	{

		//dados solicitante
                $idsolicitante  = $_POST["idsolicitante"];
		$nome 		= $_POST["nome"];
		$cpfcnpj	= $_POST["cpfcnpj"];
		$profissao	= $_POST["profissao"];
		$idescolaridade	= $_POST["idescolaridade"];
		$tipopessoa	= $_POST["tipopessoa"];		
		$idfaixaetaria	= $_POST["idfaixaetaria"];
                $idtipotelefone	= $_POST["idtipotelefone"];
		$dddtelefone	= $_POST["dddtelefone"];
                $telefone	= $_POST["telefone"];
		$email		= $_POST["email"];
		$confirmeemail	= $_POST["confirmeemail"];
		
		//endereco
		$logradouro	= $_POST["logradouro"];
		$cep		= $_POST["cep"];
		$bairro		= $_POST["bairro"];
		$cidade		= $_POST["cidade"];
		$uf		= $_POST["uf"];
		$numero		= $_POST["numero"];
		$complemento	= $_POST["complemento"];
		
		$solicitante = new Solicitante();
		
                $solicitante->setIdSolicitante($idsolicitante);
		$solicitante->setNome($nome);
		$solicitante->setCpfCnpj($cpfcnpj);
		$solicitante->setProfissao($profissao);
		$solicitante->setIdEscolaridade($idescolaridade);
		$solicitante->setTipoPessoa($tipopessoa);
                $solicitante->setIdTipoTelefone($idtipotelefone);
		$solicitante->setIdFaixaEtaria($idfaixaetaria);
		$solicitante->setDDDTelefone($dddtelefone);
                $solicitante->setTelefone($telefone);
		$solicitante->setEmail($email);
		$solicitante->setLogradouro($logradouro);
		$solicitante->setCep($cep);
		$solicitante->setBairro($bairro);
		$solicitante->setCidade($cidade);
		$solicitante->setUf($uf);
		$solicitante->setNumero($numero);
		$solicitante->setComplemento($complemento);
		$solicitante->setConfirmeEmail($confirmeemail);
		
		if (!$solicitante->atualiza())
			$erro = $solicitante->getErro();
		else
			echo "<script>location.href='../index.php';</script>";
		
		$solicitante = null;
	}
	else
	{
	
		$idsolicitante = getSession("uid");
		
		if(!empty($idsolicitante))
		{
			//resgata os dados do banco para exibição no form
			$solicitante = new Solicitante($idsolicitante);
                
                        
			$idsolicitante 	= $solicitante->getIdsolicitante();
			$nome 		= $solicitante->getNome();
			$cpfcnpj	= $solicitante->getCpfCnpj();
			$profissao 	= $solicitante->getProfissao();
			$idescolaridade	= $solicitante->getIdEscolaridade();
			$tipopessoa   	= $solicitante->getTipoPessoa();
			$idtipotelefone	= $solicitante->getIdTipoTelefone();
                        $telefone       = $solicitante->getTelefone();
                        $dddtelefone    = $solicitante->getDDDTelefone();
			$idfaixaetaria  = $solicitante->getIdFaixaEtaria();
			$email 		= $solicitante->getEmail();
			$logradouro 	= $solicitante->getLogradouro();
			$cep 		= $solicitante->getCep();
			$bairro 	= $solicitante->getBairro();
			$cidade 	= $solicitante->getCidade();
			$uf 		= $solicitante->getUf();
			$numero 	= $solicitante->getNumero();
			$complemento 	= $solicitante->getComplemento();
			
			$solicitante = null;
			
		}
	}


?>
