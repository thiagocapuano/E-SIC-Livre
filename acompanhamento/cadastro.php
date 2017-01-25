<!--?xml version = "1.0" ?-->

<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

 include("manutencao.php");
 include_once("../inc/security.php");
 include("../inc/topo.php");
 
?>

<script language="JavaScript" src="../js/XmlHttpLookup.js"></script>

<script src="inc/js/functions.js"></script>
<h1>Informação da Solicitação</h1>
<br><br>
<script>
    function fechaTudo(){
        document.getElementById('lnDemanda1').style.display = 'none';
        document.getElementById('lnDemanda2').style.display = 'none';
        document.getElementById('lnDemanda3').style.display = 'none';
        document.getElementById('lnDemanda4').style.display = 'none';
        document.getElementById('lnDemanda5').style.display = 'none';
        document.getElementById('lnAnexos').style.display = 'none';
        document.getElementById('lnMovimentacoes').style.display = 'none';
        //if(isDefined(document.getElementById('lnListaRecursos')))
          //  document.getElementById('lnListaRecursos').style.display = 'none';
        
        //se tiver em andamento e nao for ultima instancia
        <?php if($situacao == "N" and $instancia != "U") {?>
             document.getElementById('btnRecurso').style.display = 'none';
             document.getElementById('btnEnviar').style.display = 'none';
        <?php }?>
        document.getElementById('lnRecurso1').style.display = 'none';
        document.getElementById('lnRecurso2').style.display = 'none';
    }
    
    function abreFechaDemanda()
    {
        if(document.getElementById('lnDemanda1').style.display == '')
        {
            document.getElementById('lnDemanda1').style.display = 'none';
            document.getElementById('lnDemanda2').style.display = 'none';
            document.getElementById('lnDemanda3').style.display = 'none';
            document.getElementById('lnDemanda4').style.display = 'none';
            document.getElementById('lnDemanda5').style.display = 'none';
        }
        else
        {
            document.getElementById('lnDemanda1').style.display = '';
            document.getElementById('lnDemanda2').style.display = '';
            document.getElementById('lnDemanda3').style.display = '';
            document.getElementById('lnDemanda4').style.display = '';
            document.getElementById('lnDemanda5').style.display = '';
        }
    }
    
    function abreFechaAnexos()
    {
        if(document.getElementById('lnAnexos').style.display == '')        
            document.getElementById('lnAnexos').style.display = 'none';
        else
            document.getElementById('lnAnexos').style.display = '';
    }
    

    function abreFechaMovimentacoes()
    {
        if(document.getElementById('lnMovimentacoes').style.display == '')        
            document.getElementById('lnMovimentacoes').style.display = 'none';
        else
            document.getElementById('lnMovimentacoes').style.display = '';
    }

    function abreFechaListaRecursos()
    {
        if(document.getElementById('lnListaRecursos').style.display == '')        
            document.getElementById('lnListaRecursos').style.display = 'none';
        else
            document.getElementById('lnListaRecursos').style.display = '';
    }


    function executaOperacao(acao)
    {
        if(confirm("Confirma operação?"))
        {
            document.getElementById("acao").value = acao;
            document.getElementById("formulario").submit();
        }
    }
    
    function preparaRecurso(){
        fechaTudo();
        document.getElementById("btnRecurso").style.display = 'none';
        document.getElementById("btnEnviar").style.display = '';
        document.getElementById("lnRecurso1").style.display = '';
        document.getElementById("lnRecurso2").style.display = '';
        document.getElementById('btnCancelar').style.display = '';
    }

    
    function cancelaAcao()
    {
        fechaTudo();
        document.getElementById('lnDemanda1').style.display = '';
        document.getElementById('lnDemanda2').style.display = '';
        document.getElementById('lnDemanda3').style.display = '';
        document.getElementById('lnDemanda4').style.display = '';
        document.getElementById('lnDemanda5').style.display = '';

        //se tiver em andamento e nao for ultima instancia
        <?php if($situacao == "N" and $instancia != "U")  {?>
             document.getElementById('btnRecurso').style.display = '';
             document.getElementById('btnEnviar').style.display = 'none';
        <?php }?>
        document.getElementById("lnRecurso1").style.display = 'none';
        document.getElementById("lnRecurso2").style.display = 'none';
            
        document.getElementById('btnCancelar').style.display = 'none';
    }
