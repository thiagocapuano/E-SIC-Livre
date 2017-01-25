<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

	include_once "manutencao.php";
?>
<script>
	function adicionaItem(campoOrig,campoDest) 
	{
		x = campoOrig.value;
		
		if (x == "")
		{
			alert('Selecione um item!');
		}
		
		var len = campoDest.length;
		
		for(var i = 0; i < campoOrig.length; i++) 
		{
			if ((campoOrig.options[i] != null) && 
				  (campoOrig.options[i].selected)) 
			{
				
				campoDest.options[len] = new Option(campoOrig.options[i].text, campoOrig.options[i].value); 
				len++;
				campoOrig.options[i] = null;  
				i--;
			}
		}
		
		sortSelect(campoOrig);
		sortSelect(campoDest);
	}

	function sortSelect(obj){
		var o = new Array();
		for (var i=0; i<obj.options.length; i++){
			o[o.length] = new Option(obj.options[i].text, obj.options[i].value, obj.options[i].defaultSelected, obj.options[i].selected);
		}
		o = o.sort(
			function(a,b){ 
				if ((a.text+"") < (b.text+"")) { return -1; }
				if ((a.text+"") > (b.text+"")) { return 1; }
				return 0;
			} 
		);

		for (var i=0; i<o.length; i++){
			obj.options[i] = new Option(o[i].text, o[i].value, o[i].defaultSelected, o[i].selected);
		}
	}
	
	function selecionatudo(obj)
	{
        
		var selecionados = document.getElementById(obj);
		
		for(i=0; i<=selecionados.length-1; i++){
		
				selecionados.options[i].selected = true;
		
                }
        
        }
        
</script>
<div class="container-fluid">
    <header class="header-title">
        <h1>Cadastro de Usuários</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo URL_BASE_SISTEMA; ?>index/">Início</a></li>
            <li><a href="index.php?sis_usuario">Cadasto de Usuários</a></li>
            <li class="active">Edição</li>
        </ol>
    </header>
