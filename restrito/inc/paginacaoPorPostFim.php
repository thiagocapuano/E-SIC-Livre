<?php 
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

//PAGINACAO - PARTE FINAL (botoes)
/*
	$param -> variavel q contem os parametros de GET ou qualquer outro necessario para a consulta 
			  * incluir antes do comando de inclusao desse arquivo
			  * sempre terminar a lista de paramentros com &
			  ex.: $param = "id=$id&nome=$nome&";
*/


// Calculando pagina anterior  
$menos = $pagina - 1;  

// Calculando pagina posterior  
$mais = $pagina + 1;

$pgs = ceil($total / $maximo);  
if($pgs > 1 ) 
{  
	// Mostragem de pagina  
	if($menos > 0) {  
	   echo "   <a href=\"#\" onclick=\"document.getElementById('pagina').value=1;document.getElementById('formulario').submit();\" class='texto_paginacao btn waves-circle waves-effect'>Primeira</a>";
	   echo "<a href=\"#\" onclick=\"document.getElementById('pagina').value=$menos;document.getElementById('formulario').submit();\"class='texto_paginacao btn waves-circle waves-effect'>&laquo;</a> ";
	}  
	// Listando as paginas  
	$z = 10;
	/*for($i=1;$i <= $pgs;$i++) {  
		if($i != $pagina) {  
		   echo "  <a href=\"?".$param."pagina=".$i."\" class='texto_paginacao'>$i</a>";  
		} else {  
			echo "  <strong lass='texto_paginacao_pgatual'>".$i."</strong>";  
		}  
	} */ 
	if ($pgs>10)
	{
		if($pagina<=5)
		{
			$zesq=1;
			$zdir=10;
		}
		elseif($pagina==$pgs)
		{
			$zesq=$pgs-10;
			$zdir=$pgs;
		}
		elseif($pagina+5>$pgs)
		{
			$zesq=$pgs-10;
			$zdir=$pgs;
		}
		else
		{
			$zesq=$pagina-5;
			$zdir=$pagina+5;
		}
	}
	else
	{
		$zesq=1;
		$zdir = $pgs;
	}
	
	for($i=$zesq;$i <= $zdir;$i++) {  
		if($i != $pagina) {  
		   echo "  <a href=\"#\" onclick=\"document.getElementById('pagina').value=$i;document.getElementById('formulario').submit();\" class='texto_paginacao btn waves-circle waves-effect'>$i</a>";
		} else {  
			echo "  <strong class='texto_paginacao_pgatual'>".$i."</strong>";  
		}  
	} 
	if($mais <= $pgs) {  
	   echo "   <a href=\"#\" onclick=\"document.getElementById('pagina').value=$mais;document.getElementById('formulario').submit();\" class='texto_paginacao btn waves-circle waves-effect'>&raquo;</a>";
	   echo "<a href=\"#\" onclick=\"document.getElementById('pagina').value=$pgs;document.getElementById('formulario').submit();\" class='texto_paginacao btn waves-effect last'>Ultima</a> ";
	}  
	
	?>
	&nbsp;&nbsp;P&aacute;g.:
	<select onchange="document.getElementById('pagina').value=this.value;document.getElementById('formulario').submit();">
		<?php for($x=1;$x<=$pgs;$x++){?>
    <option value="<?php echo $x;?>" <?php echo ($pagina==$x)?"selected":"";?>><?php echo $x;?></option>
		<?php } ?>
	</select>
        <input type="hidden" name="pagina" id="pagina" value="<?php echo $pagina;?>">
	<?php
}      
	
?>
