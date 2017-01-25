<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

include("../inc/autenticar.php");  
checkPerm("LSTUSR");

include("../inc/paginacaoPorPostIni.php");

$filtro = "";
if (($_REQUEST['acao']))
{
	$nome 			= $_REQUEST["nome"];
	$login			= $_REQUEST["login"];
	$matricula		= $_REQUEST["matricula"];
	$cpfusuario		= $_REQUEST["cpfusuario"];
	$idsecretaria   = $_REQUEST["idsecretaria"];
	$status 		= $_REQUEST["status"];

	if(!empty($nome)) $filtro.= " and usuario.nome like '%$nome%'";
	if(!empty($login)) $filtro.= " and usuario.login like '%$login%'";
	if(!empty($matricula)) $filtro.= " and usuario.matricula = '$matricula'";
	if(!empty($cpfusuario)) $filtro.= " and usuario.cpfusuario = '$cpfusuario'";
	if(!empty($status)) $filtro.= " and usuario.status = '$status'";
	if(!empty($idsecretaria)) $filtro.= " and usuario.idsecretaria = '$idsecretaria'";		
}			

$sql = "select usuario.*, sigla		  
	  from sis_usuario usuario
	  left outer join sis_secretaria secretaria on usuario.idsecretaria = secretaria.idsecretaria
	  where 1=1 $filtro ";


$rs = execQueryPag($sql);
?>

<script>
	function mudarStatus(id,status)
	{
		document.location = "?sis_usuario&p=ativacao&idusuario="+id+"&status="+status;
	}
	
</script>

<div class="container-fluid">
    <header class="header-title">
        <h1>Cadastro de Usuários</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo URL_BASE_SISTEMA; ?>index/">Início</a></li>
            <li><a href="<?php echo URL_BASE_SISTEMA; ?>index/?lda_configuracao">Administração</a></li>
            <li class="active">Cadastro de Usuários</li>
        </ol>
    </header>
</div>

<form action="index.php?sis_usuario" method="post" id="formulario">
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
						<label for="login" class="input-label"><i class="material-icons">account_circle</i></label>
						<input type="text" id="login" name="login" value="<?php echo $login?>" placeholder="Login" maxlength="50" class="form-control icon" />
					</div>
				</div>
				<div class="col-md-2 col-xs-12">
					<div class="form-group">
						<label for="cpf" class="input-label"><i class="material-icons">account_circle</i></label>
						<input type="text" name="cpfusuario" id="cpf" value="<?php echo $cpfusuario?>" class="form-control icon" placeholder="CPF" maxlength="11" />
					</div>
				</div>
				<div class="col-md-2 col-xs-12">
					<div class="form-group">
						<label for="matricula" class="input-label"><i class="material-icons">account_circle</i></label>
						<input type="text" placeholder="Matrícula" name="matricula" id="matricula" class="form-control icon" value="<?php echo $matricula?>"  maxlength="6" />
					</div>
				</div>
				<div class="col-md-2 col-xs-12">
					<div class="form-group">
						<label for="status" class="input-label"><i class="material-icons">account_circle</i></label>
						<select name="status" class="selectpicker icon" id="status">
							<option value="">Status</option>
							<option value="A" <?php echo ($status=="A")?"selected":""; ?>>Ativo</option>
							<option value="I" <?php echo ($status=="I")?"selected":""; ?>>Inativo</option>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<button class="btn btn-info waves-effect waves-button" name="acao" type="submit" value="Buscar">Buscar</button>
					<input type="button" class="btn btn-success waves-effect waves-button" onClick="document.location = '?sis_usuario&p=cadastro';" value="Adicionar">
				</div>
				
			</div>		
		</div>
	</div>

	<div class="container-fluid">
		<div class="boll-table">
			<table class="table">
				<thead>
					<tr>
						<th></th>
						<th>Codigo</th>
						<th>Usuário</th>
						<th>CPF</th>
						<th>Matricula</th>
						<th>Login</th>
						<th>SIC</th>
						<th>Status</th>
					</tr>
				</thead>
			
				<?php
                $cor = false;
                while($registro = mysqli_fetch_array($rs)){
	               $click = "javascript:document.location='?sis_usuario&p=cadastro&codigo=".$registro["idusuario"]."'";
                if($cor)
                  $corLinha = "#dddddd";
                else
                  $corLinha = "#ffffff";

                $cor = !$cor;
				?>
				<tr onMouseOver="this.style.backgroundColor = getCorSelecao(true);" onMouseOut="this.style.backgroundColor = '<?php echo $corLinha;?>';" style="background-color:<?php echo $corLinha;?>;cursor:pointer; cursor:hand; ">
					<!--td><button class="waves-circle waves-effect btn" title="Excluir Registro" onClick="apagar('<?php echo $registro["idusuario"]; ?>');" ><i class="material-icons" >close</i></button></td--> 
					<td><img src="../img/drop.png" title="Excluir Registro" onClick="apagar('<?php echo $registro["idusuario"]; ?>','sis_usuario');"/></td>
					<td onClick="<?php echo $click;?>"><?php echo $registro["idusuario"];?></td>
					<td onClick="<?php echo $click;?>"><?php echo destacaBusca($registro["nome"],$nome); ?></td>
					<td onClick="<?php echo $click;?>"><?php echo destacaBusca($registro["cpfusuario"],$cpfusuario); ?></td>
					<td onClick="<?php echo $click;?>"><?php echo destacaBusca($registro["matricula"],$matricula); ?></td>
					<td onClick="<?php echo $click;?>"><?php echo $registro["login"]; ?></td>
					<td onClick="<?php echo $click;?>"><?php echo $registro["sigla"]; ?></td>
					<td align="center"><button type="button" class="btn <?php echo ($registro["status"]=="A")?"btn-success":"btn-danger";?> waves-effect"  title="<?php echo ($registro["status"]=="A")?"Clique para desativar":"Clique para Ativar";?>" value="<?php echo ($registro["status"]=="A")?"Ativo":"Inativo";?>" onClick="javascript:mudarStatus('<?php echo $registro["idusuario"];?>','<?php echo ($registro["status"]=="A")?"I":"A";?>');"><?php echo ($registro["status"]=="A")?"Ativo":"Inativo";?></button></td>
				</tr>
				<?php 
				}
				?>
				<tr class="noClick pagnation">
					
						<?php include("../inc/paginacaoPorPostFim.php");?>
					
				</tr>
            </table>
		</div>
	</div>
</section>
</form>