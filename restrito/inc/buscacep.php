<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

  include "../inc/database.php";
  
  $f = $_REQUEST['f'];

  $sql = "select cep, logradouro, 
				 tipologradouro, bairro, 
				 cidade, uf
		  from vw_cep
		  where cep = '$f' 
		  ";

  $resultado = execQuery($sql);
  $row = mysqli_fetch_array($resultado);
   
  ?>
<script>
	
	parent.document.getElementById("logradouro").value = "<?php echo $row['tipologradouro']." ".$row['logradouro'];?>";
	parent.document.getElementById("bairro").value = "<?php echo $row['bairro'];?>";
	parent.document.getElementById("cidade").value = "<?php echo $row['cidade'];?>";
	parent.document.getElementById("uf").value = "<?php echo $row['uf'];?>";
	
</script>

  
  
  
  
  