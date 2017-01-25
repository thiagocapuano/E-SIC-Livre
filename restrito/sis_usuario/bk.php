<form action="cadastro.php" method="post" id="formulario">
    <input type="hidden" name="idusuario" value="<?php echo $idusuario;?>">
    <table class="lista">
        <tr>
            <td>Matr&iacute;cula:</td>
            <td>
                <input type="text" id="matricula" name="matricula" value="<?php echo $matricula; ?>" maxlength="8" size="10" title="Informe até 8 dígitos de matricula" onkeyup="soNumero(this);" /> CPF:
                <input type="text" id="cpf" name="cpfusuario" value="<?php echo $cpfusuario; ?>" maxlength="11" size="12" title="Informe os 11 digitos do CPF" onkeyup="soNumero(this);" />
            </td>
        </tr>
        <tr>
            <td>Nome:</td>
            <td>
                <input type="text" name="nome" id="nome" value="<?php echo $nome;?>" maxlength="50" size="30" />
            </td>
        </tr>
        <tr>
            <td>Login:</td>
            <td>
                <input type="text" id="login" name="login" value="<?php echo $login;?>" />
            </td>
        </tr>
        <tr>
            <td>Status:</td>
            <td>
                <select name="status">
                    <option value="A" <?php echo ($status=="A" )? "selected": ""; ?>>Ativo</option>
                    <option value="I" <?php echo ($status=="I" )? "selected": ""; ?>>Inativo</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Senha de acesso:</td>
            <td>
                <input type="text" id="login" name="chave" value="<?php echo $chave;?>" />
                <?php
            if(!empty($idusuario)) echo "<font color='red'>(Só informar se for alterar)</font>";
            ?>
            </td>
        </tr>
        <tr>
            <td>SIC:</td>
            <td>
                <select name="idsecretaria" id="idsecretaria">
                    <option value="">-- Selecione o SIC --</option>
                    <?php
            $sql = "select * from sis_secretaria order by sigla";
            
            $resultado = execQuery($sql);
            $num = mysqli_num_rows($resultado);
        
            while($registro = mysqli_fetch_array($resultado)){
                        ?>
                        <option value="<?php echo $registro[" idsecretaria "]; ?>" <?php echo ($idsecretaria==$registro[ "idsecretaria"])? "selected": ""; ?>>
                            <?php echo $registro["sigla"]; ?>
                        </option>
                        <?php
                        }
        ?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table border="0" width="100%">
                    <tr>
                        <td valign="top" align="center">
                            Perfis
                            <br>
                            <select name="gruposdisponiveis" id="gruposdisponiveis" title="Dê um duplo clique para selecionar todos" ondblclick="selecionatudo(this.id);" multiple="multiple" style="height: 300px; width: 300px; font-size:10">
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
                        </td>
                        <td valign="middle" align="center">
                            <center>
                                <input type="button" value=">>" title="Selecionar" onclick="adicionaItem(document.getElementById('gruposdisponiveis'),document.getElementById('gruposselecionados'));">
                                <br>
                                <br>
                                <input type="button" value="<<" title="Retirar" onclick="adicionaItem(document.getElementById('gruposselecionados'),document.getElementById('gruposdisponiveis'));">
                            </center>
                        </td>
                        <td valign="top" align="center">
                            Perfis do Usu&aacute;rio
                            <br>
                            <select name="gruposselecionados[]" id="gruposselecionados" title="Dê um duplo clique para selecionar todos" ondblclick="selecionatudo(this.id);" multiple="multiple" style="height: 300px; width: 300px; font-size:10">
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
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table border="0" width="100%">
                    <tr>
                        <td valign="top" align="center">
                            SIC's
                            <br>
                            <select name="sics" id="sics" multiple="multiple" title="Dê um duplo clique para selecionar todos" ondblclick="selecionatudo(this.id);" style="height: 300px; width: 300px; font-size:10">
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
                        </td>
                        <td valign="middle" align="center">
                            <center>
                                <input type="button" value=">>" title="Selecionar" onclick="adicionaItem(document.getElementById('sics'),document.getElementById('sicselecionados'));">
                                <br>
                                <br>
                                <input type="button" value="<<" title="Retirar" onclick="adicionaItem(document.getElementById('sicselecionados'),document.getElementById('sics'));">
                            </center>
                        </td>
                        <td valign="top" align="center">
                            SIC's Alternativos do Usu&aacute;rio
                            <br>
                            <select name="sicselecionados[]" id="sicselecionados" title="Dê um duplo clique para selecionar todos" ondblclick="selecionatudo(this.id);" multiple="multiple" style="height: 300px; width: 300px; font-size:10">
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
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <br>
                <input type="submit" class="botaoformulario" value="<?php echo $acao;?>" name="<?php echo $acao;?>" onclick="selecionatudo('gruposselecionados');selecionatudo('sicselecionados');" />
                <input type="button" onClick="document.location = 'index.php';" class="botaoformulario" value="Voltar">
            </td>
        </tr>
    </table>
</form>
