<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

 include("manutencao.php");
 $urlArquivo = getURL("lda");
?>

<script language="JavaScript" src="../js/XmlHttpLookup.js"></script>
<script src="inc/js/functions.js"></script>
<div class="container-fluid">
    <header class="header-title">
        <h1>Informações de Solicitação</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo URL_BASE_SISTEMA; ?>index/">Início</a></li>
            <li><a href="index.php?lda_consulta">Consulta</a></li>
            <li class="active">Solicitação</li>
        </ol>
    </header>
</div>
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
<div class="container-fluid">
    <table align="center" cellpadding="0" width="100%" cellspacing="1" class="tabDetalhe table">
        <tr>
            <th align="left" width="100%" colspan="4" style="background-color: #27665A; color:#fff; padding:20px 10px;" onclick="abreFechaDemanda()">DADOS DA SOLICITA&Ccedil;&Atilde;O </th>
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
                <b>Forma Retorno</b>
                <br>
                <?php echo Solicitacao::getDescricaoFormaRetorno($formaretorno);?>
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
                <?php echo !empty($dataprorrogacao)?"Prorrogado em: ".$dataprorrogacao." por ".$usuarioprorrogacao. "<brMotivo: ".$motivoprorrogacao:"Não Prorrogado";?>
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
            <th align="left" colspan="4" style="background-color: #27665A; color:#fff; padding:20px 10px;" onclick="abreFechaSolicitante()">DADOS DO SOLICITANTE</th>
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
            <th align="left" colspan="6" style="background-color: #27665A; color:#fff; padding:20px 10px;" onclick="abreFechaAnexos()">ANEXOS</th>
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
                <th align="left" colspan="4" style="background-color: #27665A; color:#fff; padding:20px 10px;" onclick="abreFechaMovimentacoes()">MOVIMENTA&Ccedil;&Otilde;ES</th>
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
            <tr>
                <td colspan="4">
                    <br>
                    <button type="button" value="Voltar" class="btn btn-info waves-effect" name="voltar" onclick="history.back()">Voltar</button>
                </td>
            </tr>
    </table>

    <button class="btn waves-effect waves-circle btn-print"><i class="material-icons">print</i></button>
</div>