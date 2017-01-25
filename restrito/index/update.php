<?php
return;
	include_once("../inc/database.php");

    if (!empty($_FILES['arquivo']))
    {
		$con = db_open();
		$mysqli = db_open_trans();
		
        //$Pdo     = new PDO("mysql:host=localhost;dbname=dbesiclivre", "root", "Web.Mysql#690");
				
        $file	= fopen($_FILES['arquivo']['tmp_name'], 'r');
		$insert	= 0;
		$update	= 0;
		$qryTipo= 0;
		
        while (!feof($file)) 
		{            
			$linha = fgets($file);                      
			$itens = explode(';', $linha);    
			
			//IMPORTAÇÃO DOS USUÁRIOS
			if ($_POST['opcao'] == '1')
			{

				//Consulta idsecretaria do usuario
				$qryTmp	= "SELECT idsecretaria from sis_secretaria WHERE sigla = '" . trim($itens[4]) . "'";
				$rs		= mysqli_query($mysqli, $qryTmp);
				$idsecretaria = null;
				
				if(mysqli_num_rows($rs)>0)
				{
					$row = mysqli_fetch_array($rs);
					$idsecretaria = $row["idsecretaria"];
                }
				else {
					$idsecretaria = "null";
				}
				
				//Define se é atualização ou inserção
				$qryTmp	= "SELECT idusuario from sis_usuario WHERE login = '$itens[0]'";
				$rs		= mysqli_query($mysqli, $qryTmp);
				
				if(mysqli_num_rows($rs)>0)
				{
					$qryTipo	= 1;
					$row 		= mysqli_fetch_array($rs);
					$idusuario	= $row["idusuario"];
					
					$qry = "UPDATE sis_usuario 
								SET nome		= '$itens[1]',
									matricula	= '$itens[2]',
									email		= '$itens[3]',
									status		= 'A',
									idsecretaria= $idsecretaria								
							WHERE 
								idusuario = $idusuario";
                }
				else {
                    $qry 	= "INSERT INTO sis_usuario(login, cpfusuario, nome, matricula, email, status, idsecretaria) VALUES ('$itens[0]','$itens[0]','$itens[1]','$itens[2]','$itens[3]', 'A', $idsecretaria);";							
					$qryTipo= 2;
				}
			}
			
			//IMPORTAÇÃO DAS DIRETORIAS
			else if ($_POST['opcao'] == '2')
			{
				$qry = "INSERT INTO sis_secretaria(sigla, nome, responsavel, idorigem, ativado) VALUES ('$itens[0]','$itens[1]','$itens[2]', $itens[3], 1);";
			}
			
			//IMPORTAÇÃO DOS SETORES
			else if ($_POST['opcao'] == '3')
			{		
				//Consulta idsecretaria do usuario
				$qryTmp	= "SELECT idsecretaria from sis_secretaria WHERE idorigem = '" . trim($itens[4]) . "'";
				$rs		= mysqli_query($mysqli, $qryTmp);
		
				if(mysqli_num_rows($rs)>0)
				{
					$row = mysqli_fetch_array($rs);
					$idvinculado = $row["idsecretaria"];
                }
				
				$qry = "INSERT INTO sis_secretaria(sigla, nome, responsavel, idorigem, idsetorvinculado, ativado) VALUES ('$itens[0]','$itens[1]', '$itens[2]', '$itens[3]', $idvinculado, 1);";
					
			}
			
			if (!mysqli_query($con, $qry)) 
				echo mysqli_error() . '<br>';
			else {
				if ($qryTipo == 1)
					$update++;
				else if ($qryTipo == 2)
					$insert++;
			}
        }
		
		db_close($con);
		mysqli_close($mysqli);
    }

?>
<!DOCTYPE HTML>
<html>
<head>

<title>Arquivo</title>
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" method="post">
        <input type="file" name="arquivo" id="arquivo">
		<br>
		<input type="radio" name="opcao" value="1">Usuários
		<input type="radio" name="opcao" value="2">Diretorias
		<input type="radio" name="opcao" value="3">Setores
		<br>
        <input type="submit" name="enviar" value="Enviar">
    </form>
	
	<br>
	Inseridos: <?php echo $insert;?><br>
	Atualizados: <?php echo $update;?>
</body>
</html>