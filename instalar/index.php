<?php
// Verifica permissões de escrita
if ( (is_writable("../inc/config.php") and is_writable("../restrito/inc/config.php")) or
	( !(file_exists("../inc/config.php") and file_exists("../restrito/inc/config.php")) and
	(is_writable("../inc/") and is_writable("../restrito/inc/"))) and
	is_writable("index.php") and is_writable("bd.php")
	) {

	// Se o o método é POST, verifica o preenchimento e tenta escrever os arquivos de configuração
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$erro = false;
		
		$nome = $_POST["nome"];
		$codigo = $_POST["codigo"];
		(substr($_POST["sitelink"], -1) != "/") ? $sitelink = $_POST["sitelink"]."/" : $sitelink = $_POST["sitelink"];
		if (substr($_POST["urlsistema"], -1) != "/") {
			if ($_POST["urlsistema"] != "") {
				$urlsistema = $_POST["urlsistema"]."/";
			} else {
				$urlsistema = $sitelink;
			}
		} else {
			$urlsistema = $_POST["urlsistema"];
		}
		$dbhost = $_POST["dbhost"];
		$dbuser = $_POST["dbuser"];
		$dbpass = $_POST["dbpass"];
		$dbname = $_POST["dbname"];
		$phpmailer = $_POST["phpmailer"] == "phpmailer" ? true : false;
		$smtphost = $_POST["smtpport"] != "" ? $_POST["smtphost"].":".$_POST["smtpport"] : $_POST["smtphost"];
		$smtpauth = $_POST["smtpauth"] == "smtpauth" ? true : false;
		$smtpuser = $_POST["smtpuser"];
		$smtppwd = $_POST["smtppwd"];

		
		// Verifica os campos obrigatórios
		if ($nome and $codigo and $sitelink and $urlsistema and
			$dbhost and $dbuser and $dbpass and $dbname and
			((!$phpmailer) or ($smtphost and
				(!($smtpauth) or ($smtpuser and $smtppwd))
			))
		) {			
			try {
				$config = fopen("../inc/config.php", "w");
				fwrite($config, <<<CONF
<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

error_reporting(E_ERROR);

define("SISTEMA_NOME", "$nome"); //nome do sistema para exibição em lugares diversos
define("SISTEMA_CODIGO", "$codigo"); //codigo para definição da lista de sessão do sistema

// Configurações de banco de dados
define("DBHOST", "$dbhost");
define("DBUSER", "$dbuser");
define("DBPASS", "$dbpass");
define("DBNAME", "$dbname");

// Definições de e-mail
define("USE_PHPMAILER", "$phpmailer");
define("MAIL_HOST", "$smtphost");
define("SMTP_AUTH", "$smtpauth");
define("SMTP_USER", "$smtpuser");
define("SMTP_PWD", "$smtppwd");

// Endereços do site
define("SITELNK", "$sitelink");	//endereço principal do site
define("URL_BASE_SISTEMA", "$urlsistema");	//endereço principal do site

?>
CONF
			    );
                fclose($config);
                $config = fopen("../restrito/inc/config.php", "w");
                fwrite($config, <<<CONF
<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

error_reporting(E_ERROR);

define("SISTEMA_NOME", "$nome"); //nome do sistema para exibição em lugares diversos
define("SISTEMA_CODIGO", "$codigo"); //codigo para definição da lista de sessão do sistema

// Configurações de banco de dados
define("DBHOST", "$dbhost");
define("DBUSER", "$dbuser");
define("DBPASS", "$dbpass");
define("DBNAME", "$dbname");

// Definições de e-mail
define("USE_PHPMAILER", "$phpmailer");
define("MAIL_HOST", "$smtphost");
define("SMTP_AUTH", "$smtpauth");
define("SMTP_USER", "$smtpuser");
define("SMTP_PWD", "$smtppwd");

// Endereços do site

//endereço principal do site
define("SITELNK", "$sitelink");	

//endereço principal do site administração
define("URL_BASE_SISTEMA", "$urlsistema");	

// Caminho para arquivos das classes do projeto Lei de Acesso
define("DIR_CLASSES_LEIACESSO","../class/");

define("SIS_TOKEN", date("H") . (date("d")+1) . "");
?>
CONF
		    );
                fclose($config);
            } catch(Exceptipon $e) {
            	$erro = "n&atilde;o foi poss&iacute;vel escrever os arquivos de configura&ccedil;&atilde;o ($e)";
            }
		} else {
			$erro = "campos obrigat&oacute;rios n&atilde;o preenchidos";			
		}
	
		// Se a configuração foi bem sucedida, passa à próxima etapa	
		if (!$erro) {
			echo "<script> document.location='bd.php'; </script>";
			
			die();
		} else {
			echo "<script language='javascript'>e = document.createElement('span');e.innerHTML = 'Erro na configura&ccedil;&atilde;o do sistema: $erro.';alert(e.textContent);</script>"; // Dessa maneira conseguimos exibir os caracteres especiais
		}
	} else { // GET
    	$nome = "e-SIC Livre";
        $codigo = "esiclivre";
    }

include("../inc/topo.php");

// Formulário de configuração
?>


