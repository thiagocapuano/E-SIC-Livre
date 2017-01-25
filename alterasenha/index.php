<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

 include("manutencao.php");
 
 include("../inc/topo.php");
?>
<h1>Redefini&ccedil;&atilde;o de Senha</h1>
<br><br>
<form action="<?php echo SITELNK;?>alterasenha/index.php" id="formulario" method="post">
<table id="tabelaSolucaoCidada" align="center" cellpadding="0" cellspacing="1">
	<tr>
		<td><b>Senha atual:</b></td>
		<td><input type="password" name="senhaatual" size="50" maxlength="50" /> </td>
	</tr>
	<tr>
		<td><b>Nova senha:</b></td>
		<td><input type="password" name="novasenha" size="50" maxlength="50" /> </td>
	</tr>
	<tr>
		<td><b>Confirme a nova senha:</b></td>
		<td><input type="password" name="confirmasenha" size="50" maxlength="50" /> </td>
	</tr>			
	<tr><td colspan="2"><td></tr>
	<tr>
		<td colspan="2" align="center" style="border-top:1px solid #000000">
			<br><input type="submit" value="Alterar" class="botaoformulario" name="acao" />
		</td>
	</tr>
</table>

</form>
<?php 
getErro($erro);
include("../inc/rodape.php");?>