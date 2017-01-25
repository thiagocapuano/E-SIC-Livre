<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/


	include("../inc/database.php");
    
	//recupera o quantitativo de solicitações em aberto e respondidas por ano
	$sql = "SELECT anoprotocolo as ano, 
				   count(*) as qtde
			FROM lda_solicitacao 
			GROUP BY anoprotocolo
			ORDER BY anoprotocolo";
			
	$rs = execQuery($sql);
	
	$numRegistros = mysqli_num_rows($rs);
	
	if ($numRegistros>0) 
	{
		$i=0;
		$anos="";
		$dados="";
		$maiornumero = 0;
        while ($row = mysqli_fetch_assoc($rs)) {
			$i++;	

			//recupera o quantitativo de solicitações no ano da iteração que foram respondidas
			$sql="select count(*) as tot from lda_solicitacao where anoprotocolo = ".$row['ano']." and situacao in('R')";
			$rsResp = execQuery($sql);
			$rowResp = mysqli_fetch_array($rsResp);
			$sql="select count(*) as tot from lda_solicitacao where anoprotocolo = ".$row['ano']." and situacao in('N')";
			$rsResp2 = execQuery($sql);
			$rowResp2 = mysqli_fetch_array($rsResp2);
			
			//se for o ultimo registro nao imprime a virgula no final
			if ($i==$numRegistros)
			{
				$anos .= "'Em ".$row["ano"]."'";
				$dados .= "[".$row['qtde'].",".$rowResp["tot"].",".$rowResp2["tot"]."]";			
			}
		    else
			{
				$anos .= "'".$row["ano"]."', ";
				$dados .= "[".$row['qtde'].",".$rowResp["tot"].",".$rowResp2["tot"]."], ";			
			}
			
			//atribui maior numero
			if($maiornumero < $row["qtde"])
				$maiornumero = $row["qtde"];
			
        }
		
    } 

include("../inc/topo.php"); 	
?>
	<center><strong><h1>Estat&iacute;stica</h1></strong></center>
	<br><b>Confira a quantidade de pedidos de informa&ccedil;&atilde;o e respostas registrados no e-SIC Livre.</b><br><br>
	
    <!-- Don't forget to update these paths -->
    <script src="../js/RGraph/libraries/RGraph.common.core.js" ></script>
    <script src="../js/RGraph/libraries/RGraph.bar.js" ></script>
	
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

    <canvas id="cvs" width="700" height="500">[No canvas support]</canvas>
	
	<script>
		$(document).ready(function ()
		{
			var bar = new RGraph.Bar({
				id: 'cvs',
				data: [<?php echo $dados; ?>],
				options: {
					colors: ['Gradient(white:#006699:#006699)', 'Gradient(white:#FF9900:#FF9900)','Gradient(white:#FF0000:#FF0000)'],
					gutter: {
						top: 15,
						left: 50,
						right: 115
					},
					background: {
						grid: {
							vlines: false,
							border: false
						}
					},
					ymax:  <?php echo $maiornumero+10;?>,
					noyaxis: false,
					ylabels: true,
					labels: {
						self: [<?php echo $anos; ?>],
						above: true
					},
					linewidth: 2,
					hmargin: 15
				}
			}).draw()

			!RGraph.ISOLD ? $('#cvs').addClass('animated expand') : null;;
		})
	</script>
	<br><br>
	<img width="20" height="20" style="background-color:#006699"><font color="#000099"> Pedidos Registrados</font>
	<img width="20" height="20" style="background-color:#FF9900"><font color="#FF9900"> Pedidos Atendidos  </font>
	<img width="20" height="20" style="background-color:#FF0000"><font color="#FF0000"> Pedidos Negados    </font>
	
<?php include("../inc/rodape.php"); ?>