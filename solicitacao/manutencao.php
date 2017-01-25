<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/
		
	    include_once("../inc/security.php");
		include_once("../class/solicitacao.class.php");
		
	
	
	$erro   = "";	//grava o erro, se houver, e exibe por meio de alert (javascript) atraves da funcao getErro() chamada no arquivo do formulario. ps: a função é declara em inc/security.php

        $acao 	= "";
        
	
	//se tiver sido postado informação do formulario
	if($_POST['acao'])
	{

		$idsolicitante 	= $_POST["idsolicitante"];
		$textosolicitacao = $_POST["textosolicitacao"];
                $formaretorno	= $_POST["formaretorno"];
                $idsecretariaselecionada = $_POST['idsecretariaselecionada'];

		$solicitacao = new Solicitacao();
		
		$solicitacao->setIdSolicitante($idsolicitante);
		$solicitacao->setTextoSolicitacao($textosolicitacao);
		$solicitacao->setFormaRetorno($formaretorno);
                $solicitacao->setIdSecretariaSelecionada($idsecretariaselecionada);

        if (!$solicitacao->cadastra()){
		$erro = $solicitacao->getErro();
				
				if ($upload == 1){
					echo "<script>alert('".$alerta."');</script>";
				}	
			
		}else{
		
				enviadados();
				echo "<script>alert('Solicitação enviada com sucesso!');location.href='index.php?ok=1';</script>";
				
				$solicitante = null;
		
		}		
	}
        else
        {
            $idsolicitante = getSession("uid");
        }
	
        

?>
