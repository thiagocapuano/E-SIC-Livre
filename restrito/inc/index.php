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

<h1>Cadastro do Solicitante</h1>
<div id="principal">
<?php if(!empty($_GET['r'])){?>
          Cadastro Realizado com sucesso! <br><br>
          Em instantes você receberá uma solicitação de confirmação do cadastro no seu e-mail: <?php echo $_GET['r']?>.<br>
<?php }else{?>
        <form action="<?php echo URL_BASE_SISTEMA;?>cadastro/index.php" id="formulario" method="post">
        <?php include_once("../cadastro/formulario.php");?>
        </form>
        <?php 
        getErro($erro);
		
}
?>
</div>
<?php
include("../inc/rodape.php"); 
?>
