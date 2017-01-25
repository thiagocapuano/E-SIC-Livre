<?php

require_once("../inc/config.php");


if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if ($_POST["etapa"] > 0) { // Executa cada carregamento
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$mysqli = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
		$mysqli->autocommit(false);
		try {
			if ($_POST["etapa"] != 3) { // Carrega tudo de uma vez
				$mysqli->multi_query(file_get_contents(join(DIRECTORY_SEPARATOR, array(dirname(dirname(__FILE__)), "basedados", "dbesiclivre")).($_POST["etapa"]).".sql"));
			} else {
				$comandos = explode(";", file_get_contents(join(DIRECTORY_SEPARATOR, array(dirname(dirname(__FILE__)), "basedados", "dbesiclivre")).($_POST["etapa"]).".sql"));
				foreach ($comandos as $c) {
					if (!ctype_space($c)) { // Evita erro "1065 - Query was empty"
						$mysqli->query($c);
					}
				}
				$mysqli->query("COMMIT;");
			}
		echo "Etapa ".$_POST["etapa"]." finalizada com sucesso.";
		die();
		} catch (Exception $e) {
			echo $e->getCode()." - ".$e->getMessage();
			http_response_code(500);
			die();
		}
	} else { // PÃ¡gina que irÃ¡ demandar o carregamento
		include("../inc/topo.php");
?>

	<div id="principal">
		<h1>Instala&ccedil;&atilde;o do e-SIC Livre</h1>
        <h2>Passo 2 de 2</h2>
        <h3>Instalando o banco de dados</h3>
        
        <p>Aguarde enquanto o sistema instala o banco de dados.</p>
        <ul>
            <li>Cria&ccedil;&atilde;o da estrutura b&aacute;sica: <span id="ok1">aguardando&hellip;</span></li>
            <li>Carregamento da informa&ccedil;&atilde;o geogr&aacute;fica: <span id="ok2">aguardando&hellip;</span></li>
            <?php if ($_POST["cep"] == "cep") { ?><li>Carregamento da base de CEP, logradouros e bairros: <span id="ok3">aguardando&hellip;</span></li><?php } ?>
        </ul>
	</div>

<script src="../js/jquery.js" type="text/javascript"></script>

<script type="text/javascript">
	var etapas = <?php  echo ($_POST["cep"] == "cep" ? 3 : 2); ?>;
	var etapa = 1;

	var concluido = function(data) {
		console.log("Ok: "+data.responseText);
		$("#ok"+etapa).html("conclu&iacute;do.");
		if (etapa < etapas) {
			etapa += 1; executar();
		} else {
			window.location = window.location.href.substr(0, window.location.href.length-6) + "fim.php";
		}
	};
	
	var erro = function(data) {
		$("#ok"+etapa).html("<strong>ERRO</strong> (\""+data.responseText+"\").");
	}
	
	var executar = function() {
		$("#ok"+etapa).html("executando&hellip;");
		$.post("bd.php", {"etapa": etapa}, concluido).fail(erro);
	};
	
	$(document).ready(function() {        
		executar();
    });
</script>

<?php
		include("../inc/rodape.php");
	}
} else {
	include("../inc/topo.php");
?>
	<div id="principal">
		<h1>Instala&ccedil;&atilde;o do e-SIC Livre</h1>
        <h2>Passo 2 de 2</h2>
        <h3>Instalando o banco de dados</h3>
        
        <p><strong>Aten&ccedil;&atilde;o!</strong> Para prosseguir, verifique se o banco de dados <code><?php echo DBNAME; ?></code> existe e se o usu&aacute;rio <code><?php echo DBUSER; ?></code> det&eacute;m todas as permiss&otilde;es para ele.</p>
        
        <form action="bd.php" method="post">
        	<p><input type="checkbox" name="cep" value="cep" id="cep" checked><label for="cep">Carregar informações de CEP, logradouros e bairros.</label></p>
            <input type="hidden" value="0" name="etapa">
            <input type="submit" value="Prosseguir" id="prosseguir" onClick="document.getElementById('prosseguir').disabled = false;">
			
        </form>	
		<!--form action="bd2.php" method="post">
        <input type="submit" name="prosseguir0"  value="Proseguir v2">
		</form-->	
    </div>

<?php
	include("../inc/rodape.php");
}

?>
