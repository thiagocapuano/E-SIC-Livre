<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

require_once ("database.php");
require_once ("funcoes.php");
require_once ("config.php");

function sendMail($to, $subject,$body,$from="",$fromname="")
{
	if (USE_PHPMAILER)
		return PHPMailerSendMail($to, $subject,$body,$from,$fromname);
	else
		return LocalSendMail($to, $subject,$body,$from,$fromname);
}

function LocalSendMail($to, $subject,$body,$from="",$fromname="")
{
                //se nao for informado o remetente, recupera das configurações do sistema
		if(empty($from))
                {
                    $sql = "select nomeremetenteemail, emailremetente from lda_configuracao";
                    $rs = execQuery($sql);

                    $row = mysqli_fetch_array($rs);
                    
                    $from = $row['emailremetente'];
                    $fromname = $row['nomeremetenteemail'];
                }
                
		$html = "<html>
					<body>
					$body
					</body>
				</html>";
				
	    
		//$headers = "Content-Type: text/plain\r\n"; 				
		$headers = "Content-type: text/html; charset=UTF-8\r\n";
		$headers .= "Reply-To: $fromname <$from>\r\n";     
		$headers .= "Return-Path: $fromname <$from>\r\n";     
		$headers .= "From: $fromname <$from>\r\n";     
		// $headers .= "Organization: Prefeitura do Natal\r\n";     
		

		if (mail($to, $subject, $html, $headers)) {
			return true;
		} else {
			error_log("E-mail de confirmação de cadastro não enviado. Última mensagem de erro:");
			$e = error_get_last();
			error_log($e["message"]);
			return false;
		}
}

 //Function SendMail com phpMailer - Opcional 

function PHPMailerSendMail($to, $subject, $body, $from="", $fromname=""){
    require_once("../class/PHPMailerAutoload.php");
    $mail = new PHPMailer();
    $mail->isSMTP();                    // Define que a mensagem será SMTP
    $mail->Host = MAIL_HOST;          //hostname ou IP do Servidor
    $mail->SMTPAuth = SMTP_AUTH;      //Caso seu email precise de autenticação, no nosso caso não.
    if (SMTP_AUTH) {
		$mail->Username = SMTP_USER;
		$mail->Password = SMTP_PWD;
	}
    if(empty($from)){
        $sql = "SELECT nomeremetenteemail, emailremetente FROM lda_configuracao"; 
        $rs = execQuery($sql);
        $row = mysqli_fetch_array($rs);
         $mail->From = $row['emailremetente'];
         $mail->FromName = $row['nomeremetenteemail'];
    }else{
        $mail->From = $from;
         $mail->FromName = $fromname;
    }
     $mail->addAddress($to);
    $mail->isHTML(true);                      //Define que o email será HTML
    $mail->CharSet = "UTF-8";       //Charset da mensagem (opcional)
    $mail->Subject = $subject;
    $html = "<html>
                    <body>
                        $body
                    </body>
                </html>";
     $mail->Body = $html;
    $mail->AltBody = $body;               //Texto Plano (opcional)
    $envia = $mail->send();                //Envia o email
    $mail->clearAllRecipients();          //Limpa os destinatarios
     if($envia){                                    //Retorno do email
        return TRUE;
    }else{
		error_log("E-mail de confirmação de cadastro não pôde ser enviado. Descrição do erro:");
		error_log($mail->ErrorInfo);
        return FALSE;
    }
}

