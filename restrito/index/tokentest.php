<?php
include("../inc/config.php");
require_once("../inc/security.php");
echo SIS_TOKEN ."<br>";
echo "05476252436" . date("H") . (date("d")+1) . "eSiCTc%&<br>";
echo md5("05476252436" . date("H") . (date("d")+1) . "eSiCTc%&");


$token2 	= $_REQUEST["to2"];

if (!empty($token2)) {
	
    if (autentica("", "", "", "", $token2)) {
		if (empty($notRedir)) {
			Redirect("http://dev/sistemas/testes/getusuario.asp");
			echo 'loggin...';
		}
    } else {
        $msg = "<font color='red'>Erro: falha no login.</font>";
    }
}
?>