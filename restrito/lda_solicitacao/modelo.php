<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

 include("manutencao.php");
 include("../inc/topo.php");
 $urlArquivo = getURL("lda");
?>

<script language="JavaScript" src="../js/XmlHttpLookup.js"></script>

<script src="inc/js/functions.js"></script>
<h1>Informa&ccedil;&otilde;es de Solicita&ccedil;&atilde;o</h1>
<br><br>
<script>
    
    function abreFechaListaRecursos()
    {
        if(document.getElementById('lnListaRecursos').style.display == '')        
            document.getElementById('lnListaRecursos').style.display = 'none';
        else
            document.getElementById('lnListaRecursos').style.display = '';
    };
    
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
    };
    
    function abreFechaAnexos()
    {
        if(document.getElementById('lnAnexos').style.display == '')        
            document.getElementById('lnAnexos').style.display = 'none';
        else
            document.getElementById('lnAnexos').style.display = '';
    }
    
    function abreFechaSolicitante()
    {
        if(document.getElementById('lnSolicitante1').style.display == '')        
        {
            document.getElementById('lnSolicitante1').style.display = 'none';
            document.getElementById('lnSolicitante2').style.display = 'none';
            document.getElementById('lnSolicitante3').style.display = 'none';
            document.getElementById('lnSolicitante4').style.display = 'none';
        }
        else
        {
            document.getElementById('lnSolicitante1').style.display = '';
            document.getElementById('lnSolicitante2').style.display = '';
            document.getElementById('lnSolicitante3').style.display = '';
            document.getElementById('lnSolicitante4').style.display = '';
        }
    };

    function abreFechaMovimentacoes()
    {
        if(document.getElementById('lnMovimentacoes').style.display == '')        
            document.getElementById('lnMovimentacoes').style.display = 'none';
        else
            document.getElementById('lnMovimentacoes').style.display = '';
    };


    function executaOperacao(acao)
    {
        if(confirm("Confirma operação?"))
        {
            document.getElementById("acao").value = acao;
            document.getElementById("formulario").submit();
        }
    }
    
</script>
    