</script>
<form action="<?php echo SITELNK;?>acompanhamento/cadastro.php" id="formulario" method="post">

<div class="form-group">
            
<input type="hidden" name="fltnumprotocolo" value="<?php echo $fltnumprotocolo; ?>">
<input type="hidden" name="fltsolicitante" value="<?php echo $fltsolicitante; ?>">
<input type="hidden" name="fltsituacao" value="<?php echo $fltsituacao; ?>">
    
<input type="hidden" name="acao" id="acao" value="<?php echo $acao; ?>">

<input type="hidden" name="idsolicitacao" value="<?php echo $idsolicitacao; ?>">
<input type="hidden" name="idsecretariaresposta" value="<?php echo $idsecretariaresposta; ?>">
<input type="hidden" name="idsolicitante" id="idsolicitante" value="<?php echo $idsolicitante;?>">
<input type="hidden" name="idsolicitacaoorigem" value="<?php echo $idsolicitacaoorigem; ?>">
<input type="hidden" name="numeroprotocolo" value="<?php echo $numeroprotocolo; ?>">
<input type="hidden" name="instancia" id="instancia" value="<?php echo $instancia;?>">
<input type="hidden" name="idtiposolicitacao" id="idtiposolicitacao" value="<?php echo $idtiposolicitacao;?>">
<input type="hidden" name="recursosolicitado" id="recursosolicitado" value="<?php echo $recursosolicitado;?>">
<input type="hidden" name="situacao" id="situacao" value="<?php echo $situacao;?>">
<input type="hidden" name="textosolicitacao" id="textosolicitacao" value="<?php echo $textosolicitacao;?>">
<input type="hidden" name="formaretorno" id="formaretorno" value="<?php echo $formaretorno;?>">
<input type="hidden" name="dataprevisaorespota" id="dataprevisaorespota" value="<?php echo $dataprevisaorespota;?>">
<input type="hidden" name="datasolicitacao" id="datasolicitacao" value="<?php echo $datasolicitacao;?>">
<input type="hidden" name="datarecebimentosolicitacao" id="datarecebimentosolicitacao" value="<?php echo $datarecebimentosolicitacao;?>">
<input type="hidden" name="usuariorecebimento" id="usuariorecebimento" value="<?php echo $usuariorecebimento;?>">
<input type="hidden" name="dataprorrogacao" id="dataprorrogacao" value="<?php echo $dataprorrogacao;?>">
<input type="hidden" name="motivoprorrogacao" id="motivoprorrogacao" value="<?php echo $motivoprorrogacao;?>">
<input type="hidden" name="usuarioprorrogacao" id="usuarioprorrogacao" value="<?php echo $usuarioprorrogacao;?>">
<input type="hidden" name="dataresposta" id="dataresposta" value="<?php echo $dataresposta;?>">
<input type="hidden" name="resposta" id="resposta" value="<?php echo $resposta;?>">
<input type="hidden" name="usuarioresposta" id="usuarioresposta" value="<?php echo $usuarioresposta;?>">


