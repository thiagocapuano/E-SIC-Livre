<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

 require_once("manutencao.php");
 require_once("../inc/topo.php");
?>

<h1>Formulário de Solicitação de Informação</h1>
<br>
<?php 
if (empty($_GET['ok'])){
    ?>
    Descreva de forma detalhada sua solicitação<br>
    <form action="<?php echo SITELNK ;?>solicitacao/index.php" id="formulario" method="post"  enctype="multipart/form-data">
    <?php include_once("../solicitacao/formulario.php");?>
    </form>
    <?php 
    getErro($erro);
}
else
{
    ?><br>Solitação cadastrada com sucesso.<?php
}
include("../inc/rodape.php"); 
?>
