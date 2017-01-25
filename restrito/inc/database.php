<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

require_once("config.php");

function db_open() {

    $conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME) or die('nao pode conectar ao banco');
    mysqli_set_charset($conn, "utf8");

    return $conn;
} 

function db_close($conn) {
    mysqli_close($conn) or die ("nao pode fechar a conexao");
}

//retorna objeto de conexao com o banco para transações
function db_open_trans()
{
	//conecta ao mysqli
	$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
	$mysqli->set_charset("utf8");
	/* check connection */
	if (mysqli_connect_errno()) {
		die("Falha na conexao: ". mysqli_connect_error());
	}		

	$mysqli->autocommit(false);
	
	return $mysqli;

}



function execQuery($query) {
    $conn = db_open();

    $rs = mysqli_query($conn, $query); // or die (mysqli_error());

    db_close($conn);
    return $rs;
}

function rs_to_array($result, $numass=mysqli_BOTH) {
    $got = array();

    if(mysqli_num_rows($result) == 0)
    return $got;

    mysqli_data_seek($result, 0);

    while ($row = mysqli_fetch_array($result, $numass)) {
        array_push($got, $row);
    }

    return $got;
}


?>
