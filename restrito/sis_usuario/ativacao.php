<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

  include("../inc/autenticar.php");
  
  checkPerm("DEAUSR");
  
  $idusuario  = $_REQUEST["idusuario"];
  $status  = $_REQUEST["status"];
	
  $sql = "UPDATE sis_usuario set 
            status='$status', 
            idusuarioalteracao = ".getSession('uid').", 
            dataalteracao = NOW() 
          WHERE idusuario ='$idusuario' ";

  if (execQuery($sql))
  {
	if ($status == "I")
		logger("Desativou Usuario");
	else
		logger("Ativou Usuario");
		
	//header("Location: index.php");
	echo "javascript:history.go(-1)";
  }
  else
  {
	echo "<script>alert('Ocorreu um erro ao alterar status do usuario.');</script>";
  }
  
  echo "<script>history.go(-1);</script>";
?>