</div>
<section>
    <div class="container-fluid">
        <form action="?sis_usuario&p=cadastro" style="padding-bottom:30px;" method="post" id="formulario" class="sortable-list">
			<input type="hidden" name="idusuario" value="<?php echo $idusuario;?>">
            <fieldset>
                <header>Dados Pessoais</header>
                 <div class="row">
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label for="matricula" class="input-label"><i class="material-icons">account_circle</i></label>
                            <input type="text" class="form-control icon" id="matricula" name="matricula" value="<?php echo $matricula; ?>" maxlength="8" size="10" title="Informe até 8 dígitos de matricula" onkeyup="soNumero(this);" placeholder="Matrícula"/>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label for="cpf" class="input-label"><i class="material-icons">account_circle</i></label>
                            <input type="text" class="form-control icon" id="cpf" name="cpfusuario" value="<?php echo $cpfusuario; ?>" maxlength="11" size="12" title="Informe os 11 digitos do CPF" onkeyup="soNumero(this);" placeholder="CPF"/>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xs-12">
                        <div class="form-group">
                            <label for="nome" class="input-label"><i class="material-icons">account_circle</i></label>
                            <input type="text" name="nome" class="form-control icon" id="nome" value="<?php echo $nome;?>" placeholder="Nome" maxlength="50" size="30" />
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-2 col-xs-12">
                        <div class="form-group">
                            <label for="login" class="input-label"><i class="material-icons">account_circle</i></label>
                            <input type="text" name="login" class="form-control icon" id="login" value="<?php echo $login;?>" placeholder="Login" maxlength="50" size="30" />
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-2 col-xs-12">
                        <div class="form-group active">
                            <label for="status" class="input-label"><i class="material-icons">info</i></label>
                            <select name="status" id="status" class="selectpicker icon">
                                <option value="A" <?php echo ($status=="A" )? "selected": ""; ?>>Ativo</option>
                                <option value="I" <?php echo ($status=="I" )? "selected": ""; ?>>Inativo</option>
                            </select>
                        </div>
                    </div>
					<!--div class="col-sm-4 col-md-4 col-xs-12">
                        <div class="form-group">
                            <label for="email" class="input-label"><i class="material-icons">mail_circle</i></label>
                            <input type="text" name="email" class="form-control icon" id="email" value="<?php echo $email;?>" maxlength="50" size="50" />
                        </div>
                    </div-->
					<div class="col-sm-4 col-xs-12">
						<div class="form-group">
							<label for="senha" class="input-label"><i class="material-icons">bookmark</i></label>
							<select name="idsecretaria" class="selectpicker trigger icon" id="idsecretaria">
								<option value="">-- Selecione o SIC --</option>
								<?php
									$sql = "select * from sis_secretaria order by sigla";
									$resultado = execQuery($sql);
									$num = mysqli_num_rows($resultado);
									while($registro = mysqli_fetch_array($resultado)){
								?>
									<option value="<?php echo $registro["idsecretaria"]; ?>" <?php echo ($idsecretaria==$registro[ "idsecretaria"])? "selected": ""; ?>>
										<?php echo $registro["sigla"]; ?>
									</option>
								<?php } ?>
							</select>
						</div>
					</div>					
                    <div class="col-sm-4 col-md-2 col-xs-12">
                        <div class="form-group">
                            <label for="senha" class="input-label"><i class="material-icons">lock</i></label>
                            <input type="password" placeholder="**********" id="senha" class="form-control icon" name="chave" value="<?php echo $chave;?>" />
							<br>
                            <?php
                                if(!empty($idusuario)) echo "<span class='mensagem'>(Só informar se for alterar)</span>";
                            ?>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <header>E-sic</header>
                <div class="row">
                    <div class="col-xs-5">
                        <header style="margin:0;" class="text-center">Perfis</header>
                        <select name="gruposdisponiveis" id="gruposdisponiveis" title="Dê um duplo clique para selecionar todos" ondblclick="selecionatudo(this.id);" multiple="multiple" style="height: 300px; width: 100%; font-size:10">
                            <?php
                                $sql="select nome, descricao from sis_grupo g order by nome";
                                
                                $rs = execQuery($sql);

                                while ($row = mysqli_fetch_array($rs)) { 
                                    if(!estaSelecionado($row['nome']))
                                    {
                                        ?>
                                        <option value="<?php echo $row['nome']; ?>" title="<?php echo $row['descricao']; ?>">
                                            <?php echo $row['nome']; ?>
                                        </option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-1">
                        <br />
                        <button type="button" value=">>" class="btn btn-info waves-circle" title="Selecionar" onclick="adicionaItem(document.getElementById('gruposdisponiveis'),document.getElementById('gruposselecionados'));"><i class="material-icons">keyboard_arrow_right</i></button>
                        <br />
                        <br />
                        <button type="button" value="<<" class="btn btn-info waves-circle" title="Retirar" onclick="adicionaItem(document.getElementById('gruposselecionados'),document.getElementById('gruposdisponiveis'));"><i class="material-icons">keyboard_arrow_left</i></button>
                    </div>
                    <div class="col-xs-5">
                        <header style="margin:0;" class="text-center">Perfis do Usuário</header>
                        <select name="gruposselecionados[]" id="gruposselecionados" title="Dê um duplo clique para selecionar todos" ondblclick="selecionatudo(this.id);" multiple="multiple" style="height: 300px; width: 100%; font-size:10">
                            <?php
                                $sql="select nome, descricao from sis_grupo g order by nome";
                                
                                $rs = execQuery($sql);

                                while ($row = mysqli_fetch_array($rs)) { 
                                    if(estaSelecionado($row['nome']))
                                    {
                                        ?>
                                        <option value="<?php echo $row['nome']; ?>" title="<?php echo $row['descricao']; ?>">
                                            <?php echo $row['nome']; ?>
                                        </option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>


                <div class="row" style="margin-top:30px;">
                    <div class="col-xs-5">
                        <header  style="margin:0;" class="text-center">SIC's</header>
                        <select name="sics" id="sics" multiple="multiple" title="Dê um duplo clique para selecionar todos" ondblclick="selecionatudo(this.id);" style="height: 300px; width: 100%; font-size:10">
                                    <?php
                                $sql="select nome, sigla, idsecretaria from sis_secretaria order by sigla";
                                $rs = execQuery($sql);

                                while ($row = mysqli_fetch_array($rs)) { 
                                    if(!estaSelecionadoSIC($row['idsecretaria']))
                                    {
                                        ?>
                                        <option title="<?php echo $row['nome']; ?>" value="<?php echo $row['idsecretaria']; ?>">
                                            <?php echo $row['sigla']; ?>
                                        </option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-xs-1">
                        <br />
                        <button type="button" value=">>" class="btn btn-info waves-circle" title="Selecionar" onclick="adicionaItem(document.getElementById('sics'),document.getElementById('sicselecionados'));"><i class="material-icons">keyboard_arrow_right</i></button>
                        <br />
                        <br />
                        <button type="button" value="<<" class="btn btn-info waves-circle" title="Retirar" onclick="adicionaItem(document.getElementById('sicselecionados'),document.getElementById('sics'));"><i class="material-icons">keyboard_arrow_left</i></button>
                    </div>
                    <div class="col-xs-5">
                        <header  style="margin:0;" class="text-center">SIC's Alternativos do Usuário</header>
                        <select name="sicselecionados[]" id="sicselecionados" title="Dê um duplo clique para selecionar todos" ondblclick="selecionatudo(this.id);" multiple="multiple" style="height: 300px; width: 100%; font-size:10">
                            <?php
                                $sql="select nome, sigla, idsecretaria from sis_secretaria order by sigla";
                                $rs = execQuery($sql);

                                while ($row = mysqli_fetch_array($rs)) { 
                                    if(estaSelecionadoSIC($row['idsecretaria']))
                                    {
                                        ?>
                                        <option title="<?php echo $row['nome']; ?>" value="<?php echo $row['idsecretaria']; ?>">
                                            <?php echo $row['sigla']; ?>
                                        </option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </fieldset>
            <button type="submit" class="btn btn-success waves-effect" value="<?php echo $acao;?>" name="<?php echo $acao;?>" onclick="selecionatudo('gruposselecionados');selecionatudo('sicselecionados');"><?php echo $acao;?></button>
            <button type="button" onClick="document.location = '?sis_usuario';" class="btn btn-danger waves-effect" value="Voltar">Voltar</button>
        </form>
    </div>
</section>

<?php
	getErro($erro);	
?>