function sendMailAnexo($to, $subject,$body,$arquivos=array(),$from="",$fromname="",$cc="")
{
                //se nao for informado o remetente, recupera das configurações do sistema
		if(empty($from))
                {
                    $sql = "select nomeremetenteemail, emailremetente from lda_configuracao";
                    $rs = execQuery($sql);

                    $row = mysqli_fetch_array($rs);
                    
                    $from = $row['emailremetente'];
                    $fromname = $row['nomeremetenteemail'];
                }

                $html = "<html>
					<body>
					$body
					</body>
				</html>";


		$boundary = strtotime('NOW');

		$headers .= "Content-Type: multipart/mixed; boundary=\"" . $boundary . "\"".PHP_EOL;		
		$headers .= "Reply-To: $fromname <$from>".PHP_EOL;     
		$headers .= "Return-Path: $fromname <$from>".PHP_EOL;     
		$headers .= "From: $fromname <$from>".PHP_EOL;  
		$headers .= "Cc: $cc".PHP_EOL;
		$headers .= "MIME-Version: 1.0".PHP_EOL;		
		$headers .= "Organization: Prefeitura do Natal".PHP_EOL;     
		
		 
		$msg = "--" . $boundary . PHP_EOL;
		$msg .= "Content-Type: text/html; charset=\"UTF-8\"".PHP_EOL;
		$msg .= "Content-Transfer-Encoding: 8bit".PHP_EOL.PHP_EOL; 
		$msg .= stripslashes($html).PHP_EOL;
		 

		for($i=1; $i <= count($arquivos); $i++)
		{
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			
			$tipoarquivo = finfo_file($finfo, $arquivos['arquivo'][$i]); 		

			$msg .= "--" . $boundary . PHP_EOL;
			$msg .= "Content-Transfer-Encoding: base64".PHP_EOL;
			$msg .= "Content-Type: \"".$tipoarquivo."\"; name=\"".$arquivos['nome'][$i]."\"".PHP_EOL;
			$msg .= "Content-Disposition: attachment; filename=\"".$arquivos['nome'][$i]."\"".PHP_EOL.PHP_EOL;
		
			ob_start();
			   readfile($arquivos['arquivo'][$i]);
			   $enc = ob_get_contents();
			ob_end_clean();

			$msg_temp = base64_encode($enc). PHP_EOL;
			$tmp[1] = strlen($msg_temp);
			$tmp[2] = ceil($tmp[1]/76);

			for ($b = 0; $b <= $tmp[2]; $b++) {
				$tmp[3] = $b * 76;
				$msg .= substr($msg_temp, $tmp[3], 76) . PHP_EOL;
			}

			unset($msg_temp, $tmp, $enc);
			
		}
		return mail($to, $subject, $msg, $headers);

		
}

//registra na tabela de erros de login, a tentativa sem sucesso de acesso ao sistema
function setTentativaLogin($usuario)
{
	 $ipaddr = $_SERVER["REMOTE_ADDR"];
	 $sistema = SISTEMA_CODIGO;
	 $query = "insert into sis_errologin (sistema, usuario,ip) values('$sistema','$usuario','$ipaddr')";
	 execQuery($query) or die("Ocorreu um erro inesperado ao logar erro de entrada");
}

//exclui da tabela de erros de login, as tentativa sem sucesso de acesso ao sistema
function delTentativaLogin($usuario)
{
	 $sistema = SISTEMA_CODIGO;
	 $query = "delete from sis_errologin  where usuario='$usuario' and sistema = '$sistema'";
	 execQuery($query) or die("Ocorreu um erro inesperado ao excluir tentativas de acesso");
}

/*---------------------------------------------------------------------------
* verifica da existencia de uma tentativa de acesso, sem sucesso, ao sistema
* e retorna se deve ser usado o recaptcha para proxima tentativa de acesso
*---------------------------------------------------------------------------*/
function usaRecaptcha($usuario)
{
	if (empty($usuario)) return false;
	
	$sistema = SISTEMA_CODIGO;
	
	$query = "select * from sis_errologin
                  where usuario='$usuario' and sistema = '$sistema'";

	$rs = execQuery($query);

	//se houver tentativas registradas retorna true para exibir o controle recaptcha
	return (mysqli_num_rows($rs) >0) ;
	
}


