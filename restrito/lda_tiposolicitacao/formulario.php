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
	function edita(idtiposolicitacao,nome,instancia){
		document.getElementById("nome").value = nome;
		document.getElementById("idtiposolicitacao").value = idtiposolicitacao;
		document.getElementById("instancia").value = instancia;
		document.getElementById("acao").value = "Alterar";
		document.getElementById("nome").focus();
	}

        function abreordenacao(campo)
        {
            document.getElementById('show_'+campo).style.display = "none";  
            document.getElementById('edit_'+campo).style.display = "";
        }

        function cancelaordenacao(campo)
        {
            document.getElementById('show_'+campo).style.display = "";  
            document.getElementById('edit_'+campo).style.display = "none";
        }

	function ordena(idtiposolicitacao,idtiposolicitacao_seguinte){
		document.getElementById("idtiposolicitacao").value = idtiposolicitacao;
                document.getElementById("idtiposolicitacao_seguinte").value = idtiposolicitacao_seguinte;
		document.getElementById("formulario").submit();
	}

        function limpa(){
		document.getElementById("nome").value = "";
		document.getElementById("idtiposolicitacao").value = "";
		document.getElementById("instancia").value = "";
		document.getElementById("acao").value = "Incluir";
		document.getElementById("nome").focus();
	}        
</script>

<div class="container-fluid">
	<form method="post" id="formulario">
	<input type="hidden" name="idtiposolicitacao" value="<?php echo $idtiposolicitacao;?>" id="idtiposolicitacao">
	<input type="hidden" name="idtiposolicitacao_seguinte" value="<?php echo $idtiposolicitacao_seguinte;?>" id="idtiposolicitacao_seguinte">
	<div class="row">
	  <div class="col-sm-1 col-xs-12">
		<h5 class="text-uppercase bold">Nome:</h5>
	  </div>
		<div class="col-md-2 col-xs-12">
			<div class="form-group">
					<label for="nome" class="input-label"><i class="material-icons">account_circle</i></label>
					<input type="text" name="nome" placeholder="Nome" class="form-control icon" value="<?php echo $nome;?>" maxlength="50" size="50" id="nome" />
			</div>
		</div>
	  
	  
		<div class="col-md-2 col-xs-12">
				<div class="form-group">
					<label for="instancia" class="input-label"><i class="material-icons">insert_drive_file</i></label>
					<select name="instancia" id="instancia" class="selectpicker icon">
						<option value="" <?php echo (empty($instancia))?"selected":""; ?>>---</option>
						<option value="I" <?php echo ($instancia=="I")?"selected":""; ?>><?php echo Solicitacao::getDescricaoTipoInstancia("I");?></option>
						<option value="S" <?php echo ($instancia=="S")?"selected":""; ?>><?php echo Solicitacao::getDescricaoTipoInstancia("S");?></option>
						<option value="U" <?php echo ($instancia=="U")?"selected":""; ?>><?php echo Solicitacao::getDescricaoTipoInstancia("U");?></option>
					</select>
				</div>
		</div>
	  
			  <div class="col-md-3">
					<!--input type="submit" value="buscar" class="btn btn-info waves-effect waves-button name="buscar" id="buscar" /-->
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