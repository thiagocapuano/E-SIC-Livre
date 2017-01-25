<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

 include("manutencao.php");
 ?>

<script language="JavaScript" src="../js/XmlHttpLookup.js"></script>
<script>
    function selecionaIdentificacao(valor)
    {
	
        if(valor=="A" || valor == "")
            document.getElementById('ldadosSolicitante').style.display='none';
        else
            document.getElementById('ldadosSolicitante').style.display='';
    }

    function selecionaTipoAssunto(valor)
    {
	
        if(valor=="E" || valor == "" || valor == "S")
		{
			document.getElementById('lnCategoria').style.display='none';
			document.getElementById('lnProblema').style.display='none';
			document.getElementById('lnEnderecoOcorrencia').style.display='none';
			document.getElementById('lnBairroOcorrencia').style.display='none';
			document.getElementById('lnComunidadeOcorrencia').style.display='none';
			document.getElementById('lnComplementoOcorrencia').style.display='none';
			document.getElementById('lnPontoReferencia').style.display='none';
			document.getElementById('lnLabelAnexo').style.display='none';
			document.getElementById('lnAnexo').style.display='none';
		}
        else
		{
			document.getElementById('lnCategoria').style.display='';
			document.getElementById('lnProblema').style.display='';
			document.getElementById('lnEnderecoOcorrencia').style.display='';
			document.getElementById('lnBairroOcorrencia').style.display='';
			document.getElementById('lnComunidadeOcorrencia').style.display='';
			document.getElementById('lnComplementoOcorrencia').style.display='';
			document.getElementById('lnPontoReferencia').style.display='';
			document.getElementById('lnLabelAnexo').style.display='';
			document.getElementById('lnAnexo').style.display='';
		}
    }

    //preenche o combo de acordo com o filtro de outro combo
    //parametros:
    //combo  - id do combo a ser preenchido
    //imagem - id da imagem a ser exibida durante o carregamento do combo
    //pagina - pagina que fara a pesquisa para preenchimento do combo
    //campo  - valor do combo que irá filtrar o preenchimento do combo
    function preencheCombo(combo,imagem,pagina,campo)
    {
        document.getElementById(combo).style.display='none';
        document.getElementById(imagem).style.display='';
        busca(campo+'&fld='+combo+'&img='+imagem,true,pagina);
    }
</script>

<script src="inc/js/functions.js"></script>
<h1>Cadastro de Demanda</h1>
<br><br>
*Campos em negrito s&atilde;o obrigat&oacute;rios
<form action="cadastro.php" id="formulario" method="post" enctype="multipart/form-data">

<input type="hidden" name="iddemanda" value="<?php echo $iddemanda; ?>">
<input type="hidden" name="nrdemanda" value="<?php echo $nrdemanda; ?>">
<input type="hidden" name="ano" value="<?php echo $ano; ?>">
<input type="hidden" name="statusdemanda" value="<?php echo $statusdemanda; ?>">
<input type="hidden" name="dtcontagemprazo" id="dtcontagemprazo" value="<?php echo $dtcontagemprazo;?>">
<input type="hidden" name="prazoresolucao" id="prazoresolucao" value="<?php echo $prazoresolucao;?>">
<input type="hidden" name="fltnumerodemanda" value="<?php echo $fltnumerodemanda; ?>">
<input type="hidden" name="fltsolicitante" value="<?php echo $fltsolicitante; ?>">
<input type="hidden" name="fltstatusdemanda" value="<?php echo $fltstatusdemanda; ?>">