<table align="center" cellpadding="0"  width="100%" cellspacing="1" class="tabDetalhe">
	<tr>
		<th align="left" width="100%" colspan="4" style="background-color: #abcdef" onclick="abreFechaDemanda()">DADOS DA SOLICITA&Ccedil;&Atilde;O </th>
	</tr>
	<tr id="lnDemanda1">
                <td align="left">
                    <b>N&uacute;mero Protocolo</b> <br>
                    &nbsp;&nbsp;<?php echo $numeroprotocolo; ?>
                </td>
                <td align="left">
                    <b>Tipo Solicita&ccedil;&atilde;o</b> <br>
                    &nbsp;&nbsp;<?php echo Solicitacao::getDescricaoTipoSolicitacao($idtiposolicitacao); ?>
                    <?php if(!empty($idsolicitacaoorigem)){?>
                    <a href="<?php echo SITELNK;?>acompanhamento/cadastro.php?codigo=<?php echo $idsolicitacaoorigem?>">[Visualizar Processo Origem]</a>
                    <?php }?>
                </td>
                <td align="left">
                    <b>Situa&ccedil;&atilde;o</b> <br>
                    &nbsp;&nbsp;<?php echo Solicitacao::getDescricaoSituacao($situacao); ?>
                </td>
                <td align="left">
                    <b>Forma Retorno</b> <br>
                    &nbsp;&nbsp;<?php echo Solicitacao::getDescricaoFormaRetorno($formaretorno);?>
                </td>
        </tr>
	<tr id="lnDemanda2">
                <td align="left" valign="top">
                    <b>Data da Solicita&ccedil;&atilde;o</b> <br>
                    &nbsp;&nbsp;<?php echo $datasolicitacao; ?>
                </td>
                <td align="left" valign="top">
                    <b>Previs&atilde;o Retorno</b> <br>
                    &nbsp;&nbsp;<?php echo $dataprevisaorespota; ?>
                </td>
                <td align="left" valign="top">
                    <b>Solicita&ccedil;&atilde;o Recebida em</b> <br>
                    &nbsp;&nbsp;<?php echo !empty($datarecebimentosolicitacao)?$datarecebimentosolicitacao." por ".$usuariorecebimento:"Não Recebido";?>
                </td>
                <td align="left" valign="top">
                    <b>Porroga&ccedil;&atilde;o</b> <br>
                    &nbsp;&nbsp;<?php echo !empty($dataprorrogacao)?"Prorrogado em: ".$dataprorrogacao." por ".$usuarioprorrogacao. "<br>&nbsp;&nbsp;Motivo: ".$motivoprorrogacao:"Não Prorrogado";?>
                </td>
        </tr>
        <tr id="lnDemanda3">
                <td align="left" colspan="4">
                    <b>Solicita&ccedil;&atilde;o</b><br>
					<pre>	<?php echo $textosolicitacao;?></pre>
				</td>
        </tr>
        <tr id="lnDemanda4">
                <td align="left" colspan="2">
                    <b>Data Resposta</b> <br>
                    &nbsp;&nbsp;<?php echo $dataresposta;?>
                </td>
                <td align="left" colspan="2">
                    <b>Respondido por</b> <br>
                    &nbsp;&nbsp;<?php echo $usuarioresposta; ?>
                </td>
	</tr>
        <tr id="lnDemanda5">
                <td align="left" colspan="4">
                    <b>Resposta</b><br>
					<pre><?php echo $resposta;?></pre>
				</td>
        </tr>
	<tr>
		<th align="left" colspan="6" onclick="abreFechaAnexos()" style="background-color: #abcdef">ANEXOS</th>
	</tr>
	<tr id="lnAnexos">
		<td width="100%" colspan="4">
                        <table align="center" width="100%" cellpadding="0" cellspacing="1" class="tabListaDetalhe">
                        <?php
                        $rsAnexo = execQuery("select * from lda_anexo where idsolicitacao=$idsolicitacao order by idanexo");
                        $i=0;
                        while($row = mysqli_fetch_array($rsAnexo)){
                            $i++;
                            ?>
                            <tr>
                                <td align="left"><a href="<?php echo getURL("lda")."/".$row['nome'];?>" target="_blank"><?php echo "Arquivo ".$i;?></a></td>
                            </tr>
                            <?php 
                        }?>
			</table>
		</td>
	</tr>
	<tr>
		<th align="left" colspan="4" style="background-color: #abcdef" onclick="abreFechaMovimentacoes()">MOVIMENTA&Ccedil;&Otilde;ES</th>
	</tr>
	<tr id="lnMovimentacoes">
		<td width="100%" colspan="4">
                        <table align="center" width="100%" cellpadding="0" cellspacing="1" class="tabListaDetalhe">
                        <tr>
                            <th>Data Envio</th>
                            <th>Usu&aacute;rio Envio</th>
                            <th>Destino</th>
                            <th>Data Recebimento</th>
                            <th>Usu&aacute;rio Recebimento</th>
                        </tr>
                        <?php
                        $rsMov = Solicitacao::getMovimentacao($idsolicitacao);
                        
                        while($row = mysqli_fetch_array($rsMov)){
                            ?>
                            <tr>
                                <td><?php echo bdToDate($row["dataenvio"]);?></td>
                                <td><?php echo $row["usuarioenvio"];?></td>
                                <td><?php echo $row["destino"];?></td>
                                <td><?php echo bdToDate($row["datarecebimento"]);?></td>
                                <td><?php echo $row["usuariorecebimento"];?></td>
                            </tr>
                            <?php 
                        }?>
			</table>
		</td>
	</tr>
        <?php 
        //$permiterecurso = true;
        $permiterecurso = Solicitacao::getPodeRecurso($idsolicitacao,$idsolicitacaoorigem);
        if($instancia == "I") { //se for solicitação inicial, mostra os recursos se houver
            
                $existerecurso = true;
                $rsRec = Solicitacao::getRecursos($idsolicitacao);










 if(mysqli_num_rows($rsRec) > 0)
                {
                    $permiterecurso = false;
                    ?>
                    <tr>
                            <th align="left" style="background-color: #abcdef" colspan="4" onclick="abreFechaListaRecursos()">RECURSOS</th>
                    </tr>
                    <tr id="lnListaRecursos">
                            <td width="100%" colspan="4">
                                    <table align="center" width="100%" cellpadding="0" cellspacing="1" class="tabListaDetalhe">
                                    <tr>
                                        <th>Data Solicita&ccedil;&atilde;o</th>
                                        <th>Recurso</th>
                                        <th>Situa&ccedil;&atilde;o</th>
                                        <th>Previs&atilde;o Resposta</th>
                                        <th>Data Resposta</th>
                                    </tr>
                                    <?php
                                    while($row = mysqli_fetch_array($rsRec)){
                                        ?>
                                        <tr>
                                            <td><?php echo bdToDate($row["datasolicitacao"]);?></td>
                                            <td><?php echo $row["tiposolicitacao"];?></td>
                                            <td><?php echo Solicitacao::getDescricaoSituacao($row["situacao"]);?></td>
                                            <td><?php echo bdToDate($row["dataprevisaoresposta"]);?></td>
                                            <td><?php echo bdToDate($row["dataresposta"]);?></td>
                                        </tr>
                                        <?php 
                                    }?>
                                    </table>
                            </td>
                    </tr>
                    <?php
                }
        }
        ?>
        <tr id="lnRecurso1" style="display: none">
                <td valign="top" align="left">Solicita&ccedil;&atilde;o de Recurso: </td>
                <td colspan="3" align="left"><textarea name="txttextosolicitacao" id="txttextosolicitacao" rows="10" cols="60" onkeyup="setMaxLength(4000,this);"><?php echo $txttextosolicitacao;?></textarea></td>
        </tr>
        <tr id="lnRecurso2" style="display: none">
                <td valign="top" align="left">Forma de retorno: </td>
                <td align="left" colspan="3">
                    <select name="txtformaretorno" id="txtformaretorno">
                            <option value="E" <?php echo $txtformaretorno=="E"?"selected":""; ?>>E-mail</option>		
                            <option value="C" <?php echo $txtformaretorno=="C"?"selected":""; ?>>Correio</option>		
                            <option value="F" <?php echo $txtformaretorno=="F"?"selected":""; ?>>Fax</option>		
                    </select>
                </td>  
        </tr>
	<tr>
		<td colspan="4">
                    <br>
                    <?php 
                    //com resposta negada ou não, e permitir recurso, pode ser possivel solicitar recurso
                    if( ($situacao == "N" or $situacao == "R") and $permiterecurso) 
                    { 
                        ?>
                        <input type="button" value="Solicitar Recurso" class="botaoformulario" name="recurso" id="btnRecurso" onclick="preparaRecurso();"/>
                        <input type="button" value="Enviar" class="botaoformulario" name="enviar" id="btnEnviar" onclick="executaOperacao(this.value);" style="display: none"/>
                        <?php 
                    } 
                    ?>    

                    <input type="button" value="Cancelar" class="botaoformulario" name="btnCancelar" id="btnCancelar" onclick="cancelaAcao();" style="display: none" />
                    <input type="button" value="Voltar" class="botaoformulario" name="voltar" onclick="location.href='<?php echo SITELNK;?>acompanhamento/index.php?<?php echo $parametrosIndex;?>'" />
		</td>
	</tr>
</table>
</form>

<?php if($situacao == "N" or $situacao == "R"){?>
    <br><br>
    <iframe src="../enquete/" height="400" width="800" frameborder="0" />
<?php }?>

<?php 
if($acao == "Enviar")
{
    echo "<script>preparaRecurso();</script>";
}
getErro($erro);

  include_once("../inc/security.php");
include("../inc/rodape.php"); 
?>
