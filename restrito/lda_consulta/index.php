<?php
/* * ********************************************************************************
  Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.

  Copyright (C) 2014 Prefeitura Municipal do Natal

  Este programa é software livre; você pode redistribuí-lo e/ou
  modificá-lo sob os termos da Licença GPL2.
 * ********************************************************************************* */

include("../inc/autenticar.php");
include("../index/dashboard/funcoes.php");
checkPerm("LDACONSULTAR");

$varAreaRestrita = "inclui"; //indica se deve ser incluido o arquivo dentro da classe

include("../inc/paginacaoPorPostIni.php");

$filtro = "";

$numprotocolo 	= $_REQUEST["fltnumprotocolo"];
$solicitante 	= $_REQUEST["fltsolicitante"];
$situacao 		= $_REQUEST["fltsituacao"];
$siglaSicUsuario = $_SESSION["sgsecretaria"];
$origem 		= $_REQUEST["fltorigem"];
$sicDestino 	= $_REQUEST["fltsecdestino"];
$month			= $_REQUEST["fltmonth"];
$abeRes			= $_REQUEST["fltAbeRes"];

$parametrosIndex = "fltnumprotocolo=$numprotocolo&fltsolicitante=$solicitante&fltsituacao=$situacao&fltorigem=$origem"; //parametros a ser passado para a pagina de detalhamento, fazendo com que ao voltar para o index traga as informações passadas anteriormente

if (!empty($numprotocolo))
    $filtro.= " and concat(sol.numprotocolo,'/',sol.anoprotocolo) = '$numprotocolo'";
if (!empty($solicitante))
    $filtro.= " and pes.nome like '%$solicitante%'";
if (!empty($situacao))
    $filtro.= " and sol.situacao IN ($situacao)";
if (!empty($origem))
    $filtro.= " and sol.origem = '$origem'";
if (!empty($sicDestino))
    $filtro.= " and mov.idsecretariadestino = '$sicDestino'";
if (!empty($month) && !empty($abeRes))
	if ($abeRes == 'A')
		$filtro.= " and month(sol.datasolicitacao) = $month";
	else if ($abeRes == 'R')
		$filtro.= " and month(sol.dataresposta) = $month";

//seleciona as solicitações
/*
 * Quando a situação for A ou T, trata da primeira tramitação do processo. 
 */
$rs		= getDemandas($filtro);

?>
<div class="container-fluid">
    <header class="header-title">
        <h1>Pesquisa de Solicitações do Lei de Acesso</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo URL_BASE_SISTEMA; ?>index/">Início</a></li>
            <li class="active">Consulta</li>
        </ol>
    </header>
