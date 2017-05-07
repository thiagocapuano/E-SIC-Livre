<?php

  //tipo de arquivos
  $tiposPermitidos= array('application/pdf', 'image/jpeg' );
 
  // O nome original do arquivo no computador do usuario
  $arqName = $_FILES['arquivo']['name'];
  
  // O tipo mime do arquivo. Um exemplo pode ser "image/gif"
  $arqType = $_FILES['arquivo']['type'];
 
  // O tamanho, em bytes, do arquivo
  $arqSize = $_FILES['arquivo']['size'];
 
  // O nome temporario do arquivo, como foi guardado no servidor
  $arqTemp = $_FILES['arquivo']['tmp_name'];
 
  // O codigo de erro associado a este upload de arquivo
  $arqError = $_FILES['arquivo']['error'];		
	
  $error = 2;
		
if ($_POST['acao']){ //inicio if post
	
	function verificadados(){
		
		global $error, $alerta,$tiposPermitidos,$arqTemp,$arqType, $tiposPermitidos,$arqSize;
		//verifica tipo de arquivo e tamanho
		if  (!empty($arqTemp)){
			$error = 0;
			
				if (array_search($arqType, $tiposPermitidos) === false){
				$alerta = $alerta."Tipo de Arquivo Invalido\\n";
				$error = 1;
				}
				if ($arqSize > 2048000){
					$alerta = $alerta."Arquivo muito Grande, Limite 2MB";
				$error = 1;
				}
				
		}else {
			$error = 3;
		}
	return $error;
	}

function enviadados(){
	global $error, $arqTemp,$arqName;
	// se tiver arquivo faz upload	e insere na tabela
	if (!empty($arqTemp) && $error == 0 ){
	//###################################
		//pega diretorio
		$sql = execQuery("SELECT * FROM `lda_configuracao`");
		$row = mysqli_fetch_array($sql);
		$pasta = $row['diretorioarquivos'];
		
		//pega ida da ultima solicitacao possivelmente a que esta sendo realizada
		$sql = execQuery("SELECT * FROM `lda_solicitacao` ORDER BY `idsolicitacao` DESC LIMIT 1 ");
		$row = mysqli_fetch_array($sql);
		$idsolicitacao = $row['idsolicitacao']; //ida da solicitação para nome do arquivo
		$iduser = getSession("uid");       //sessao do solicitante 
		
		//seleciona id do anexo
		$sql = execQuery("SELECT * FROM `lda_anexo` ORDER BY `idsolicitacao` DESC LIMIT 1 ");
		$row = mysqli_fetch_array($sql);
		$idanexo = $row['idanexo']+1;
				
		//###################################
		//$pasta = './000/';
		// Pega a extensão do arquivo enviado
		$extensao = strtolower(end(explode('.', $arqName)));
				  
		// Define o novo nome do arquivo usando um UNIX TIMESTAMP
		$nome = "user_".$idsolicitacao."_file_".$idanexo.".".$extensao;
		$upload = move_uploaded_file($arqTemp, $pasta . $nome);
			
		
		//insere em lda_anexo dados do arquivo 
		$conect = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME) or die('Erro ao conectar ao banco de dados');
		mysqli_set_charset($conect, "utf8");
		$sql="INSERT INTO lda_anexo ( idsolicitacao,
									  nome,
									  idusuarioinclusao,
									  datainclusao
									) VALUES (
									 '$idsolicitacao',
									 '$nome',
									 16,
									 NOW()
									  )";
		
		//mysqli_query($conect,$sql) or die ("erro mysql");
		if (!mysqli_query($conect, $sql)){
			echo '<br>erro ao inserir  ';
			echo $sql;
			echo mysqli_error();
			
		}

	//echo '<script>alert("ARQUIVO ENVIADO")</script>';
	//echo '<script>window.location = "./z3.php";</script>';
	}	
}

//verificadados();

//enviadados();


}//fim if post


?>