function autentica($login, $pwd, $tipo)
{
	if (empty($login) or empty($pwd))
	{
		if(!empty($login))
			setTentativaLogin($login);
			
		return false;
	}
	
	
        $query = "select idsolicitante as id, nome, confirmado, email
                            from lda_solicitante
                            where cpfcnpj='$login' and chave = '".md5($pwd)."' ";

        $rs = execQuery($query);

        if (mysqli_num_rows($rs) !=0) 
        {
                $row = mysqli_fetch_array($rs);
        }
        else
        {
                //inclui tentativa de acesso ao sistema, para usar o recaptcha no proximo login
                setTentativaLogin($login);
                return false;
        }

	//exclui tentativas de acesso ao sistema do usuario (para evitar o recaptcha no proximo login)
	delTentativaLogin($login);
	
	$apelido = explode(" ",$row['nome']);
	
	$var = array();
	
	$var["uid"] = $row['id'];
	$var["nomeusuario"] = $row['nome'];		
        $var["emailusuario"] = $row['email'];		
	$var["apelidousuario"] = $apelido[0];
        $var["confirmado"] = ($row['confirmado'])?"S":"N";
	
	$_SESSION[SISTEMA_CODIGO] = $var;

        return true;
	
}



/*pega o diretorio padrao para gravação de arquivos
$sis = sistema para busca do diretorio na tabela de parametros
*/
function getDiretorio($sis = "lda"){
	
	$query = "select diretorioarquivos from lda_configuracao";

	$rs = execQuery($query);

	if (mysqli_num_rows($rs) !=0) 
	{
		$row = mysqli_fetch_array($rs);
		$retorno = $row['diretorioarquivos'];
	}
	
	return $retorno;
}

/*paga o URL padrao para exibição de arquivos
$sis = sistema para busca do diretorio na tabela de parametros
*/
function getURL($sis = "alb"){
	
	$query = "select urlarquivos from lda_configuracao";

	$rs = execQuery($query);

	if (mysqli_num_rows($rs) !=0) 
	{
		$row = mysqli_fetch_array($rs);
		$retorno = $row['urlarquivos'];
	}
	
	return $retorno;
}


function prepData($var) {
  $conn = db_open();
  
  if (get_magic_quotes_gpc()) {
    $var = stripslashes($var);
  }
  
  $retorno = mysqli_real_escape_string($var);
  
  db_close($conn);
  
  return $retorno;
}

function logger($msg) {
 $usuario = getSession("uid");
 $usuario = empty($usuario)?"SYSTEM":$usuario;

 // Ugly fix pra nao permitir salvar senha em banco.
 unset($_POST["senha"]);

 $mensagem = $msg;
 $datahora = "now()";
 $dados_post = prepData(serialize($_POST));
 $dados_get = prepData(serialize($_GET));
 $dados_session = prepData(serialize($_SESSION));
 $ipaddr = $_SERVER["REMOTE_ADDR"];

 $query = "insert into sis_log (usuario,mensagem,datahora,dados_get,dados_post,ipaddr) values('$usuario','$mensagem',$datahora,'$dados_get','$dados_post','$ipaddr')";
 execQuery($query) or die("Erro logando");
}


function getErro($msg){
	//Exibe mensagem de erro passado pelas telas de manutenção
	if (trim($msg) != "")
		echo "<script>alert('$msg'); </script>";
}

function getConfirmacao($msg,$funcaoConfirmacao){
	//Exibe mensagem de confirmação passado pelas telas de manutenção
	//funcaoConfirmacao -> função javascript com o alert de confirmação e procedimentos a serem seguidos.
	if (trim($msg) != "")
		echo "<script> $funcaoConfirmacao('$msg'); </script>";		
}

function Redirect($url) {
	Header("Location:$url");
}

function isauth($tipo="consumidor") {
    session_start();
	if(!isset($_SESSION[SISTEMA_CODIGO])) {
		Redirect(SITELNK."index/?t=".$tipo);
		exit;
	}
}

session_start();

?>
