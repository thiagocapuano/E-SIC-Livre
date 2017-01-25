<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

include("manutencao.php");
$urlArquivo=getURL("lda");
 
?>

<script language="JavaScript" src="../js/XmlHttpLookup.js"></script>

<script src="inc/js/functions.js"></script>
<div class="container-fluid">
    <header class="header-title">
        <h1>Movimentação da Solicitação</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo URL_BASE_SISTEMA; ?>index/">Início</a></li>
            <li><a href="<?php echo URL_BASE_SISTEMA; ?>index/?lda_solicitacao">Solicitação</a></li>
            <li class="active">Movimentação da Solicitação</li>
        </ol>
    </header>
</div>
<script>
    function fechaTudo(){
        document.getElementById('lnDemanda1').style.display = 'none';
        document.getElementById('lnDemanda2').style.display = 'none';
        document.getElementById('lnDemanda3').style.display = 'none';
        document.getElementById('lnDemanda4').style.display = 'none';
        document.getElementById('lnDemanda5').style.display = 'none';
        //document.getElementById('lnAnexos').style.display = 'none';
        document.getElementById('lnSolicitante1').style.display = 'none';
        document.getElementById('lnSolicitante2').style.display = 'none';
        document.getElementById('lnSolicitante3').style.display = 'none';
        document.getElementById('lnSolicitante4').style.display = 'none';
        document.getElementById('lnMovimentacoes').style.display = 'none';
        
        <?php if(checkPerm("LDAMOVIMENTAR",false) and $situacao != "N" and $situacao != "R") {?>
             document.getElementById('btnMovimentar').style.display = 'none';
             document.getElementById('btnEnviar').style.display = 'none';
        <?php }?>
            
        <?php if(checkPerm("LDARESPONDER",false) and $situacao != "N" and $situacao != "R") {?>
             document.getElementById('btnResponder').style.display = 'none';
             document.getElementById('btnFinalizar').style.display = 'none';
        <?php }?>            
        document.getElementById('lnFinalizar1').style.display = 'none';
        document.getElementById('lnFinalizar2').style.display = 'none';
        document.getElementById('lnFinalizar3').style.display = 'none';
        document.getElementById('lnFinalizar4').style.display = 'none';
        document.getElementById('lnMovimentar').style.display = 'none';
        document.getElementById('lnProrrogar1').style.display = 'none';
        document.getElementById('lnProrrogar2').style.display = 'none';

        //exibe botão de reabrir se:  
        <?php if(checkPerm("LDAPRORROGAR",false)  //tiver permissao de prorrogar 
                 and $situacao != "N" and $situacao != "R"    //situação for "finalizado"
                 and empty($dataprorrogacao))  { ?>
             document.getElementById('btnProrrogacao').style.display = 'none';
             document.getElementById('btnProrrogar').style.display = 'none';
        <?php }?>            


    };
    
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
    
    /*function abreFechaAnexos()
    {
        if(document.getElementById('lnAnexos').style.display == '')        
            document.getElementById('lnAnexos').style.display = 'none';
        else
            document.getElementById('lnAnexos').style.display = '';
    };*/
    
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


    function executaOperacao(acao, id)
    {
        if(confirm("Confirma operação?"))
        {
            document.getElementById(id).disabled = true;
            document.getElementById("acao").value = acao;
            document.getElementById("formulario").submit();
        }
    }
    
    function preparaMovimentacao(){
        fechaTudo();
        document.getElementById("btnMovimentar").style.display = 'none';
        document.getElementById("btnEnviar").style.display = '';
        document.getElementById("lnMovimentar").style.display = '';
        document.getElementById('btnCancelar').style.display = '';
    }

    function preparaFinalizacao(){
        fechaTudo();
        
        document.getElementById("btnResponder").style.display = 'none';
        document.getElementById("btnFinalizar").style.display = '';
        document.getElementById("lnFinalizar1").style.display = '';
        document.getElementById("lnFinalizar2").style.display = '';
        document.getElementById("lnFinalizar3").style.display = '';
        document.getElementById("lnFinalizar4").style.display = '';
        document.getElementById('btnCancelar').style.display = '';
    }
    
    function preparaProrrogacao(){
        fechaTudo();
        
        document.getElementById("btnProrrogacao").style.display = 'none';
        document.getElementById("btnProrrogar").style.display = '';
        document.getElementById("lnProrrogar1").style.display = '';
        document.getElementById("lnProrrogar2").style.display = '';
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

        <?php if(checkPerm("LDAMOVIMENTAR",false) and $situacao != "N" and $situacao != "R") {?>
             document.getElementById('btnMovimentar').style.display = '';
             document.getElementById('btnEnviar').style.display = 'none';
        <?php }?>
            
        <?php if(checkPerm("LDARESPONDER",false) and $situacao != "N" and $situacao != "R") {?>
             document.getElementById('btnResponder').style.display = '';
             document.getElementById('btnFinalizar').style.display = 'none';
        <?php }?>            

        //exibe botão de reabrir se:  
        <?php if(checkPerm("LDAPRORROGAR",false)  //tiver permissao de prorrogar 
                 and $situacao != "N" and $situacao != "R"    //situação for "finalizado"
                 and empty($dataprorrogacao)) { ?>
             document.getElementById('btnProrrogar').style.display = 'none';
             document.getElementById('btnProrrogacao').style.display = '';
        <?php }?>            

        document.getElementById('btnCancelar').style.display = 'none';
    }
