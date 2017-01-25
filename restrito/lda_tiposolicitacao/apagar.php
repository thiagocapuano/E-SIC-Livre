<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

  include("../inc/autenticar.php");
  checkPerm("DELTIPOSOL");
  
  $codigo = $_REQUEST["codigo"];

  $sql = "delete from lda_tiposolicitacao where idtiposolicitacao = '$codigo'";

  if(!execQuery($sql))
  {
    echo "<script>alert('Não foi possivel excluir este tipo de solicitação. Esse registro pode estar em uso.');</script>";
  }
  else
  {
	logger("Tipo de solicitação excluído com sucesso.");
  }

  echo "<script>document.location='?lda_tiposolicitacao';</script>";

?>