</div>
<form action="index.php?lda_consulta" method="post" id="formulario">
<section>
    <div class="filter">
        <div class="container-fluid">            
                <div class="row">
                     <div class="col-sm-1 col-xs-12">
                       <h5 class="text-uppercase bold">Buscar:</h5>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <label for="protocolo" class="input-label"><i class="material-icons">insert_drive_file</i></label>
                            <input placeholder="Nº do protocolo" class="form-control icon awesomplete" type="text" name="fltnumprotocolo" id="protocolo" value="<?php echo $numprotocolo; ?>" maxlength="50" data-list="<?php while ($registro = mysqli_fetch_array($rs)) { ?><?=$registro["numprotocolo"] . '/' . $registro["anoprotocolo"] . ', ';?><?php }; mysqli_data_seek ($rs,0); ?>">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <label for="solicitante" class="input-label"><i class="material-icons">account_circle</i></label>
                            <input placeholder="Solicitante" class="form-control icon awesomplete" type="text" name="fltsolicitante" id="solicitante" value="<?php echo $solicitante; ?>" maxlength="50" data-list="<?php while ($registro = mysqli_fetch_array($rs)) { ?><?=$registro["solicitante"] . ', ';?><?php }; mysqli_data_seek ($rs,0); ?>">
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <label for="fltsituacao" class="input-label"><i class="material-icons">info</i></label>
                            <select name="fltsituacao" id="fltsituacao" class="selectpicker icon">
                                <option value="" <?php echo empty($situacao) ? "selected" : ""; ?>>Todos</option>
                                <option value="'A'" <?php echo $situacao == "A" ? "selected" : ""; ?>>Aberto</option>
                                <option value="'T'" <?php echo $situacao == "T" ? "selected" : ""; ?>>Em tramitação</option>
                                <option value="'N'" <?php echo $situacao == "N" ? "selected" : ""; ?>>Negado</option>
                                <option value="'R'" <?php echo $situacao == "R" ? "selected" : ""; ?>>Respondido</option>
                            </select>
                        </div>
                    </div>
                    <!--div class="col-md-2 col-xs-12">
                        <div class="form-group">
                            <label for="fltorigem" class="input-label"><i class="material-icons">info</i></label>
                            <select name="fltorigem" id="fltsituacao" class="selectpicker icon">
                                <option value="">Origem</option>
                                <option value="1">E-sic</option>
                                <option value="2">Eu Inspetor</option>
                            </select>
                        </div>
                    </div-->
                    <div class="col-md-2 col-xs-12">
                        <button class="btn btn-info waves-effect waves-button" name="acao" type="submit">Buscar</button>
                    </div>
                </div>            
        </div>
    </div>
    <div class="container-fluid">
         <div class="map-color">
            <ul>
				<li><span style="background-color: #00ff00;"></span> Solicitação Respondida</li>
                <li><span style="background-color: #fff;"></span> Ainda está no prazo</li>
                <li><span style="background-color: #ef4e3a;"></span> Prazo de resposta expirado</li>
                <li><span style="background-color: #f0b840;"></span> Prazo de resposta perto de expirar</li>
            </ul>
        </div>
        <div class="boll-table">
            <table class="table" id="areaToPrint">
                <thead>
                    <tr>
                        <th class="none-print"></th>
                        <th>Protocolo</th>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th width="150">Solicitante</th>
                        <th>Data Envio</th>
                        <th class="text-center">Origem</th>
                        <th class="text-center">Destino</th>
                        <th class="text-center">Prazo Restante</th>
                        <th>Previsão Resposta</th>
                        <th width="100">Prorrogado</th>
                        <th>Situação</th>
                        <!--th>Sistema</th-->
                        <th class="none-print"></th>
                    </tr>
                </thead>
                <?php  $cor = false;
                while ($registro = mysqli_fetch_array($rs)) {
					$corLinha = "#fff";	
					
					if($cor)
					$corLinha2 = "#dddddd";
					else
					$corLinha2 = "#ffffff";
					$cor = !$cor;
					                    
						//se foi respondida marca verde
						if( (!empty($registro['dataresposta'])) ){
						$corLinha = "#00FF00";	
						$registro['prazorestante'] = 0;
						}
                        //se tiver passado do prazo de resposta	sem ter sido respondida				
                        elseif ($registro['prazorestante'] < 0 and (empty($registro['dataresposta']))) {
							$corLinha = "#ef4e3a"; //vermelho - Urgente! Passou do prazo de resolução
						}
                        //se faltar entre 1 e 5 dias para expirar o prazo de resposta
                        elseif ($registro['prazorestante'] >= 0 and $registro['prazorestante'] <= 5) {
                            $corLinha = "#f0b840"; //amarelo - Alerta! Está perto de expirar
                        }
                    
                    $clickMovimento = $confirmacao . "editar('" . $registro["idsolicitacao"] . "&$parametrosIndex','../lda_solicitacao/visualizar');";
					$clickMovimento = "javascript:document.location='?lda_solicitacao&p=visualizar&codigo=".$registro['idsolicitacao']."';";
                    ?>
                    
					<tr onMouseOver="this.style.backgroundColor = getCorSelecao(true);" onMouseOut="this.style.backgroundColor = '<?php echo $corLinha2;?>';" style="background-color:<?php echo $corLinha2;?>;cursor:pointer; cursor:hand;">
             
					   <td class="prazo"><span style="background-color:<?=$corLinha?>;"></span></td>
                        <td onClick="<?php echo $clickMovimento; ?>"><?php echo $registro["numprotocolo"] . "/" . $registro["anoprotocolo"]; ?></td>
                        <td onClick="<?php echo $clickMovimento; ?>"><?php echo $registro["tiposolicitacao"]; ?></td>
                        <td onClick="<?php echo $clickMovimento; ?>"><?php echo bdToDate($registro["datasolicitacao"]); ?></td>
                        <td onClick="<?php echo $clickMovimento; ?>"><?php echo $registro["solicitante"]; ?></td>
                        <td onClick="<?php echo $clickMovimento; ?>"><?php echo bdToDate(!empty($registro["dataenvio"]) ? $registro["dataenvio"] : $registro["datasolicitacao"]); ?></td>                
                        <td class="text-center" onClick="<?php echo $clickMovimento; ?>"><?php echo strtoupper($registro["secretariaorigem"]); ?></td>
                        <td class="text-center" onClick="<?php echo $clickMovimento; ?>"><?php echo strtoupper($registro["secretariadestino"]); ?></td>
                        <td class="text-center" onClick="<?php echo $clickMovimento; ?>"><?php echo $registro["prazorestante"]; ?></td>
                        <td onClick="<?php echo $clickMovimento; ?>"><?php echo bdToDate($registro["dataprevisaoresposta"]); ?></td>
                        <td onClick="<?php echo $clickMovimento; ?>"><?php echo (!empty($registro["dataprorrogacao"])) ? "Sim" : "Não"; ?></td>
                        <td onClick="<?php echo $clickMovimento; ?>"><?php echo Solicitacao::getDescricaoSituacao($registro["situacao"]); ?></td>
                        <!--td><?php echo Solicitacao::getOrigem($registro["origem"]); ?></td-->
                        <td class="none-print"></td>
                    </tr>
                <?php }
                ?>
                <tr >
                    <td align="right" class="text-center" colspan="12">
                        <?php include("../inc/paginacaoPorPostFim.php");?>
                    </td>
                </tr>							
			</tr>
            </table>
        </div>
    </div>
</form>
    <button class="btn waves-effect waves-circle btn-print"><i class="material-icons">print</i></button>
</section>