</script>
<form action="index.php?lda_solicitacao&p=movimentacao" id="formulario" method="post" enctype="multipart/form-data">
            
<input type="hidden" name="fltnumprotocolo" value="<?php echo $fltnumprotocolo; ?>">
<input type="hidden" name="fltsolicitante" value="<?php echo $fltsolicitante; ?>">
<input type="hidden" name="fltsituacao" value="<?php echo $fltsituacao; ?>">
    
<input type="hidden" name="acao" id="acao" value="<?php echo $acao; ?>">

<input type="hidden" name="idsolicitacao" value="<?php echo $idsolicitacao; ?>">
<input type="hidden" name="idsolicitante" id="idsolicitante" value="<?php echo $idsolicitante;?>">
<input type="hidden" name="idsolicitacaoorigem" value="<?php echo $idsolicitacaoorigem; ?>">
<input type="hidden" name="numeroprotocolo" value="<?php echo $numeroprotocolo; ?>">
<input type="hidden" name="idtiposolicitacao" id="idtiposolicitacao" value="<?php echo $idtiposolicitacao;?>">
<input type="hidden" name="instancia" id="instancia" value="<?php echo $instancia;?>">
<input type="hidden" name="situacao" id="situacao" value="<?php echo $situacao;?>">
<input type="hidden" name="textosolicitacao" id="textosolicitacao" value="<?php echo $textosolicitacao;?>">
<input type="hidden" name="formaretorno" id="formaretorno" value="<?php echo $formaretorno;?>">
<input type="hidden" name="logradouro" id="logradouro" value="<?php echo $logradouro;?>">
<input type="hidden" name="numero" id="numero" value="<?php echo $numero;?>">
<input type="hidden" name="complemento" id="complemento" value="<?php echo $complemento;?>">
<input type="hidden" name="cep" id="cep" value="<?php echo $cep;?>">
<input type="hidden" name="cidade" id="cidade" value="<?php echo $cidade;?>">
<input type="hidden" name="bairro" id="bairro" value="<?php echo $bairro;?>">
<input type="hidden" name="uf" id="estadosolicitante" value="<?php echo $uf;?>">
<input type="hidden" name="tipotelefone" id="tipotelefone" value="<?php echo $tipotelefone;?>">
<input type="hidden" name="dddtelefone" id="dddtelefone" value="<?php echo $dddtelefone;?>">
<input type="hidden" name="telefone" id="telefone" value="<?php echo $telefone;?>">
<input type="hidden" name="email" id="email" value="<?php echo $email;?>">
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
<input type="hidden" name="nome" id="nome" value="<?php echo $nome;?>">
<input type="hidden" name="profissao" id="profissao" value="<?php echo $profissao;?>">
<input type="hidden" name="cpfcnpj" id="cpfcnpj" value="<?php echo $cpfcnpj;?>">
<input type="hidden" name="escolaridade" id="escolaridade" value="<?php echo $escolaridade;?>">
<input type="hidden" name="faixaetaria" id="faixaetaria" value="<?php echo $faixaetaria;?>">



