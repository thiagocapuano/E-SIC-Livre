<?php
include("../inc/topo.php");
?>

<div id="principal">
	<h1>e-SIC Livre instalado!</h1>

	<p>O e-SIC Livre foi instalado com sucesso. Clique <a href="../restrito/">aqui</a> para acessar a &aacute;rea administrativa e continuar a configura&ccedil;&atilde;o.</p>
<?php
try {
	unlink("index.php");
	unlink("bd.php");
} catch (Exception $e) {
?>
	<p><strong>Aten&ccedil;&atilde;o!</strong>< N&atilde;o foi poss&iacute;vel remover os arquivos de instala&ccedil;&atilde;o. Para sua segurança, remova manualmente os arquivos <pre><?php echo join(DIRECTORY_SEPARATOR, array(dirname(__FILE__), "index.php")); ?></pre> e <pre><?php echo join(DIRECTORY_SEPARATOR, array(dirname(__FILE__), "bd.php")); ?></pre></p>
<?php
}
?>

<?php
include("../inc/rodape.php");
?>