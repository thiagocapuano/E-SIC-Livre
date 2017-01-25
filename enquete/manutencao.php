<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

include_once("../inc/autenticar.php");
include_once("../class/solicitacao.class.php");

function validaDados()
{

	// Recuperamos os valores dos campos atravÃ©s do mÃ©todo POST
	global $erro;
	global $resposta;
	global $comentario;
	
	if (empty($resposta))
	{
		$erro = "Por favor selecione uma opção de resposta!";
		return false;
	}
	
	return true;
}

$erro = "";
$resposta = $_POST["resposta"];
$comentario = $_POST["comentario"];

if ($_POST["Enviar"]) {

    if(validaDados())
    {
        $sql="INSERT INTO lda_enquete
                (idsolicitante, resposta, comentario, dataresposta)
                VALUES
                (".getSession("uid").", '".$resposta."','".(str_replace("'","\'",$comentario))."',NOW())";

        if (!execQuery($sql))
            $erro = "Erro ao gravar enquete";

    }
}

?>