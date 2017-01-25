<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

include("../inc/autenticar.php");
checkPerm("LSTLDASOLICITACAO");

$varAreaRestrita = "leideacesso"; //indica se deve ser incluido o arquivo dentro da classe

include("../inc/paginacaoPorPostIni.php");

$filtro = "";

$numprotocolo   = $_REQUEST["fltnumprotocolo"];
$solicitante    = $_REQUEST["fltsolicitante"];
$situacao       = $_REQUEST["fltsituacao"];
$idSicUsuario	= getSession('idsecretaria');

$parametrosIndex = "fltnumprotocolo=$numprotocolo&fltsolicitante=$solicitante&fltsituacao=$situacao"; //parametros a ser passado para a pagina de detalhamento, fazendo com que ao voltar para o index traga as informações passadas anteriormente

if (!empty($numprotocolo)) $filtro.= " and concat(sol.numprotocolo,'/',sol.anoprotocolo) = '$numprotocolo'";
if (!empty($solicitante)) $filtro.= " and pes.nome like '%$solicitante%'";

//verifica se a secretaria do usuario é um SIC central
$sql="select sigla from sis_secretaria where siccentral = 1 and idsecretaria = '$idSicUsuario'";
$rs=  execQuery($sql);
$visibilidadeSICcentral = mysqli_num_rows($rs)>0;

//se usuario pertencer a um SIC central
if($visibilidadeSICcentral)
    $filtro.= " and ifnull(secDestino.idsecretaria,'$idSicUsuario') = '$idSicUsuario' ";
else
{
    //caso exista SIC centralizador, só mostra as solicitações do SIC do usuario
    if(Solicitacao::existeSicCentralizador())
        $filtro.= " and secDestino.idsecretaria = '$idSicUsuario'"; //filtra so as que a ultima movimentação tem como destino a secretaria do usuario
    else
        $filtro.= " and (secDestino.idsecretaria = '$idSicUsuario' or (sol.idsecretariaselecionada = '$idSicUsuario' and sol.situacao = 'A'))"; //filtra so as que a ultima movimentação tem como destino a secretaria do usuario ou que a secretaria selecionada tenha sido a do usuario e o status esteja em aberto
}



//seleciona as solicitações não respondidas e sua ultima movimentação (recupera variaveis de configuracao de prazos)
/*
 * Quando a situação for A ou T, trata da primeira tramitação do processo. 
 */
$sql = "select sol.*, 
               pes.nome as solicitante,
               ifnull(secOrigem.sigla,'Solicitante') as secretariaorigem, 
               case when secDestino.sigla is null then
                        ifnull(secSelecionada.sigla,'SIC Central')
               else 'SIC Central'
               end as secretariadestino, 
               mov.idsecretariadestino,
               mov.datarecebimento,
               mov.idmovimentacao,
               c.*,
               DATEDIFF(sol.dataprevisaoresposta, NOW()) as prazorestante,
               tip.nome as instancia

        from lda_solicitacao sol
        join lda_tiposolicitacao tip on tip.idtiposolicitacao = sol.idtiposolicitacao
        join lda_solicitante pes on pes.idsolicitante = sol.idsolicitante
        left join lda_movimentacao mov on mov.idmovimentacao = (select max(m.idmovimentacao) from lda_movimentacao m where m.idsolicitacao = sol.idsolicitacao)
        left join sis_secretaria secOrigem on secOrigem.idsecretaria = mov.idsecretariaorigem
        left join sis_secretaria secDestino on secDestino.idsecretaria = mov.idsecretariadestino
        left join sis_secretaria secSelecionada on secSelecionada.idsecretaria = sol.idsecretariaselecionada
        join lda_configuracao c
        where  
            sol.situacao not in('R','N')
            $filtro ";


$rs		= execQueryPag($sql);
$rs2 	= execQueryPag($sql);
$rs3 	= execQueryPag($sql);

?>
<div class="container-fluid">
    <header class="header-title">
        <h1>Solicitações Pendentes da Lei de Acesso</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo URL_BASE_SISTEMA; ?>/index/">Início</a></li>
            <li class="active">Solicitação</li>
        </ol>
    </header>
