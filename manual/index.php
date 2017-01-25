<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.

 Copyright (C) 2014 Prefeitura Municipal do Natal

 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
 ***********************************************************************************/
require_once("../inc/security.php");

//require_once('../class/recaptchalib.php');

$login 		= $_POST["login"];
$password 	= $_POST["password"];
$tipo 		= $_REQUEST['t'];
$msg 		= "";

if(usaRecaptcha($login))
	$usarecap = true;
else
	$usarecap = false;


if ($_POST['btsub'])
{

	if($usarecap)
	{
		$error = null;
		//$recaptcha_ok = checkRecaptcha($error);
                $recaptcha_ok = (strtoupper($_POST["palavra"]) == strtoupper($_SESSION["palavra"]));
	}
	else
		$recaptcha_ok = true;
	
	if($recaptcha_ok)
	{
		if(autentica($login, $password, $tipo)) 
		{
			Redirect("../solicitacao");	
		}
		else 
		{
			$msg = "<font color='red'>Erro: falha no login.</font>";
			$usarecap = true;
		}
	} 
	else
		$msg = "<font color='red'>Erro: falha no login.</font>";
}




include("../inc/topo.php"); 
?>
        <div id="principal">
		<div id="migalha_de_Pao"> Você está em: Manual; </div>
<!-- #####################################################################################################################
parte de codigo aparentemente desnecessaria em manual 
			<div id="banner">
				<img src="../css/img/sic.png" alt="Imagem E-sic Livre"/>
			</div>
<?php /* #############################           
                        <?php  if (empty($_SESSION[SISTEMA_CODIGO])) { ?>
			<div id="login">
				<form action="index.php" method="post">
				<div class="titulo_caixa_login"> Acesse o sistema</div>
				<span class="Mensagem">Preencha o Nome do Usu&aacute;rio e senha para acessar o Sistema de Informa&ccedil;&otilde;es.</span>
				
				<div id="campos">
					<table cellpadding="1" cellspacing="5" width="80%">
						<tr align="right">
							<td>
								<span class="labelLogin"><label for="login">Usu&aacute;rio: </label> </span>
							</td>
							<td>
								<span class="inputLogin"><input type="text" name="login" maxlength="20"> </span>
							</td>
						</tr>
						<tr align="right">	
							<td>
								<span class="labelLogin"><label for="Senha">Senha: </LABEL> </span>
							</td>
							<td>
								<span class="inputLogin"><input type="password" name="password" maxlength="100"> </span>	
							</td>							
						</tr>
						<?php /*if ($usarecap) echo '<tr>
							<td colspan="2">'.recaptcha_get_html(PUBLIC_KEY, $error).'<td>
						<tr>' ; */?>
<?php /* #########################################
                                                <?php if ($usarecap) { ?>
                                                <tr>
                                                    <td colspan="2" align="right">
                                                        <br>
                                                        <img src="../inc/captcha.php?l=150&a=50&tf=20&ql=5" id="imgcaptcha">
                                                        <img src="../img/refresh.gif" title="Clique aqui para recarregar a imagem" alt="Clique aqui para recarregar a imagem" onclick="getElementById('imgcaptcha').src ='../inc/captcha.php?l=150&a=50&tf=20&ql=5';">
                                                        <br><span class="labelLogin">Informe o c&oacute;digo acima:</span><br><input type="text" name="palavra"  />
                                                    </td>
                                                </tr>
                                                <?php } ?>

                                                <tr align="right">
							<td>
							</td>
							<td>
								<br><input type="submit" class="inputBotao" name="btsub" value="Entrar">
							</td>
						</tr>						
						<tr align="right">
							<td colspan="2">
								<a class="class_cadastrese" href="../cadastro">Cadastre-se</a> | 
								<a class="class_senha" href="../reset">Esqueci a senha</a>
							</td>
						</tr>
					</table>						
				</div>
				
				</form>
			</div>
                        <?php } else {?>
                        <div id="login">
				<span class="Mensagem">
                                    <br>
                                    Ol&aacute; <?php echo getSession("nomeusuario");?>! 
                                    <br><br>
                                    Caso n&atilde;o seja voc&ecirc; [<a href="../index/logout.php" class="class_cadastrese">clique aqui</a>]
                                </span>                            
                        </div>
                        <?php } ?>
		</div>

*/ ?>
#######################################-->					
        <div id="notificacoes">
			<div id="linha"></div>
			
			<div id="links">
				<table width="100%">
					<tr>
						<th width="40%">
							SIC - Serviço de informação ao Cidadão	
						</th>
						<th width="30%">
							Lei de Acesso
						</th>
						<th width="30%">
							Links Úteis
						</th>
					</tr>
					<tr>
						<td>
							<a href="../manual/informacao.php">Como pedir uma informação</a>
						</td>
						<td>
							<a href="../manual/decreto.php">Decreto</a>
						</td>
						<td>
							<a href="http://www.acessoainformacao.gov.br/acessoainformacaogov/">Acesso à informação CGU</a>
						</td>						
					</tr>
					<tr>
						<td>
							<a href="../manual/pedido.php">Como acompanhar seu pedido</a>
						</td>
						<td>
							<a href="../manual/LegislacaoRelacionada.php">Legislação relacionada</a>
						</td>
						<td>
							<a href="http://portal2.tcu.gov.br/portal/page/portal/TCU/transparencia">Acesso à informação TCU</a>
						</td>						
					</tr>
					<tr>
						<td>
							<a href="../manual/recurso.php">Como entrar com um recurso</a>
						</td>
						<td>
							Leis
						</td>
						<td>
							
						</td>
					</tr>					
				</table>			
			</div>
                        <?php include("../inc/rodape.php"); ?>
			<div id="postagens"></div>
        </div>
