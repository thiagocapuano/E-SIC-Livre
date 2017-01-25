<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
 Charset UTF-8
***********************************************************************************/

	include_once("../inc/autenticar.php");
	include_once("../class/solicitacao.class.php");
        
	$codigo = $_GET["codigo"];
        $acao   = $_POST["acao"];            
	
        
        //persistencia dos campos de filtro do index
        $fltnumprotocolo   = $_REQUEST["fltnumprotocolo"];
        $fltsituacao       = $_REQUEST["fltsituacao"];
        
        $parametrosIndex = "fltnumprotocolo=$fltnumprotocolo&fltsituacao=$fltsituacao"; //parametros a ser passado para a pagina de detalhamento, fazendo com que ao voltar para o index traga as informações passadas anteriormente
        //-----
        
	//se for passado código para edição e nao tiver sido postado informação do formulario busca dados do banco
	if(!$_POST['acao'] and !empty($codigo))
	{
		$acao = "Alterar";
                
                //recupera campos da demanda
                $sol = new Solicitacao($codigo);

                
		$idsolicitacao              = $sol->getIdSolicitacao();
                $idsolicitante              = $sol->getIdSolicitante();
                $idsolicitacaoorigem        = $sol->getIdSolicitacaoOrigem();
                $numeroprotocolo            = $sol->getNumeroProtocolo();
                $textosolicitacao           = $sol->getTextoSolicitacao();
                $idtiposolicitacao          = $sol->getIdTipoSolicitacao();
                $instancia                  = Solicitacao::getInstaciaTipoSolicitacao($idtiposolicitacao);
                $formaretorno               = $sol->getFormaRetorno();
                $situacao                   = $sol->getSituacao();
                $datasolicitacao            = $sol->getDataSolicitacao();
                $datarecebimentosolicitacao = $sol->getDataRecebimentoSolicitacao();
                $usuariorecebimento         = $sol->getUsuarioRecebimento();
                $dataprevisaoresposta       = $sol->getDataPrevisaoResposta();
                $dataprorrogacao            = $sol->getDataProrrogacao();
                $motivoprorrogacao          = $sol->getMotivoProrrogacao();
                $usuarioprorrogacao         = $sol->getUsuarioProrrogacao();
                $dataresposta               = $sol->getDataResposta();
                $resposta                   = $sol->getResposta();
                $usuarioresposta            = $sol->getUsuarioResposta();
                $idsecretariaresposta       = $sol->getIdSecretariaResposta();
	}
	else
	{
                
		//recupera valores do formulario
            
                //campos de leitura
		$idsolicitacao              = $_POST['idsolicitacao'];
                $idsolicitante              = $_POST['idsolicitante'];
                $idsolicitacaoorigem        = $_POST['idsolicitacaoorigem'];
                $numeroprotocolo            = $_POST['numeroprotocolo'];
                $textosolicitacao           = $_POST['textosolicitacao'];
                $idtiposolicitacao          = $_POST['idtiposolicitacao'];
                $instancia            = $_POST['instancia'];
                $formaretorno               = $_POST['formaretorno'];
                $situacao                   = $_POST['situacao'];
                $datasolicitacao            = $_POST['datasolicitacao'];
                $datarecebimentosolicitacao = $_POST['datarecebimentosolicitacao'];
                $usuariorecebimento         = $_POST['usuariorecebimento'];
                $dataprevisaoresposta       = $_POST['dataprevisaoresposta'];
                $dataprorrogacao            = $_POST['dataprorrogacao'];
                $motivoprorrogacao          = $_POST['motivoprorrogacao'];
                $usuarioprorrogacao         = $_POST['usuarioprorrogacao'];
                $dataresposta               = $_POST['dataresposta'];
                $resposta                   = $_POST['resposta'];
                $usuarioresposta            = $_POST['usuarioresposta'];
                $idsecretariaresposta       = $_POST['idsecretariaresposta'];
            
                //campos do recurso
                $txttextosolicitacao        = $_POST['txttextosolicitacao'];
                $txtformaretorno            = $_POST['txtformaretorno'];
	}
	
	$erro="";

        if ($_POST['acao'])
        {
            //se for envio de recurso
            if ($acao == "Enviar")
            {
                    $sol = new Solicitacao();

                    //recupera o proximo tipo de solicitação, caso retorne falso, deu erro
                    if(Solicitacao::getProximoTipoSolicitacao($idsolicitacao,$idtiposolicitacaorecurso,$erro))
                    {   
                        //se nao existir solicitação original
                        if (empty($idsolicitacaoorigem))
                            $sol->setIdSolicitacaoOrigem($idsolicitacao); //o recurso terá a solicitação atual como original
                        else
                            $sol->setIdSolicitacaoOrigem($idsolicitacaoorigem); //o recurso manterá a solicitação original
                        
                        $sol->setTextoSolicitacao($txttextosolicitacao);
                        $sol->setFormaRetorno($txtformaretorno);
                        $sol->setIdSolicitante(getSession("uid"));
                        
                        //caso nao exista SIC centralizador, o direcionamento vai para quem deu a resposta
                        if(!Solicitacao::existeSicCentralizador())
                            $sol->setIdSecretariaSelecionada($idsecretariaresposta);

                        if ($sol->cadastraRecurso($idtiposolicitacaorecurso))
                            header("Location: index.php?$parametrosIndex");
                        else
                            $erro = $sol->getErro ();
                    }
            }
        }
?>