</div>
<section>
    <div class="filter">
        <div class="container-fluid">
            <form action="?lda_solicitacao" method="post" id="formulario">
                <div class="row">
                     <div class="col-sm-1 col-xs-12">
                       <h5 class="text-uppercase bold">Buscar:</h5>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <label for="protocolo" class="input-label"><i class="material-icons">insert_drive_file</i></label>
                            <input type="text" class="form-control icon awesomplete" name="fltnumprotocolo" value="<?php echo $numprotocolo; ?>" maxlength="50" size="30" placeholder="N° do protocolo"  data-list="<?php while ($registro = mysqli_fetch_array($rs2)) { ?><?=$registro["numprotocolo"] . '/' . $registro["anoprotocolo"] . ', ';?><?php } ?>" />
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <label for="solicitante" class="input-label"><i class="material-icons">account_circle</i></label>
                            <input type="text" class="form-control icon awesomplete" name="fltsolicitante" value="<?php echo $solicitante; ?>" maxlength="50" size="30" placeholder="Solicitante" data-list="<?php while ($registro = mysqli_fetch_array($rs3)) { ?><?=$registro["solicitante"] . ', ';?><?php } ?>" />
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <button class="btn btn-info waves-effect waves-button" name="acao" type="submit">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="container-fluid">
         <div class="map-color">
            <ul>
                <li><span style="background-color: #fff;"></span> Ainda está no prazo</li>
                <li><span style="background-color: #ef4e3a;"></span> Prazo de resposta expirado</li>
                <li><span style="background-color: #f0b840;"></span> Prazo de resposta perto de expirar</li>
            </ul>
        </div>
        <div class="boll-table">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Protocolo</th>
                        <th>Tipo de Solicita&ccedil;&atilde;o</th>
                        <th>Data Solicita&ccedil;&atilde;o</th> 
                        <th>Solicitante</th>
                        <th>Data Envio</th>
                        <th>Origem</th>
                        <th>Destino</th>
                        <th>Prazo Restante</th>
                         <th>Previs&atilde;o Resposta</th> 
                        <th>Prorrogado?</th>
                         <th>Situa&ccedil;&atilde;o</th> 
                    </tr>
                </thead>
                <?php
    $cor = false;
    while ($registro = mysqli_fetch_array($rs)) {

            if($cor)
                $corLinha = "#dddddd";
            else
                $corLinha = "#ffffff";
            $cor = !$cor;
        
            //se tiver passado do prazo de resposta
            if ($registro['prazorestante'] < 0)
            {
                $corLinha = "#FFB2B2"; //vermelho - Urgente! Passou do prazo de resolução
            }
            //se faltar entre 1 e 5 dias para expirar o prazo de resposta
            elseif($registro['prazorestante'] >= 0 and $registro['prazorestante'] <= 5)
            {
                $corLinha = "#FFFACD"; //amarelo - Alerta! Está perto de expirar
            }

            $confirmacao="";
            //se existir movimentação que não tenha sido recebida e o usuario for da secretaria de recebimento, ou a solicititação não tenha sido recebida nenhuma vez e o usuário tiver visibilidade de SIC central
            //solicita confirmação de recebimento
            if((!empty($registro['idmovimentacao']) 
                and empty($registro['datarecebimento']) 
                and $registro['idsecretariadestino'] == $idSicUsuario)
               or (empty($registro['datarecebimentosolicitacao']) 
                   and $visibilidadeSICcentral))
                $confirmacao = "if(!confirm('Confirma recebimento da solicitação?'))return false; ";
                          
				$clickMovimento = $confirmacao."javascript:document.location='?lda_solicitacao&p=movimentacao&codigo=".$registro['idsolicitacao']."&receber=sim&tk=".md5($registro['idsolicitacao'].SIS_TOKEN)."';";
            ?>
            <tr onMouseOver="this.style.backgroundColor = getCorSelecao(true);" onMouseOut="this.style.backgroundColor = '<?php echo $corLinha;?>';" style="background-color:<?php echo $corLinha;?>;cursor:pointer; cursor:hand; ">
                <td onClick="<?php echo $clickMovimento; ?>">
                    <?php
                        //se tiver movimentação
                        if (!empty($registro["idmovimentacao"]))
                            //seta que foi recebido se a data de recebimento tiver preenchida
                            $recebido = !empty($registro["datarecebimento"]);
                        else
                            //seta que foi recebido se a data de recebimento da solicitação (primeiro recebimento) tiver preenchida
                            $recebido = !empty($registro["datarecebimentosolicitacao"]);
                    
                        if($recebido)
                        {
                            $imgTitulo = "Recebido";
                            $imagem = "mail_opened.png";
                        }
                        else
                        {
                            $imgTitulo = "Não Recebido";
                            $imagem = "mail_closed.png";
                        }
                    ?>
                    <img width="24" align="middle" title="<?php echo $imgTitulo; ?>" height="24" src="../img/<?php echo $imagem; ?>">
                </td>
                <td onClick="<?php echo $clickMovimento; ?>"><?php echo $registro["numprotocolo"]."/".$registro["anoprotocolo"]; ?></td>
                <td onClick="<?php echo $clickMovimento; ?>"><?php echo $registro["instancia"]; ?></td>
                <td onClick="<?php echo $clickMovimento; ?>"><?php echo bdToDate($registro["datasolicitacao"]); ?></td>
                <td onClick="<?php echo $clickMovimento; ?>"><?php echo $registro["solicitante"]; ?></td>
                <td onClick="<?php echo $clickMovimento; ?>"><?php echo bdToDate(!empty($registro["dataenvio"])?$registro["dataenvio"]:$registro["datasolicitacao"]); ?></td>                
                <td onClick="<?php echo $clickMovimento; ?>"><?php echo strtoupper($registro["secretariaorigem"]); ?></td>
                <td onClick="<?php echo $clickMovimento; ?>"><?php echo strtoupper($registro["secretariadestino"]); ?></td>
                <td onClick="<?php echo $clickMovimento; ?>"><?php echo $registro["prazorestante"]; ?></td>
                <td onClick="<?php echo $clickMovimento; ?>"><?php echo bdToDate($registro["dataprevisaoresposta"]); ?></td>
                <td onClick="<?php echo $clickMovimento; ?>"><?php echo (!empty($registro["dataprorrogacao"]))?"Sim":"Não"; ?></td>
                <td onClick="<?php echo $clickMovimento; ?>"><?php echo Solicitacao::getDescricaoSituacao($registro["situacao"]); ?></td>
            </tr>
            <?php } ?>
            </table>
        </div>
    </div>
</section>