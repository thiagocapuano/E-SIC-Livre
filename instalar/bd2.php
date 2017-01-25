<?php

require_once("../inc/config.php");
// Configuração de banco de dados
//define("DBHOST", "*");
//define("DBUSER", "*");
//define("DBPASS", "*");
//define("DBNAME", "*");
//shell_exec('mysql -u '.DBUSER.' --password='.DBPASS.' '.DBNAME.' < ../basedados/dbesiclivre1-linha-de-comando.sql');

//INSTALaçãO BANCO DE DADOS 
if ($_POST['prosseguir0'] == "Proseguir v2"){

	$link = mysqli_connect('localhost', DBUSER ,DBPASS, DBNAME );
	mysqli_set_charset($link, "utf8");
	if (!$link) {
		echo ('Não foi possível conectar: ' .mysqli_error());
	}else{
	
	
		shell_exec('mysql -u '.DBUSER.' --password='.DBPASS.' '.DBNAME.' < ../basedados/dbesiclivre1-linha-de-comando.sql');
		shell_exec('mysql -u '.DBUSER.' --password='.DBPASS.' '.DBNAME.' < ../basedados/dbesiclivre2.sql');
		shell_exec('mysql -u '.DBUSER.' --password='.DBPASS.' '.DBNAME.' < ../basedados/dbesiclivre3.sql');
	
		header("location: fim.php");
	
		}
}
//FIM BANCO DE DADOS 

?>