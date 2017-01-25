<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

include "../inc/security.php";

if ($_SESSION[SISTEMA_CODIGO]) {
	$_SESSION = array();
	session_destroy();
}
Redirect("../index.php");

