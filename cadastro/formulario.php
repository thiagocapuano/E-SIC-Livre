<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/
?>
<script language="JavaScript" src="<?php echo SITELNK;?>js/XmlHttpLookup.js"></script>

<script>
	function selecionaTipoPessoa(tipo)
	{
		if(tipo=="F")
		{
			document.getElementById('lblNome').innerHTML = "Nome";
			document.getElementById('lblCpfcnpj').innerHTML = "CPF";
                        document.getElementById('lnEscolaridade').style.display = "";
                        document.getElementById('lnProfissao').style.display = "";
		}
		else
		{
			document.getElementById('lblNome').innerHTML = "Razão Social";
			document.getElementById('lblCpfcnpj').innerHTML = "CNPJ";
                        document.getElementById('lnEscolaridade').style.display = "none";
                        document.getElementById('lnProfissao').style.display = "none";
		}
	}
</script>


<div align="center">
<table align="center" cellpadding="0" cellspacing="1">
	<tr style="margin: 5px;">
		<th style="border-bottom:1px solid #000000" align="left" colspan="2">Dados Pessoais</th><br>
	</tr>
	<tr id="ldadosCidadao">
		<td colspan="2">
			<table align="left" width="100%" cellpadding="10" cellspacing="10">
                        <tr>
                                <td align="left">*Tipo de Pessoa:</td>
                                <td align="left" valign="top">
                                        <input type="radio" name="tipopessoa" value="F" <?php echo ($tipopessoa=="F")?"checked":""; ?> onclick="selecionaTipoPessoa('F');">
                                        F&iacute;sica
                                        <input type="radio" name="tipopessoa" value="J" <?php echo ($tipopessoa=="J")?"checked":""; ?> onclick="selecionaTipoPessoa('J');">
                                        Jur&iacute;dica
                                </td>
                        </tr>
			<tr>
				<td align="left">*<span id="lblNome"><?php echo ($tipopessoa=="J")?"Razão Social":"Nome"; ?></span>:</td>
				<td align="left"><input type="text" name="nome" id="nome" value="<?php echo $nome;?>" size="58" maxlength="100" /> </td>
			</tr>
			<tr>
				<td align="left">*<span id="lblCpfcnpj"><?php echo ($tipopessoa=="J")?"CNPJ":"CPF"; ?></span>:</td>
				<td align="left">
					<input type="text" name="cpfcnpj" value="<?php echo $cpfcnpj;?>" onkeyup="soNumero(this);" onblur="document.getElementById('span_usuario').innerHTML = this.value;" size="14" maxlength="14" /> 
				</td>  
			</tr>
			<tr id="lnFaixaEtaria">
				<td align="left">Faixa Et&aacute;ria:</td>
				<td align="left">
                                        <select name="idfaixaetaria" id="idfaixaetaria">
                                                <option value="">----</option>		
                                                <?php $rsFxt = execQuery("select * from lda_faixaetaria order by nome"); ?>
                                                <?php while($rowfxt=mysqli_fetch_array($rsFxt)){?>
                                                            <option value="<?php echo $rowfxt['idfaixaetaria'];?>" <?php echo $rowfxt['idfaixaetaria']==$idfaixaetaria?"selected":""; ?>><?php echo $rowfxt['nome'];?></option>
                                                <?php }?>
                                        </select>

				</td>  
			</tr>
			<tr id="lnEscolaridade">
				<td align="left">Escolaridade:</td>
				<td align="left">
                                        <select name="idescolaridade" id="idescolaridade">
                                                <option value="">----</option>		
                                                <?php $rsEsc = execQuery("select * from lda_escolaridade order by nome"); ?>
                                                <?php while($rowesc=mysqli_fetch_array($rsEsc)){?>
                                                            <option value="<?php echo $rowesc['idescolaridade'];?>" <?php echo $rowesc['idescolaridade']==$idescolaridade?"selected":""; ?>><?php echo $rowesc['nome'];?></option>
                                                <?php }?>
                                        </select>

				</td>  
			</tr>
			<tr id="lnProfissao">
				<td align="left">Profiss&atilde;o:</td>
				<td align="left">
					<input type="text" name="profissao" value="<?php echo $profissao;?>" size="30" maxlength="50" /> 
				</td>  
			</tr>
			<tr>
				<td align="left">Tipo Telefone:</td>
				<td align="left">
                                        <select name="idtipotelefone" id="idtipotelefone">
                                                <option value="">----</option>		
                                                <?php $rstel = execQuery("select * from lda_tipotelefone order by nome"); ?>
                                                <?php while($rowtel=mysqli_fetch_array($rstel)){?>
                                                            <option value="<?php echo $rowtel['idtipotelefone'];?>" <?php echo $rowtel['idtipotelefone']==$idtipotelefone?"selected":""; ?>><?php echo $rowtel['nome'];?></option>
                                                <?php }?>
                                        </select>
                                        Telefone: (<input type="text" name="dddtelefone" value="<?php echo $dddtelefone;?>" onkeyup="soNumero(this);" size="2" maxlength="2" /> )
                                        <input type="text" name="telefone" value="<?php echo $telefone;?>" onkeyup="soNumero(this);" size="15" maxlength="15" />
				</td>  
			</tr>
			<tr>
				<td align="left">*E-mail:</td>
				<td align="left">
					<input type="text" name="email" value="<?php echo $email;?>" size="50" maxlength="150" />
				</td>
			</tr>
			<tr>
				<td align="left">*Confirme E-mail:</td>
				<td align="left">
					<input type="text" name="confirmeemail" value="<?php echo $confirmeemail;?>" size="50" maxlength="150" />
				</td>
			</tr>
			</table>
		</td>
	</tr>
	
	<tr>
		<th style="border-bottom:1px solid #000000" align="left" colspan="2">Endere&ccedil;o</th>
	</tr>
	<tr id="lendereco">
		<td colspan="2">
			<input type="hidden" name="idlogradouro" id="idlogradouro" value="<?php echo $idlogradouro;?>">
			<table width="100%">
				<tr>
					<td align="left">CEP:</td>
					<td align="left">
						<input type="text" name="cep" id="cep" value="<?php echo $cep;?>" autocomplete="off" onkeyup="busca(this.value,this.value.length==8,'<?php echo URL_BASE_SISTEMA;?>inc/buscacep')" onclick="busca(this.value,this.value.length==8,'<?php echo URL_BASE_SISTEMA;?>inc/buscacep')" maxlength="8" size="10" />		
						<a href="http://www.buscacep.correios.com.br/servicos/dnec/menuAction.do?Metodo=menuEndereco" target="_blank"><img src="<?php echo URL_BASE_SISTEMA;?>img/busca_cep_correios.gif" border="0" align="absmiddle" style="margin:0px;padding:0px" title="Pesquisa CEP no site dos correios"></a>
					</td>
				</tr>
				<tr>
					<td align="left">Logradouro:</td>
					<td align="left">
						<input type="text" name="logradouro" id="logradouro" value="<?php echo $logradouro;?>" maxlength="255" size="60" />
					</td>
				</tr>
				<tr>
					<td align="left">Bairro:</td>
					<td align="left">
						<input type="text" onmouseover="this.title=this.value" name="bairro" id="bairro" value="<?php echo $bairro;?>" maxlength="100" size="50">
					</td>
				</tr>
				<tr>
					<td align="left">Cidade:</td>
					<td><input type="text" name="cidade" onmouseover="this.title=this.value" id="cidade" value="<?php echo $cidade;?>" maxlength="255" size="35">
						<select name="uf" id="uf">
							<option value="">- UF -</option>		
							<?php $rsuf = execQuery("select sigla from gen_estados order by sigla"); ?>
							<?php while($rowuf=mysqli_fetch_array($rsuf)){?>
								  <option value="<?php echo $rowuf['sigla'];?>" <?php echo $rowuf['sigla']==$uf?"selected":""; ?>><?php echo $rowuf['sigla'];?></option>
							<?php }?>
						</select>
					</td>
				</tr>
				<tr>
					<td align="left">Número:</td>
					<td align="left">
						<input type="text" name="numero" id="numero" value="<?php echo $numero;?>" maxlength="10" size="10"  />
						Complemento:
						<input type="text" name="complemento" id="complemento" value="<?php echo $complemento;?>" maxlength="50" size="50" margin=10px; />
					</td>
				</tr>
				<script>
					InitQueryCode('cep', '<?php echo SITELNK;?>inc/lkpcep.php?q=');
					document.getElementById('nome').focus();		
				</script>
			</table>
		</td>
	</tr>

	<tr>
		<th style="border-bottom:1px solid #000000" align="left" colspan="2">Acesso ao e-SIC</th>
	</tr>
        <tr>
                <td align="left">*Usu&aacute;rio:</td>
                <td align="left">
                    <b>
                    <span id="span_usuario">&nbsp;</span>
                    </b>
                </td>
        </tr>
        <tr>
                <td align="left">*Senha:</td>
                <td align="left">
                    <input type="password" name="senha" value="<?php echo $senha;?>" size="30" maxlength="30" />
                </td>
        </tr>
        <tr>
                <td align="left">*Confirme Senha:</td>
                <td align="left">
                    <input type="password" name="confirmasenha" value="<?php echo $confirmasenha;?>" size="30" maxlength="30" />
                </td>
        </tr>
        
	<tr><td colspan="2"><td></tr>
	<tr>
		<td colspan="2" align="center" style="border-top:1px solid #000000">
			<br><input type="submit" class="botaoformulario" value="Salvar" name="acao" />
		</td>
	</tr>
</table>

<script>selecionaTipoPessoa('<?php echo $tipopessoa;?>');</script>

</div>
