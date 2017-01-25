<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

?>
<input type="hidden" name="idsolicitante" value="<?php echo $idsolicitante;?>">
<table align="center" cellpadding="0" cellspacing="1">
	<tr>
		<td>
                        <?php if(!Solicitacao::existeSicCentralizador()){ //exibe SIC's caso não exista centralizador?>
			<tr>
				<td align="left">
                                    Destino:
                                    <select name="idsecretariaselecionada" id="idsecretaria">
                                            <option value="">----</option>		
                                            <?php $rsSic = execQuery("select idsecretaria, nome from sis_secretaria where ativado = 1 order by nome"); ?>
                                            <?php while($rowSic=mysqli_fetch_array($rsSic)){?>
                                                        <option value="<?php echo $rowSic['idsecretaria'];?>" <?php echo $rowSic['idsecretaria']==$idsecretariaselecionada?"selected":""; ?>><?php echo $rowSic['nome'];?></option>
                                            <?php }?>
                                    </select>
				</td>  
			</tr>
                        <?php }?>
			<tr>
				<td align="left">
                                    <textarea name="textosolicitacao" rows="20" cols="80" onkeyup="setMaxLength(4000,this);"><?php echo $textosolicitacao;?></textarea>
				</td>  
			</tr>
			<tr>
				<td align="left">
                                    <b>Forma de retorno:</b>
                                    <select name="formaretorno" id="formaretorno">
                                        <option value="E" <?php echo $formaretorno=="E"?"selected":""; ?>>E-mail</option>		
                                            <option value="C" <?php echo $formaretorno=="C"?"selected":""; ?>>Correio</option>		
                                            <option value="F" <?php echo $formaretorno=="F"?"selected":""; ?>>Fax</option>		
                                    </select>
				</td>  
			</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="2"></td></tr>
	<br>
	<input type="file" name="arquivo" id="arquivo" accept=".jpg,.jpeg,.pdf" size="1000"/>
	<br>
	<tr>
		<td colspan="2" align="center" style="border-top:1px solid #000000">
			<br><input type="submit" class="botaoformulario" value="Enviar" name="acao" />
		</td>
	</tr>
	<br>
	<br>
*Selecione Apenas arquivos de Imagem .jpeg .jpg ou Formato .pdf, Tamanho Maximo 2MB.
