<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

include "manutencao.php";
?>

<div class="container-fluid">
    <header class="header-title">
        <h1>Configuração do Lei de Acesso</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo URL_BASE_SISTEMA; ?>/">Dashboard</a></li>
            <li><a href="<?php echo URL_BASE_SISTEMA; ?>/?lda_configuracao">Administração</a></li>
            <li class="active">Configuração</li>
        </ol>
    </header>
</div>
<section id="config">
  <div class="container-fluid">
    <form action="index.php?lda_configuracao" method="post">
      <div class="row">
        <div class="col-xs-12">
          <div class="name">Prazo, em dias, para resposta da solicitação:</div>
        </div>
        <div class="col-xs-12">
          <div class="form-group small">
            <label for="prazoresposta" class="input-label"><i class="material-icons">alarm</i></label>
            <input type="text" name="prazoresposta" class="form-control icon" value="<?php echo $prazoresposta;?>" maxlength="4" size="5" id="prazoresposta" />
            <span class="dias">Dias</span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="name">Quantidade de dias que podera ser prorrogada a resposta da solicitação:</div>
        </div>

        <div class="col-xs-12">
          <div class="form-group small">
            <label for="prazoresposta" class="input-label"><i class="material-icons">alarm</i></label>
            <input type="text" name="qtdprorrogacaoresposta" class="form-control icon" value="<?php echo $qtdprorrogacaoresposta;?>" maxlength="4" size="5" id="qtdprorrogacaoresposta" />
            <span class="dias">Dias</span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="name">Prazo, em dias, para solicitação de recurso após a resposta negada:</div>
        </div>

        <div class="col-xs-12">
          <div class="form-group small">
            <label for="prazoresposta" class="input-label"><i class="material-icons">alarm</i></label>
            <input type="text" name="prazosolicitacaorecurso" class="form-control icon" value="<?php echo $prazosolicitacaorecurso;?>" maxlength="4" size="5" id="prazosolicitacaorecurso" />
            <span class="dias">Dias</span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="name">Prazo, em dias, para resposta ao recurso:</div>
        </div>

        <div class="col-xs-12">
          <div class="form-group small">
            <label for="prazoresposta" class="input-label"><i class="material-icons">alarm</i></label>
            <input type="text" name="prazorespostarecurso" class="form-control icon" value="<?php echo $prazorespostarecurso;?>" maxlength="4" size="5" id="prazorespostarecurso" />
            <span class="dias">Dias</span>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <div class="name">Quantidade de dias que poderá ser prorrogada resposta ao recurso:</div>
        </div>

        <div class="col-xs-12">
          <div class="form-group small">
            <label for="prazoresposta" class="input-label"><i class="material-icons">alarm</i></label>
            <input type="text" name="qtdeprorrogacaorecurso" class="form-control icon" value="<?php echo $qtdeprorrogacaorecurso;?>" maxlength="4" size="5" id="qtdeprorrogacaorecurso" />
            <span class="dias">Dias</span>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <div class="name">URL de acesso aos anexos do sistema:</div>
        </div>

        <div class="col-xs-12 col-sm-4">
          <div class="form-group">
            <label for="prazoresposta" class="input-label"><i class="material-icons">label</i></label>
            <input type="text" name="urlarquivos" class="form-control icon" value="<?php echo $urlarquivos;?>" maxlength="300" size="50" id="urlarquivos" /> 
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="name">Diretório onde será armazenado os anexos do sistema:</div>
        </div>

        <div class="col-xs-12 col-sm-4">
          <div class="form-group">
            <label for="prazoresposta" class="input-label"><i class="material-icons">label</i></label>
            <input type="text" name="diretorioarquivos" class="form-control icon" value="<?php echo $diretorioarquivos;?>" maxlength="300" size="50" id="diretorioarquivos" />
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="name">Nome do remetente dos e-mails que serão enviados pelo sistema:</div>
        </div>

        <div class="col-xs-12 col-sm-4">
          <div class="form-group">
            <label for="prazoresposta" class="input-label"><i class="material-icons">business</i></label>
            <input type="text" name="nomeremetenteemail" class="form-control icon" value="<?php echo $nomeremetenteemail;?>" maxlength="100" size="50" id="nomeremetenteemail" /> 
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="name">E-mail do remetente para envio de e-mails pelo sistema:</div>
        </div>

        <div class="col-xs-12 col-sm-4">
          <div class="form-group">
            <label for="prazoresposta" class="input-label"><i class="material-icons">account_circle</i></label>
            <input type="text" name="emailremetente" class="form-control icon" value="<?php echo $emailremetente;?>" maxlength="100" size="50" id="emailremetente" /> 
          </div>
        </div>
      </div>
      <ul class="fixed">
        <li>
          <button type="submit" name="acao" value="Salvar" class="waves-effect btn btn-success">Salvar</button>
        </li>
        <li>
          <button type="reset" class="waves-effect btn btn-danger">Apagar alteração</button>
        </li>
      </ul>
    </form>
  </div>
</section>