<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/


//retorna erro de uma ação se houver (em alert do javascript) 
getErro($erro);

?>
<script>
	function edita(idgrupo,nome,descricao, ativo){
		document.getElementById("nome").value = nome;
		document.getElementById("idgrupo").value = idgrupo;
		document.getElementById("descricao").value = descricao;
		document.getElementById("ativo").value = (ativo=="2")?"0":"1";
		document.getElementById("acao").value = "Alterar";
		document.getElementById("nome").focus();
	}
	
        function limpa(){
		document.getElementById("nome").value = "";
		document.getElementById("idgrupo").value = "";
		document.getElementById("descricao").value = "";
		document.getElementById("ativo").value = "";
		document.getElementById("acao").value = "Incluir";
		document.getElementById("nome").focus();
	}        
</script>

<div class="container-fluid">
	<form method="post">
		<div class="row">
		<div class="col-sm-1 col-xs-12">
			<h5 class="text-uppercase bold">Buscar:</h5>
		</div>
		<input type="hidden" name="idgrupo" value="<?php echo $idgrupo;?>" id="idgrupo">
			<div class="col-md-2 col-xs-12">
				<div class="form-group">
					<label for="nome" class="input-label"><i class="material-icons">account_circle</i></label>
					<input type="text" class="form-control icon" name="nome" value="<?php echo $nome;?>" maxlength="30" size="30" id="nome" placeholder="Nome"/>
				</div>
			</div>  
			<div class="col-md-2 col-xs-12">
				<div class="form-group">
					<label for="descricao" class="input-label"><i class="material-icons">account_circle</i></label>
					<input type="text" class="form-control icon" name="descricao" value="<?php echo $descricao;?>" maxlength="70" size="50" id="descricao" placeholder="Descrição"/>
				</div>
			</div>	
			  
			<div class="col-md-2 col-xs-12">
				<div class="form-group">
					<label for="instancia" class="input-label"><i class="material-icons">insert_drive_file</i></label>
						<select name="ativo" id="ativo" class="selectpicker icon">
							<option value="" <?php echo (empty($ativo))?"selected":""; ?>>---</option>
							<option value="1" <?php echo ($ativo=="1")?"selected":""; ?>>Ativo</option>
							<option value="2" <?php echo ($ativo=="2")?"selected":""; ?>>Inativo</option>
					</select>
				</div>
			</div>
			
			<div class="col-md-3">
					<input type="submit" value="buscar" class="btn btn-info waves-effect waves-button" name="buscar" id="buscar" />
					<input type="submit" value="<?php echo $acao;?>" class="btn btn-success waves-effect waves-button" name="acao" id="acao" />
					<input type="button" value="Limpar" name="limpar" class="btn btn-danger waves-effect waves-button" onclick="limpa()" />
			</div>
			
		</div>
	</form>
</div>
<script>
	//seta o foco
	document.getElementById("nome").focus();
</script>