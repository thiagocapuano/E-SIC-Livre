<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

include("../inc/autenticar.php");
checkPerm("LSTSEC");

include "../inc/topo.php";
include("../inc/paginacaoPorPostIni.php");

$filtro = "";
if (($_REQUEST['acao'])) 
{
    $nome = $_REQUEST["nome"];
    $sigla = $_REQUEST["sigla"];
    $ativado = $_REQUEST["ativado"];
		
    if(!empty($nome)) $filtro.= " and s.nome like '%$nome%'";
    if(!empty($sigla)) $filtro.= " and s.sigla like '%$sigla%'";
    if(!empty($ativado)) $filtro.= " and s.ativado = $ativado";
}

$sql = "select * from sis_secretaria s
	where 1=1
	$filtro
	order by s.nome";
	
$resultado = execQueryPag($sql);
//$num = mysqli_num_rows($resultado);

?>

<script>
	function mudarStatus(id,status)
	{
		document.location = "?sis_secretaria&p=ativacao&idsecretaria="+id+"&ativado="+status;
	}
</script>

<div class="container-fluid">
    <header class="header-title">
        <h1>Cadastro de SIC</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo URL_BASE_SISTEMA; ?>index/">Início</a></li>
            <li><a href="<?php echo URL_BASE_SISTEMA; ?>index/?lda_secretaria">Cadastro de SIC</a></li>
            <li class="active">Cadastro de SIC</li>
        </ol>
    </header>
</div>

<form action="index.php?sis_secretaria" method="post" id="formulario" target="_self">
<section class="config">
	<div class="container-fluid">
		<div class="filter">			
			<div class="row">
				<div class="col-sm-1 col-xs-12">
					<h5 class="text-uppercase bold">Buscar:</h5>
				</div>
				<div class="col-md-2 col-xs-12">
					<div class="form-group">					
						<label for="nome" class="input-label"><i class="material-icons">account_circle</i></label>
						<input type="text" class="form-control icon" name="nome" value="<?php echo $nome?>" maxlength="50" placeholder="Nome" />
					</div>
				</div>
				<div class="col-md-2 col-xs-12">
					<div class="form-group">					
						<label for="nome" class="input-label"><i class="material-icons">account_circle</i></label>
						<input type="text" class="form-control icon" name="sigla" value="<?php echo $sigla?>" maxlength="30" placeholder="sigla" />
					</div>
				</div>
				<div class="col-md-2 col-xs-12">
					<div class="form-group">
						<label for="ativado" class="input-label"><i class="material-icons">account_circle</i></label>
						<select name="ativado" class="selectpicker icon" id="status">
							<option value="">Status</option>
							<option value="A" <?php echo ($ativado=="A")?"selected":""; ?>>Ativo</option>
							<option value="I" <?php echo ($ativado=="I")?"selected":""; ?>>Inativo</option>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<button class="btn btn-info waves-effect waves-button" name="acao" type="submit" value="Buscar">Buscar</button>
					<input type="button" class="btn btn-success waves-effect waves-button" onClick="document.location = '?sis_secretaria&p=cadastro';" value="Adicionar">
				</div>
			</div>
		</div>
	</div>

	<br>

	<div class="container-fluid">
		<div class="boll-table">
			<table class="table">
				<thead>
					<tr>
						<th></th>
						<th>Codigo</th>
						<th>Nome</th>
						<th>Sigla</th>
						<th>Centralizador</th>
						<th>Status</th>
					</tr>
				</thead>
				<?php
				$cor = false;
				while($registro = mysqli_fetch_array($resultado)){
					$click = "javascript:document.location='?sis_secretaria&p=cadastro&codigo=".$registro["idsecretaria"]."'";
					if($cor)
						$corLinha = "#dddddd";
					else
						$corLinha = "#ffffff";
					$cor = !$cor;
        
				?>
				<tr onMouseOver="this.style.backgroundColor = getCorSelecao(true);" onMouseOut="this.style.backgroundColor = '<?php echo $corLinha;?>';" style="background-color:<?php echo $corLinha;?>;cursor:pointer; cursor:hand; ">
					<!--td><button class="waves-circle waves-effect btn" onClick="apagar('<?php echo $registro["idsecretaria"]; ?>');"><i class="material-icons">close</i></button></td-->  
					<td><img src="../img/drop.png" title="Excluir Registro" onClick="apagar('<?php echo $registro["idsecretaria"]; ?>','sis_secretaria');"/></td>
					<td onClick="<?php echo $click;?>"><?php echo $registro["idsecretaria"]; ?></td>
					<td onClick="<?php echo $click;?>"><?php echo $registro["nome"]; ?></td>
					<td onClick="<?php echo $click;?>"><?php echo $registro["sigla"]; ?></td>
					<td onClick="<?php echo $click;?>"><?php echo ($registro["siccentral"])?"Sim":"Não"; ?></td>
					<td align="center"><button type="button" class="btn <?php echo ($registro["ativado"]=="1")?"btn-success":"btn-danger";?> waves-effect"  title="<?php echo ($registro["ativado"]=="1")?"Clique para desativar":"Clique para Ativar";?>" value="<?php echo ($registro["ativado"]=="1")?"Ativo":"Inativo";?>" onClick="javascript:mudarStatus('<?php echo $registro["idsecretaria"];?>','<?php echo ($registro["ativado"]=="1")?"0":"1";?>');"><?php echo ($registro["ativado"]=="1")?"Ativo":"Inativo";?></button></td>
				</tr>
				<?php 
				} 
				?>
				<tr class="noClick pagnation">
					<td align="right" class="text-center" colspan="8">
						<?php include("../inc/paginacaoPorPostFim.php");?>
					</td>
				</tr>
            </table>
		</div>
	</div>
</section>
</form>