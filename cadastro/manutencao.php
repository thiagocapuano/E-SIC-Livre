<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

	include_once("../inc/security.php");
	
	
	$erro   = "";	//grava o erro, se houver, e exibe por meio de alert (javascript) atraves da funcao getErro() chamada no arquivo do formulario. ps: a função é declara em inc/security.php

        $acao 		= "";
        $nome 		= "";
        $cpfcnpj	= "";
        $profissao	= "";
        $idescolaridade	= "";
        $tipopessoa	= "";
        $idfaixaetaria	= "";
        $idtipotelefone	= "";
        $dddtelefone	= "";
        $telefone	= "";
        $email		= "";
        $confirmeemail	= "";
        $logradouro	= "";
        $cep		= "";
        $bairro		= "";
        $cidade		= "";
        $uf		= "";
        $numero		= "";
        $complemento	= "";
        $senha          = "";
        $confirmasenha	= "";
        
	
	//se tiver sido postado informação do formulario
	if($_POST['acao'])
	{

		//dados solicitante
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

                //acesso e-sic
                $senha          = $_POST['senha'];
                $confirmasenha  = $_POST['confirmasenha'];
                
		include_once("../class/solicitante.class.php");
		
		$solicitante = new Solicitante();
		
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
                $solicitante->setSenha($senha);
                $solicitante->setConfirmaSenha($confirmasenha);
		
		if (!$solicitante->cadastra())
			$erro = $solicitante->getErro();
		else
			echo "<script>alert('Cadastro realizado com sucesso!');location.href='index.php?r=$email';</script>";
		
		$solicitante = null;

	}
	
        if(empty($tipopessoa))$tipopessoa="F";


?>