<table align="center" cellpadding="0"  width="100%" cellspacing="1" class="tabDetalhe">
	<tr>
		<th align="left" width="100%" colspan="4" style="background-color: #abcdef" onclick="abreFechaDemanda()">DADOS DA SOLICITA&Ccedil;&Atilde;O </th>
	</tr>
	<tr id="lnDemanda1">
                <td align="left">
                    <b>Numero Protocolo</b> <br>
                    &nbsp;&nbsp;<?php echo $numeroprotocolo; ?>
                </td>
                <td align="left">
                    <b>Tipo Solicita&ccedil;&atilde;o</b> <br>
                    &nbsp;&nbsp;<?php echo Solicitacao::getDescricaoTipoSolicitacao($idtiposolicitacao); ?>
                    <?php if(!empty($idsolicitacaoorigem)){?>
                    <a href="visualizar.php?codigo=<?php echo $idsolicitacaoorigem?>">[Visualizar Processo Origem]</a>
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
                    &nbsp;&nbsp;<?php echo $textosolicitacao;?>
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
                    &nbsp;&nbsp;<?php echo $resposta;?>
                </td>
        </tr>
	<tr>
		<th align="left" colspan="4" style="background-color: #abcdef" onclick="abreFechaSolicitante()">DADOS DO SOLICITANTE</th>
	</tr>
	<tr id="lnSolicitante1">
                <td align="left">
                    <b>Solicitante</b> <br>
                    &nbsp;&nbsp;<?php echo $nome; ?>
                </td>
                <td align="left">
                    <b>CPF/CNPJ</b> <br>
                    &nbsp;&nbsp;<?php echo $cpfcnpj; ?>
                </td>
                <td align="left">
                    <b>E-mail</b> <br>
                    &nbsp;&nbsp;<?php echo $email; ?>
                </td>
                <td align="left">
                    <b>Telefone</b> <br>
                    &nbsp;&nbsp;<?php echo !empty($telefone)?$tipotelefone.": (".$dddtelefone.") ".$telefone:"";?>
                </td>
        </tr>
	<tr id="lnSolicitante2">
                <td align="left">
                    <b>Profiss&atilde;o</b> <br>
                    &nbsp;&nbsp;<?php echo $profissao; ?>
                </td>
                <td align="left">
                    <b>Escolaridade</b> <br>
                    &nbsp;&nbsp;<?php echo $escolaridade; ?>
                </td>
                <td align="left" colspan="2">
                    <b>Faixa Et&aacute;ria</b> <br>
                    &nbsp;&nbsp;<?php echo $faixaetaria; ?>
                </td>
        </tr>
        <tr id="lnSolicitante3">
                <td align="left" colspan="2">
                    <b>Endere&ccedil;o</b> <br>
                    &nbsp;&nbsp;<?php echo $logradouro; ?>
                </td>
                <td align="left">
                    <b>Numero</b> <br>
                    &nbsp;&nbsp;<?php echo $numero; ?>
                </td>
                <td align="left">
                    <b>CEP</b> <br>
                    &nbsp;&nbsp;<?php echo $cep; ?>
                </td>
        </tr>
        <tr id="lnSolicitante4">
                <td align="left" colspan="2">
                    <b>Bairro</b> <br>
                    &nbsp;&nbsp;<?php echo $bairro; ?>
                </td>
                <td align="left" colspan="2">
                    <b>Cidade/UF</b> <br>
                    &nbsp;&nbsp;<?php echo $cidade."/".$uf; ?>
                </td>
        </tr>
	<tr>
		<th align="left" colspan="6" style="background-color: #abcdef" onclick="abreFechaAnexos()">ANEXOS</th>
	</tr>
	<tr id="lnAnexos">
		<td width="100%" colspan="6">
                        <table align="center" width="100%" cellpadding="0" cellspacing="1">
                        <?php
                        $rsAnexo = execQuery("select * from lda_anexo where idsolicitacao=$idsolicitacao order by idanexo");
                        $i=0;
                        while($row = mysqli_fetch_array($rsAnexo)){
                            $i++;
                            ?>
                            <tr>
                                <td align="left"><a href="<?php echo $urlArquivo."/".$row['nome'];?>" target="_blank"><?php echo "Arquivo ".$i;?></a></td>
                            </tr>
                            <?php 
                        }?>
			</table>
		</td>
	</tr>
        <?php if($instancia == "I") { //se for solicitação inicial, mostra os recursos se houver
            
                $rsRec = Solicitacao::getRecursos($idsolicitacao);
                if(mysqli_num_rows($rsRec) > 0)
                {
                    ?>
                    <tr>
                            <th align="left" colspan="4" onclick="abreFechaListaRecursos()">RECURSOS</th>
                    </tr>
                    <tr id="lnListaRecursos">
                            <td width="100%" colspan="4">
                                    <table align="center" width="100%" cellpadding="0" cellspacing="1">
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
        }?>
                
	<tr>
		<th align="left" colspan="4" style="background-color: #abcdef" onclick="abreFechaMovimentacoes()">MOVIMENTA&Ccedil;&Otilde;ES</th>
	</tr>
	<tr id="lnMovimentacoes">
		<td width="100%" colspan="4">
                        <table align="center" width="100%" cellpadding="0" cellspacing="1">
                        <tr>
                            <th>Data Envio</th>
                            <th>Usu&aacute;rio Envio</th>
                            <th>Destino</th>
                            <th>Data Recebimento</th>
                            <th>Usu&aacute;rio Recebimento</th>
                            <th>Despacho</th>
                            <th>Anexo</th>
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
                                <td><?php echo $row["despacho"];?></td>
                                <td>
                                    <?php if (!empty($row['arquivo'])){?>
                                        <a href="<?php echo $urlArquivo."/".$row['arquivo'];?>" target="_blank"><?php echo "Baixar";?></a>
                                    <?php } else {?>
                                        -
                                    <?php }?>
                                </td>
                            </tr>
                            <?php 
                        }?>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="4">
                    <br>
                    <input type="button" value="Voltar" class="botaoformulario" name="voltar" onclick="history.back()" />
		</td>
	</tr>
</table>

<?php
include("../inc/rodape.php"); 
?>