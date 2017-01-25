<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

  include("../inc/autenticar.php");
  
  checkPerm("DELUSR");
  
  $codigo = $_REQUEST["codigo"];

  $sql = "DELETE from sis_usuario where idusuario = $codigo ";
  
  if(!execQuery($sql))
  {
    echo "<script>alert('Nao foi possivel excluir este usuario. Pode estar em uso.');</script>";
  }
  else
  {
	logger("Excluiu Usuario");  
	//echo "<script>alert('Usuario Excluido');</script>";
  }
  
$txt = explode("?", $_SERVER['REQUEST_URI']);
$txt2 = explode("&", $txt[1]);
 
  
  //echo "<script>document.location='index.php';</script>";
  echo "<script>document.location='?".$txt2[0]."';</script>";
  
?>