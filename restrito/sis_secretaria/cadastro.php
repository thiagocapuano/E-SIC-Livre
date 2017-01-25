<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

include_once "manutencao.php";

 
?>

<div class="container-fluid">
    <header class="header-title">
        <h1>Cadastro de SIC</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo URL_BASE_SISTEMA; ?>index/">Início</a></li>
            <li><a href="index.php?sis_secretaria">Cadastro de SIC</a></li>
            <li class="active">Edição</li>
        </ol>
    </header>
</div>

<section>
    <div class="container-fluid">
        <form action="?sis_secretaria&p=cadastro" style="padding-bottom:30px;" method="post" id="formulario" class="sortable-list">			
			<input type="hidden" name="idsecretaria" value="<?php echo $idsecretaria;?>">
			<fieldset>
                <header>Dados Cadastrais</header>
                 <div class="row">
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label for="nome" class="input-label"><i class="material-icons">account_circle</i></label>
                            <input type="text" class="form-control icon" id="nome" name="nome" value="<?php echo $nome; ?>" maxlength="30" size="10" title="Nome do SIC" placeholder="Nome do SIC"/>
                        </div>
                    </div>                     
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label for="sigla" class="input-label"><i class="material-icons">account_circle</i></label>
                            <input type="text" class="form-control icon" id="sigla" name="sigla" value="<?php echo $sigla; ?>" maxlength="8" size="10" title="Sigla do SIC" placeholder="Sigla do SIC"/>
                        </div>
                    </div>					
                    <div class="col-sm-4 col-md-2 col-xs-12">
                        <div class="form-group active">
                            <label for="status" class="input-label"><i class="material-icons">info</i></label>
                            <select name="ativado" id="ativado" class="selectpicker icon">
                                <option value="1" <?php echo ($ativado) == "1"?"selected":""; ?>>Ativo</option>
								<option value="0" <?php echo ($ativado) == "0"?"selected":""; ?>>Inativo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label for="responsavel" class="input-label"><i class="material-icons">account_circle</i></label>
                            <input type="text" class="form-control icon" id="responsavel" name="responsavel" value="<?php echo $responsavel; ?>" maxlength="10" size="10" title="Responsável do SIC" placeholder="Responsável do SIC"/>
                        </div>
                    </div>  					
					<div class="col-sm-4 col-md-4 col-xs-12">
                        <div class="form-group">
                            <label for="emailsic" class="input-label"><i class="material-icons">mail_circle</i></label>
                            <input type="text" name="emailsic" class="form-control icon" id="emailsic" value="<?php echo $emailsic; ?>" maxlength="50" size="50" placeholder="E-mail SIC" />
                        </div>
                    </div>
					<div class="col-sm-4 col-md-4 col-xs-12">
                        <div class="form-group"><input type="checkbox" name="siccentral" value="1" <?php echo ($siccentral)?"checked":"";?>> &Eacute; um SIC centralizador (recebe as demandas rec&eacute;m cadastradas)</div>
					</div>
				</div>
            </fieldset>
            <button type="submit" class="btn btn-success waves-effect" value="<?php echo $acao;?>" name="<?php echo $acao;?>"><?php echo $acao;?></button>
            <button type="button" onClick="document.location = '?sis_secretaria';" class="btn btn-danger waves-effect" value="Voltar">Voltar</button>
        </form>
    </div>
</section>