<div class="container-fluid">
    <table align="center" cellpadding="0" width="100%" cellspacing="1" class="tabDetalhe table">
        <tr>
            <th align="left" width="100%" colspan="4" onclick="abreFechaDemanda()">DADOS DA SOLICITA&Ccedil;&Atilde;O </th>
        </tr>
        <tr id="lnDemanda1">
            <td align="left">
                <b>Numero Protocolo</b>
                <br>
                <?php echo $numeroprotocolo; ?>
            </td>
            <td align="left">
                <b>Tipo Solicita&ccedil;&atilde;o</b>
                <br>
                <?php echo Solicitacao::getDescricaoTipoSolicitacao($idtiposolicitacao); ?>
                <?php if(!empty($idsolicitacaoorigem)){?>
                <a href="?lda_solicitacao&p=visualizar&codigo=<?= $idsolicitacaoorigem?>&tk=<?= md5($idsolicitacaoorigem.SIS_TOKEN) ?>">[Visualizar Processo Origem]</a>
                <?php }?>
            </td>
            <td align="left">
                <b>Situa&ccedil;&atilde;o</b>
                <br>
                <?php echo Solicitacao::getDescricaoSituacao($situacao); ?>
            </td>
            <td align="left">
                <b>Sistema</b>
                <br>
                <?php 
					echo $sistemaOrigem;
					//echo Solicitacao::getDescricaoFormaRetorno($formaretorno);
				?>
            </td>
        </tr>
        <tr id="lnDemanda2">
            <td align="left" valign="top">
                <b>Data da Solicita&ccedil;&atilde;o</b>
                <br>
                <?php echo $datasolicitacao; ?>
            </td>
            <td align="left" valign="top">
                <b>Previs&atilde;o Retorno</b>
                <br>
                <?php echo $dataprevisaorespota; ?>
            </td>
            <td align="left" valign="top">
                <b>Solicita&ccedil;&atilde;o Recebida em</b>
                <br>
                <?php echo !empty($datarecebimentosolicitacao)?$datarecebimentosolicitacao." por ".$usuariorecebimento:"Não Recebido";?>
            </td>
            <td align="left" valign="top">
                <b>Porroga&ccedil;&atilde;o</b>
                <br>
                <?php echo !empty($dataprorrogacao)?"Prorrogado em: ".$dataprorrogacao." por ".$usuarioprorrogacao. "<br>Motivo: ".$motivoprorrogacao:"Não Prorrogado";?>
            </td>
        </tr>
        <tr id="lnDemanda3">
            <td align="left" colspan="4">
                <b>Solicita&ccedil;&atilde;o</b>
                <br>
                <?php echo $textosolicitacao;?>
            </td>
        </tr>
        <tr id="lnDemanda4">
            <td align="left" colspan="2">
                <b>Data Resposta</b>
                <br>
                <?php echo $dataresposta;?>
            </td>
            <td align="left" colspan="2">
                <b>Respondido por</b>
                <br>
                <?php echo $usuarioresposta; ?>
            </td>
        </tr>
        <tr id="lnDemanda5">
            <td align="left" colspan="4">
                <b>Resposta</b>
                <br>
                <?php echo $resposta;?>
            </td>
        </tr>
        <tr>
            <th align="left" colspan="4" onclick="abreFechaSolicitante()">DADOS DO SOLICITANTE</th>
        </tr>
        <tr id="lnSolicitante1">
            <td align="left">
                <b>Solicitante</b>
                <br>
                <?php echo $nome; ?>
            </td>
            <td align="left">
                <b>CPF/CNPJ</b>
                <br>
                <?php echo $cpfcnpj; ?>
            </td>
            <td align="left">
                <b>E-mail</b>
                <br>
                <?php echo $email; ?>
            </td>
            <td align="left">
                <b>Telefone</b>
                <br>
                <?php echo !empty($telefone)?$tipotelefone.": (".$dddtelefone.") ".$telefone:"";?>
            </td>
        </tr>
        <tr id="lnSolicitante2">
            <td align="left">
                <b>Profiss&atilde;o</b>
                <br>
                <?php echo $profissao; ?>
            </td>
            <td align="left">
                <b>Escolaridade</b>
                <br>
                <?php echo $escolaridade; ?>
            </td>
            <td align="left" colspan="2">
                <b>Faixa Et&aacute;ria</b>
                <br>
                <?php echo $faixaetaria; ?>
            </td>
        </tr>
        <tr id="lnSolicitante3">
            <td align="left" colspan="2">
                <b>Endere&ccedil;o</b>
                <br>
                <?php echo $logradouro; ?>
            </td>
            <td align="left">
                <b>Numero</b>
                <br>
                <?php echo $numero; ?>
            </td>
            <td align="left">
                <b>CEP</b>
                <br>
                <?php echo $cep; ?>
            </td>
        </tr>
        <tr id="lnSolicitante4">
            <td align="left" colspan="2">
                <b>Bairro</b>
                <br>
                <?php echo $bairro; ?>
            </td>
            <td align="left" colspan="2">
                <b>Cidade/UF</b>
                <br>
                <?php echo $cidade."/".$uf; ?>
            </td>
        </tr>
        <tr>
            <th align="left" colspan="4" onclick="abreFechaAnexos()">ANEXOS</th>
        </tr>
        <tr id="lnAnexos">
            <td width="100%" colspan="4">
                <table align="center" width="100%" cellpadding="0" cellspacing="1">
                    <?php
                            $rsAnexo = execQuery("select * from lda_anexo where idsolicitacao=$idsolicitacao order by idanexo");
                            $i=0;
                            while($row = mysqli_fetch_array($rsAnexo)){
                                $i++;
                                ?>
                        <tr>
                            <td align="left">
                                <a href="<?php echo $urlArquivo."/".$row['nome'];?>" target="_blank">
                                    <?php echo "Arquivo ".$i;?>
                                </a>
                            </td>
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
                            <td>
                                <?php echo bdToDate($row["datasolicitacao"]);?>
                            </td>
                            <td>
                                <?php echo $row["tiposolicitacao"];?>
                            </td>
                            <td>
                                <?php echo Solicitacao::getDescricaoSituacao($row["situacao"]);?>
                            </td>
                            <td>
                                <?php echo bdToDate($row["dataprevisaoresposta"]);?>
                            </td>
                            <td>
                                <?php echo bdToDate($row["dataresposta"]);?>
                            </td>
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
                <th align="left" colspan="4" onclick="abreFechaMovimentacoes()">MOVIMENTA&Ccedil;&Otilde;ES</th>
            </tr>
            <tr id="lnMovimentacoes">
                <td width="100%" colspan="4" style="padding:0;">
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
                                <td>
                                    <?php echo bdToDate($row["dataenvio"]);?>
                                </td>
                                <td>
                                    <?php echo $row["usuarioenvio"];?>
                                </td>
                                <td>
                                    <?php echo $row["destino"];?>
                                </td>
                                <td>
                                    <?php echo bdToDate($row["datarecebimento"]);?>
                                </td>
                                <td>
                                    <?php echo $row["usuariorecebimento"];?>
                                </td>
                                <td>
                                    <?php echo $row["despacho"];?>
                                </td>
                                <td>
                                    <?php if (!empty($row['arquivo'])){?>
                                    <a href="<?php echo $urlArquivo."/".$row['arquivo'];?>" target="_blank">
                                        <?php echo "Baixar";?>
                                    </a>
                                    <?php } else {?> -
                                    <?php }?>
                                </td>
                            </tr>
                            <?php 
                            }?>
                    </table>
                </td>
            </tr>
            <tr id="lnMovimentar" style="display: none">
                <td align="left" colspan="4">
                    <table>
                        <tr>
                            <td>Destino</td>
                            <td>
                                <select name="idsecretariadestino" id="idsecretariadestino">
                                    <option value="">-- selecione --</option>
									
                                    <?php 
										$idSecretariaUsuario = getSession('idsecretaria');
										$siccentral = getSession('sic')[$idSecretariaUsuario][2];
										
										if ($siccentral == 0)
											$qryStVinc = "and (idsetorvinculado = $idSecretariaUsuario or idsecretaria = 1)";
										else
											$qryStVinc = "";
										
										$rsCat = execQuery("select nome as sigla, idsecretaria from sis_secretaria where ativado = 1 and idsecretaria <> $idSecretariaUsuario $qryStVinc order by sigla"); 
									?>
                                    <?php while($row=mysqli_fetch_array($rsCat)){?>
                                    <option value="<?php echo $row['idsecretaria'];?>" <?php echo $row[ 'idsecretaria']==$idsecretariadestino? "selected": ""; ?>>
                                        <?php echo $row['sigla'];?>
                                    </option>
                                    <?php }?>
                                </select>
                                <img src="../img/loading.gif" border="0" id="imgCarregandoProblema" style="display:none" />
                            </td>
                        </tr>
                        <tr>
                            <td align="left">Arquivo:</td>
                            <td align="left">
                                <input name="anexomovimentacao" type="file" />
                                <br />
                            </td>
                        </tr>
                        <tr>
                            <td valign="top">Despacho: </td>
                            <td>
                                <textarea name="despacho" rows="10" cols="100" onkeyup="setMaxLength(4000,this);">
                                    <?php echo $despacho;?>
                                </textarea>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr id="lnFinalizar1" style="display: none">
                <td valign="top" align="left" colspan="4"><b>Responder Solicita&ccedil;&atilde;o</b></td>
            </tr>
            <tr id="lnFinalizar2" style="display: none">
                <td valign="top" align="left">Tipo de Resposta: </td>
                <td colspan="3" align="left">
                    <select name="tiporesposta" id="tiporesposta">
                        <option value="">-- selecione --</option>
                        <option value="R" <?php echo ($tiporesposta=="R" )? "selected": "";?>>Responder a informa&ccedil;&atilde;o solicitada</option>
                        <option value="N" <?php echo ($tiporesposta=="N" )? "selected": "";?>>Justificar a nega&ccedil;&atilde;o da informa&ccedil;&atilde;o solicitada</option>
                    </select>
                </td>
            </tr>
            <tr id="lnFinalizar3" style="display: none">
                <td valign="top" align="left">Resposta/Justificativa: </td>
                <td colspan="3" align="left">
                    <textarea name="txtresposta" rows="10" cols="100" onkeyup="setMaxLength(4000,this);">
                        <?php echo $txtresposta;?>
                    </textarea>
                    <?php if($formaretorno != "E"){?>
                    <font color="red">**ATEN&Ccedil;&Atilde;O: Solicitante pede que a resposta seja enviada por <b><?php echo Solicitacao::getDescricaoFormaRetorno($formaretorno);?></b></font>
                    <?php }?>
                </td>
            </tr>
            <tr id="lnFinalizar4" style="display: none">
                <td width="100%" colspan="4">
                    <table align="center" width="100%" cellpadding="0" cellspacing="1">
                        <tr>
                            <td align="left">Arquivo 1:</td>
                            <td align="left">
                                <input name="arquivos[]" type="file" />
                                <br />
                            </td>
                        </tr>
                        <tr>
                            <td align="left">Arquivo 2:</td>
                            <td align="left">
                                <input name="arquivos[]" type="file" />
                                <br />
                            </td>
                        </tr>
                        <tr>
                            <td align="left">Arquivo 3:</td>
                            <td align="left">
                                <input name="arquivos[]" type="file" />
                                <br />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr id="lnProrrogar1" style="display: none">
                <td valign="top" align="left" colspan="4"><b>Prorrogar Resposta a Solicita&ccedil;&atilde;o</b></td>
            </tr>
            <tr id="lnProrrogar2" style="display: none">
                <td valign="top" align="left">Motivo: </td>
                <td colspan="3" align="left">
                    <textarea name="txtmotivoprorrogacao" rows="4" cols="60" onkeyup="setMaxLength(2000,this);">
                        <?php echo $txtmotivoprorrogacao;?>
                    </textarea>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <br>
                    <?php 
                        //se tiver permissao de movimentar a demanda, e ela não tiver finalizada ([N]egado ou [R]espondido), exibe botão de envio
                        if(checkPerm("LDAMOVIMENTAR",false) and $situacao != "N" and $situacao != "R") 
                        { 
                            ?>
                    <button type="button" value="Movimentar" class="btn waves-effect btn-info" name="movimentar" id="btnMovimentar" onclick="preparaMovimentacao();" >Movimentar</button>
                    <button type="button" value="Enviar" class="btn waves-effect btn-success" name="enviar" id="btnEnviar" onclick="executaOperacao(this.value, this.id);" style="display: none" >Enviar</button>
                    <?php 
                        } 
                        //exibe botão de responder se:  
                        if(checkPerm("LDARESPONDER",false)  //tiver permissao de responder a demanda
                           and $situacao != "N" and $situacao != "R"//situação nao for finalizada ([N]egado ou [R]espondido)
                            ) 
                        { 
                            ?>
                    <button type="button" value="Responder" class="btn waves-effect btn-info" name="responder" id="btnResponder" onclick="preparaFinalizacao();" >Responder</button>
                    <button type="button" value="Finalizar" class="btn waves-effect btn-success" name="finalizar" id="btnFinalizar" onclick="executaOperacao(this.value, this.id);" style="display: none" >Finalizar</button>
                    <?php 
                        } 
                            
                        //exibe botão de reabrir se:  
                        if(checkPerm("LDAPRORROGAR",false)  //tiver permissao de prorrogar 
                            and $situacao != "N" and $situacao != "R"    //situação for "finalizado"
                            and empty($dataprorrogacao))
                        { 
                            ?>
                    <button type="button" value="Prorrogacao" class="btn waves-effect btn-info" name="prorrogacao" id="btnProrrogacao" onclick="preparaProrrogacao();" >Prorrogarção</button>
                    <button type="button" value="Prorrogar" class="btn waves-effect btn-info" name="prorrogar" id="btnProrrogar" onclick="executaOperacao(this.value, this.id);" style="display: none" >Prorrogar</button>
                    <?php 
                        } 
                        ?>
                    <button type="button" value="Cancelar" class="btn waves-effect btn-danger" name="btnCancelar" id="btnCancelar" onclick="cancelaAcao();" style="display: none" >Cancelar</button>
                    <button type="button" value="Voltar" class="btn waves-effect btn-danger" name="voltar" onclick="location.href='?lda_solicitacao&<?php echo $parametrosIndex;?>'" >Voltar</button>
                </td>
            </tr>
    </table>

</div>
</form>
<?php 
if($acao == "Enviar")
{
    echo "<script>preparaMovimentacao();</script>";
}
elseif($acao == "Finalizar")
{
    echo "<script>preparaFinalizacao();</script>";
}
elseif($acao == "Prorrogar")
{
    echo "<script>preparaProrrogacao();</script>";
}
getErro($erro);
?>
    <button class="btn waves-effect waves-circle btn-print"><i class="material-icons">print</i></button>