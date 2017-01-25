<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

include "manutencao.php";
include "../inc/topo.php";
include "../inc/paginacaoIni.php";	

$filtro = "";


if(!empty($nome)) $filtro .= " and sis_grupo.nome like '%$nome%' ";
if(!empty($descricao)) $filtro .= " and sis_grupo.descricao like '%$descricao%' ";
if(!empty($ativo)) $filtro .= " and sis_grupo.ativo = ".(($ativo=="2")?"0":"1")." ";


$sql = "select *
        from sis_grupo
	where 1=1 $filtro order by nome";

$rs = execQueryPag($sql);

?>
<div class="container-fluid">
    <header class="header-title">
<h1>Perfis</h1>
<ol class="breadcrumb">
            <li><a href="<?php echo URL_BASE_SISTEMA; ?>index/">Dashboard</a></li>
            <li><a href="<?php echo URL_BASE_SISTEMA; ?>index/?lda_configuracao">Administração</a></li>
            <li class="active">Perfis</li>
        </ol>
    </header>
</div>
<br><br>

<section class="config">
	<div class="filter">
	<!-- FORMULARIO -->
	<?php include "formulario.php";?>
	</div>
<br>

<!-- LISTAGEM -->
<div class="container-fluid" class="config">
    <div class="boll-table">
      <table class="table">
        <thead>
			  <tr>
				<th></th>
					<th>Codigo</th>
					<th>Nome</th>
					<th>Descri&ccedil;&atilde;o</th>
					<th>Status</th>
					<th>Acessos</th>
			  </tr>
		</thead> 
			  
  <?php
  $cor = false;
  while($registro = mysqli_fetch_array($rs)){
	$click = "edita('".$registro["idgrupo"]."','".$registro["nome"]."','".$registro["descricao"]."','".$registro["idsecretaria"]."','".$registro["ativo"]."')";
        
        if($cor)
            $corLinha = "#dddddd";
        else
            $corLinha = "#ffffff";
        $cor = !$cor;

	?>
	
	<tr onMouseOver="this.style.backgroundColor = getCorSelecao(true);" onMouseOut="this.style.backgroundColor = '<?php echo $corLinha;?>';" style="background-color:<?php echo $corLinha;?>;cursor:pointer; cursor:hand; ">
		<td><img  src="../img/drop.png" title="Excluir Registro" onClick="apagar('<?php echo $registro["idgrupo"]; ?>','sis_grupo');"/></td>
		<td align="left" onClick="<?php echo $click;?>"><?php echo $registro["idgrupo"]; ?></td>
		<td align="left" onClick="<?php echo $click;?>"><?php echo $registro["nome"]; ?></td>
		<td align="left" onClick="<?php echo $click;?>"><?php echo $registro["descricao"]; ?></td>
		<td onClick="<?php echo $click;?>"><?php echo $registro["ativo"]? "Ativo": "Inativo" ; ?></td>
		<td align="center">
			<input type="button" class="btn btn-info waves-effect"  value="Permissoes" onClick="javascript:document.location='?sis_grupo&p=grupoperm&idgrupo=<?php echo $registro["idgrupo"];?>&grupo=<?php echo $registro["nome"]; ?>';"/>
			<input type="button" class="btn btn-info waves-effect"  value="Usuarios" onClick="javascript:document.location='?sis_grupo&p=usuarios&idgrupo=<?php echo $registro["idgrupo"];?>';"/>
		</td>			
	</tr>
	<?php } ?>
	</table>
  </div>
</div>

  <tr>
	<td align="right" colspan="7">
		<?php 
			$param="";
			include("../inc/paginacaoFim.php");
		?>
	</td>
  </tr>    
</table>
</section>