<table align="center" cellpadding="0"  width="100%" cellspacing="1" id="lista">
	<tr>
		<th align="left" width="100%">DADOS DA DEMANDA </th>
	</tr>
	<tr id="ldadosDemanda">
		<td width="100%">
			<table align="center" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td align="left">Numero:</td>
				<td align="left">
					<?php echo $nrdemanda."/".$ano; ?>
				</td>
			</tr>
			<tr>
				<td align="left"><b>Assunto:</b></td>
				<td align="left" width="100%">
					<select name="tipoassunto" id="tipoassunto" onchange="selecionaTipoAssunto(this.value)">
						<option value="">-- selecione --</option>		
                                                <option value="D" <?php echo $tipoassunto=="D"?"selected":""; ?>><?php echo Demanda::getDescTipoAssunto("D");?></option>
                                                <option value="E" <?php echo $tipoassunto=="E"?"selected":""; ?>><?php echo Demanda::getDescTipoAssunto("E");?></option>
                                                <option value="P" <?php echo $tipoassunto=="P"?"selected":""; ?>><?php echo Demanda::getDescTipoAssunto("P");?></option>
                                                <option value="R" <?php echo $tipoassunto=="R"?"selected":""; ?>><?php echo Demanda::getDescTipoAssunto("R");?></option>
                                                <option value="S" <?php echo $tipoassunto=="S"?"selected":""; ?>><?php echo Demanda::getDescTipoAssunto("S");?></option>
					</select>
				</td>
			</tr>
			<tr>
                            <td align="left"><b>Secretaria:</b></td>
				<td align="left" width="100%">
					<select name="idsecretaria" id="idsecretaria"  onchange="preencheCombo('idcategoriaproblema','imgCarregandoCategoria','buscacategoriaproblema',this.value);">
						<option value="">-- selecione --</option>		
						<?php $rsCat = execQuery("select * from sis_secretaria order by nome"); ?>
						<?php while($row=mysqli_fetch_array($rsCat)){?>
							  <option value="<?php echo $row['idsecretaria'];?>" <?php echo $row['idsecretaria']==$idsecretaria?"selected":""; ?>><?php echo $row['nome'];?></option>
						<?php }?>
					</select>
				</td>
			</tr>
			<tr id="lnCategoria">
				<td align="left">Categoria:</td>
				<td align="left" width="100%">
					<select name="idcategoriaproblema" id="idcategoriaproblema" onchange="preencheCombo('idproblema','imgCarregandoProblema','buscaproblema',this.value);">
						<option value="">-- selecione --</option>		
						<?php $rsCat = execQuery("select * from ouv_categoriaproblema where status = 1 and idsecretaria = '$idsecretaria' order by descricao"); ?>
						<?php while($row=mysqli_fetch_array($rsCat)){?>
							  <option value="<?php echo $row['idcategoriaproblema'];?>" <?php echo $row['idcategoriaproblema']==$idcategoriaproblema?"selected":""; ?>><?php echo $row['descricao'];?></option>
						<?php }?>
					</select>
                                        <img src="../img/loading.gif" border="0" id="imgCarregandoCategoria" style="display:none" />
				</td>
			</tr>
			<tr id="lnProblema">
				<td align="left">Problema/Servi&ccedil;o:</td>
				<td align="left" width="100%">
					<select name="idproblema" id="idproblema">
						<option value="">-- selecione --</option>		
						<?php $rsCat = execQuery("select * from ouv_problema where statusproblema = 1 and idcategoria = '$idcategoriaproblema' order by tituloproblema"); ?>
						<?php while($row=mysqli_fetch_array($rsCat)){?>
							  <option value="<?php echo $row['idproblema'];?>" <?php echo $row['idproblema']==$idproblema?"selected":""; ?>><?php echo $row['tituloproblema'];?></option>
						<?php }?>
					</select>
                                        <img src="../img/loading.gif" border="0" id="imgCarregandoProblema" style="display:none" />
				</td>
			</tr>
			<tr>
				<td align="left"><b>Descri&ccedil;&atilde;o:</b></td>
				<td align="left"><textarea name="descricaoproblema" rows="5" cols="60" onkeyup="setMaxLength(4000,this);"><?php echo $descricaoproblema;?></textarea></td>
			</tr>
			<tr id="lnEnderecoOcorrencia">
				<td align="left"><b>Endere&ccedil;o da Ocorr&ecirc;ncia:</b></td>
				<td align="left">
					<input type="text" name="nomelogradouroservico" id="nomelogradouroservico" value="<?php echo $nomelogradouroservico;?>" maxlength="255" size="40" />
					<b>N&ordm;</b> 
					<input type="text" name="nrlogradouroservico" id="nrlogradouroservico" value="<?php echo $nrlogradouroservico;?>" maxlength="20" size="20"  />
				</td>
			</tr>
			<tr id="lnBairroOcorrencia">
				<td align="left"><b>Bairro:</b></td>
				<td align="left">
					<select name="idbairroservico" id="idbairroservico" onchange="preencheCombo('idcomunidadeservico','imgCarregando','buscacomunidade',this.value);">
						<option value="">- Bairro -</option>		
						<?php $rsBai = execQuery("select * from gen_bairros where municipio_id = 7221 order by nome"); ?>
						<?php while($row=mysqli_fetch_array($rsBai)){?>
							  <option value="<?php echo $row['id'];?>" <?php echo $row['id']==$idbairroservico?"selected":""; ?>><?php echo $row['nome'];?></option>
						<?php }?>
					</select>
				</td>
			</tr>
			<tr id="lnComunidadeOcorrencia">
				<td align="left">Comunidade:</td>
				<td align="left">
					<select name="idcomunidadeservico" id="idcomunidadeservico" >
						<option value="">- Comunidade -</option>		
						<?php $rsCom = execQuery("select * from gen_conjuntohabitacional where idbairro = $idbairroservico order by descricaoconjuntohabitacional"); ?>
						<?php while($row=mysqli_fetch_array($rsCom)){?>
							  <option value="<?php echo $row['idconjuntohabitacional'];?>" <?php echo $row['idconjuntohabitacional']==$idcomunidadeservico?"selected":""; ?>><?php echo $row['descricaoconjuntohabitacional'];?></option>
						<?php }?>
					</select>
					<img src="../img/loading.gif" border="0" id="imgCarregando" style="display:none" />
				</td>
			</tr>
			<tr id="lnComplementoOcorrencia">
				<td align="left">Complemento:</td>
				<td align="left">
					<input type="text" name="complementoservico" id="complementoservico" value="<?php echo $complementoservico;?>" maxlength="50" size="30" />
					CEP: 
					<input type="text" name="cepservico" value="<?php echo $cepservico;?>" maxlength="8" size="10" />		
				</td>
			</tr>
			<tr id="lnPontoReferencia">
				<td align="left">Ponto de refer&ecirc;ncia</td>
				<td align="left">
					<textarea name="pontoreferenciaservico" rows="4" cols="60" onkeyup="setMaxLength(300,this);"><?php echo $pontoreferenciaservico;?></textarea>
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr id="lnLabelAnexo">
		<th align="left">ANEXOS</th>
	</tr>
	<tr id="lnAnexo">
		<td width="100%">
			<table align="center" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td align="left">Arquivo 1:</td>
				<td align="left">
					<input name="arquivos[]" type="file" /><br />
				</td>
			</tr>
			<tr>
				<td align="left">Arquivo 2:</td>
				<td align="left">
					<input name="arquivos[]" type="file" /><br />
				</td>
			</tr>
			<tr>
				<td align="left">Arquivo 3:</td>
				<td align="left">
					<input name="arquivos[]" type="file" /><br />
				</td>
			</tr>
			</table>
                    
                        <table align="center" width="100%" cellpadding="0" cellspacing="1">
                        <tr><th>Arquivos enviados</th></tr>
                        <?php
                        $rsAnexo = execQuery("select * from ouv_demandaanexo where iddemanda=$iddemanda order by idanexodemanda");
                        $i=0;
                        while($row = mysqli_fetch_array($rsAnexo)){
                            $i++;
                            ?>
                            <tr>
                                <td align="left"><a href="<?php echo getURL("ouv")."/".$row['nomeanexodemanda'];?>" target="_blank"><?php echo "Arquivo ".$i;?></a></td>
                            </tr>
                            <?php 
                        }?>
			</table>
		</td>
	</tr>
	<tr>
		<th align="left" width="100%">SOLICITANTE</th>
	</tr>
	<tr>
		<td align="left" width="100%" width="100%">
			<b>Tipo de Identifica&ccedil;&atilde;o:</b>
			<select name="tipoidentificacao" id="tipoidentificacao" onchange="selecionaIdentificacao(this.value);">
				<option value="">-- selecione --</option>		
                                <option value="A" <?php echo $tipoidentificacao=="A"?"selected":""; ?>><?php echo Demanda::getDescTipoIdentificacao("A");?></option>
                                <option value="N" <?php echo $tipoidentificacao=="N"?"selected":""; ?>><?php echo Demanda::getDescTipoIdentificacao("N");?></option>
                                <option value="S" <?php echo $tipoidentificacao=="S"?"selected":""; ?>><?php echo Demanda::getDescTipoIdentificacao("S");?></option>
			</select>
		</td>
	</tr>
	<tr id="ldadosSolicitante">
		<td width="100%">
			<table align="center" width="100%" cellpadding="0" cellspacing="1">
			<tr>
				<td align="left"><b>Nome:</b></td>
				<td align="left"><input type="text" name="nomesolicitante" value="<?php echo $nomesolicitante;?>" size="58" maxlength="150" /> </td>
			</tr>
			<tr>
				<td align="left"><b>E-mail:</b></td>
				<td align="left">
					<input type="text" name="emailsolicitante" id="emailsolicitante" value="<?php echo $emailsolicitante;?>" size="58" maxlength="100" />
				</td>
			</tr>
			<tr>
				<td align="left"><b>Telefone:</b></td>
				<td align="left">
					<input type="text" name="telefonesolicitante" id="telefonesolicitante" value="<?php echo $telefonesolicitante;?>" size="10" maxlength="10" />
				</td>
			</tr>	
			<tr>
				<td align="left">CEP:</td>
				<td align="left">
					<input type="text" name="cepsolicitante" id="cepsolicitante" value="<?php echo $cepsolicitante;?>" autocomplete="off" onkeyup="busca(this.value,this.value.length==8,'../inc/buscacep')" maxlength="8" size="10" />		
					<img src="../img/busca_cep_correios.gif" border="0" onclick="javascript:window.open('http://www.buscacep.correios.com.br/servicos/dnec/menuAction.do?Metodo=menuEndereco','')" align="absmiddle" style="margin:0px;padding:0px;cursor:hand" title="Pesquisa CEP no site dos correios">
					<script>
						InitQueryCode('cepsolicitante', '../inc/lkpcep.php?q=');
					</script>
				</td>
			</tr>
			<tr>
				<td align="left">Logradouro:</td>
				<td align="left">
					<input type="text" name="logradourosolicitante" id="logradouro" value="<?php echo $logradourosolicitante;?>" maxlength="255" size="60" />
				</td>
			</tr>
			<tr>
				<td align="left">Bairro:</td>
				<td align="left">
					<input type="text" onmouseover="this.title=this.value" name="bairrosolicitante" id="bairro" value="<?php echo $bairrosolicitante;?>" maxlength="100" size="25">
					Cidade:
					<input type="text" name="cidadesolicitante" onmouseover="this.title=this.value" id="cidade" value="<?php echo $cidadesolicitante;?>" maxlength="255" size="38">
					<select name="estadosolicitante" id="uf">
						<option value="">- UF -</option>		
						<?php $rsuf = execQuery("select * from gen_estados order by sigla"); ?>
						<?php while($row=mysqli_fetch_array($rsuf)){?>
							  <option value="<?php echo $row['sigla'];?>" <?php echo $row['sigla']==$estadosolicitante?"selected":""; ?>><?php echo $row['sigla'];?></option>
						<?php }?>
					</select>
				</td>
			</tr>
			<tr>
				<td align="left">N&uacute;mero:</td>
				<td align="left">
					<input type="text" name="nrlogradourosolicitante" id="numero" value="<?php echo $nrlogradourosolicitante;?>" maxlength="20" size="20"  />
					Complemento:
					<input type="text" name="complementosolicitante" id="complemento" value="<?php echo $complementosolicitante;?>" maxlength="50" size="30" />
				</td>
			</tr>
			</table>
		</td>
	</tr>
	<tr>
		<th align="left">INFORMA&Ccedil;&Otilde;ES EXTRAS</th>
	</tr>
        <tr id="lnObservacao">
		<td width="100%">
                    <table align="center" width="100%" cellpadding="0" cellspacing="1">
                        <tr>
                            <td align="left"><b>Origem:</b></td>
                            <td align="left" width="100%">
                                <?php 
                                //se origem nao for WEB ou for uma inclusao de demanda, exibe seleção de origem
                                if ($origem != "W" or empty($iddemanda)){
                                    ?>
                                    <select name="origem" id="origem">
                                            <option value="">-- selecione --</option>		
                                            <option value="T" <?php echo $origem=="T"?"selected":""; ?>><?php echo Demanda::getDescOrigem("T");?></option>
                                            <option value="E" <?php echo $origem=="E"?"selected":""; ?>><?php echo Demanda::getDescOrigem("E");?></option>
                                    </select>
                                    <?php 
                                }else{
                                    ?>
                                    WEB
                                    <input type="hidden" name="origem" id="origem" value="<?php echo $origem;?>">
                                    <?php 
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="left"><b>Prioridade:</b></td>
                            <td align="left" width="100%">
                                    <select name="prioridade" id="prioridade">
                                            <option value="">-- selecione --</option>		
                                            <option value="A" <?php echo $prioridade=="A"?"selected":""; ?>><?php echo Demanda::getDescPrioridade("A");?></option>
                                            <option value="M" <?php echo $prioridade=="M"?"selected":""; ?>><?php echo Demanda::getDescPrioridade("M");?></option>
                                            <option value="B" <?php echo $prioridade=="B"?"selected":""; ?>><?php echo Demanda::getDescPrioridade("B");?></option>
                                    </select>
                            </td>
                        </tr>
                        <tr>
                                <td align="left" colspan="2"><input type="checkbox" name="publico" value="1" <?php ($publico)?"checked":"";?>> Demanda pode ser vista na WEB (p&uacute;blica)</td>
                        </tr>
                    </table>
                </td>
        </tr>
	<tr>
		<td>
			<br><input type="submit" value="<?php echo $acao;?>" class="botaoformulario"  name="acao" />
                        <input type="button" value="Voltar" class="botaoformulario"  name="voltar" onclick="location.href='index.php?<?php echo $parametrosIndex;?>'" />
		</td>
	</tr>
</table>
</form>
<script>
	selecionaIdentificacao("<?php echo $tipoidentificacao; ?>");
	selecionaTipoAssunto("<?php echo $tipoassunto; ?>");
</script>
<?php 
getErro($erro);
include("../inc/rodape.php"); 
?>