<div id="principal">
	<h1>Instala&ccedil;&atilde;o do e-SIC Livre</h1>
    <h2>Passo 1 de 2</h2>
    <h3>Configura&ccedil;&atilde;o do sistema</h3>
	<form action="index.php" method="post">
		<fieldset>
			<legend>Informa&ccedil;&otilde;es do sistema</legend>
			<table>
				<tr>
				<td>
				<label for="nome">Nome do sistema:<small>*</small>
				</label>
				</td>
				<td>
				<input type="text" name="nome" id="nome" value="<?php echo $nome;?>" size="35" class="campo3">
				</td>
				</tr>
				<tr><td><label for="codigo">C&oacute;digo dos <em>cookies</em> de sess&atilde;o:<small>*</small></label></td><td><input type="text" name="codigo" id="codigo" value="<?php echo $codigo;?>" size="35"></td></tr>
				<tr><td><label for="sitelink">URL do <em>site</em> principal:<small>*</small></label></td><td><input type="text" name="sitelink" id="sitelink" value="<?php echo $sitelink;?>" size="35"></td></tr>
				<tr><td><label for="urlsistema">URL da raiz do sistema:<small>*</small></label></td><td><input type="text" name="urlsistema" id="urlsistema" value="<?php echo $urlsistema;?>" size="35"></td></tr>
			</table>
		</fieldset>
		
		<fieldset>
			<legend>Banco de dados</legend>
			<table>
				<tr><td><label for="dbhost">Endere&ccedil;o do servidor:<small>*</small></label></td><td><input type="text" name="dbhost" id="dbhost" value="<?php echo $dbhost;?>" size="35"></td></tr>
				<tr><td><label for="dbuser"></label>Usu&aacute;rio:<small>*</small></td><td><input type="text" name="dbuser" id="dbuser" value="<?php echo $dbuser;?>" size="35"></td></tr>
				<tr><td><label for="dbpass">Senha:<small>*</small></label></td><td><input type="password" name="dbpass" id="dbpass" value="<?php echo $dbpass;?>" size="35"></td></tr>
				<tr><td><label for="dbname">Nome do banco de dados:<small>*</small></label></td><td><input type="text" name="dbname" id="dbname" value="<?php echo $dbname;?>" size="35"></td></tr>
			</table>
		</fieldset>
		
		<fieldset>
			<legend>Envio de e-mail</legend>
			<table>
				<tr><td><label for="phpmailer">Usar o PHP Mailer?</label></td><td><input type="checkbox" name="phpmailer" id="phpmailer" value="phpmailer" <?php if ($phpmailer != "") {echo "checked=\"true\"";}?>"></td></tr>
				<tr><td colspan="2">Se usar o PHP Mailer, preencha os campos a seguir:</td></tr>
				<tr><td><label for="smtphost">Servidor de e-mail:</label></td><td><input type="text" name="smtphost" id="smtphost" value="<?php echo $_POST["smtphost"];?>" size="35"></td></tr>
				<tr><td><label for="smtpport"></label>Porta de SMTP:</td><td><input type="text" name="smtpport" id="smtpport" value="<?php echo $_POST["smtpport"];?>" size="35"></td></tr>
				<tr><td><label for="smtpauth"></label>Necess&aacute;rio autenticar?</td><td><input type="checkbox" name="smtpauth" id="smtpauth" value="smtpauth" <?php if ($smtpauth != "") {echo "checked=\"true\"";}?>"></td></tr>
				<tr><td><label for="smtpuser"></label>Usu&aacute;rio do servidor de e-mail:</td><td><input type="text" name="smtpuser" id="smtpuser" value="<?php echo $smtpuser;?>" size="35"></td></tr>
				<tr><td><label for="smtppwd"></label>Senha do usu&aacute;rio do servidor de e-mail:</td><td><input type="password" name="smtppwd" id="smtppwd" value="<?php echo $smtppwd;?>" size="35"></td></tr>
			</table>
		</fieldset>
        <p><small>*Campos obrigat&oacute;rios.</small></p>
		
		<input type="submit" value="Prosseguir">
	</form>
</div>

<?php
} else { // Não há permissão de escrita nos arquivos de configuração
?>
	<h1>Erro!</h1>
	<p>O usu&aacute;rio do servidor web n&atilde;o tem permiss&atilde;o de escrita para ao menos um dos arquivos:
	<ul>
		<li><code>inc/config.php</code></li>
		<li><code>restrito/inc/config.php</code></li>
		<li><code>instalar/index.php</code></li>
		<li><code>instalar/bd.php</code></li>
   	</ul>
	Edite a configura&ccedil;&atilde;o manualmente ou conceda permiss&atilde;o de escrita a esses arquivos.</p>
    <p>Para editar as configurações, renomeie os arquivos <code>config-exemplo.php</code> nas pastas <code>inc/config/</code> e <code>restrito/inc/</code> para <code>config.php</code> e informe em ambos os par&acirc;metros adequados. Depois, execute os <em>scripts</em> SQL no diret&oacute;rio <code>basedados</code>.</p>
	<p>Se proceder manualmente, exclua a pasta "instalar" e seu conte&uacute;do após a instalação.</p>
<?php
}
include("../inc/rodape.php");
?>
