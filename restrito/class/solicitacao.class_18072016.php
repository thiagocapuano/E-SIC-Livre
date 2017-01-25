<?php
/**********************************************************************************
 Sistema e-SIC Livre: sistema de acesso a informação baseado na lei de acesso.
 
 Copyright (C) 2014 Prefeitura Municipal do Natal
 
 Este programa é software livre; você pode redistribuí-lo e/ou
 modificá-lo sob os termos da Licença GPL2.
***********************************************************************************/

//se a classe for chamada pela area restrita do lei de acesso
if (empty($varAreaRestrita))
{
	include_once("../inc/security.php");	
}

include_once("../inc/funcoes.php");

class Solicitacao {
	
	private $idsolicitacao;
	private $textosolicitacao;
	private $formaretorno;
    private $numeroprotocolo;
	private $situacao;
    private $idtiposolicitacao;
	private $instancia;
	private $idsolicitacaoorigem;
	private $idsolicitante;
	private $solicitante;
	private $datasolicitacao;
	private $datarecebimentosolicitacao;
	private $usuariorecebimento;
	private $dataprevisaoresposta;
	private $dataprorrogacao;
	private $usuarioprorrogacao;
	private $motivoprorrogacao;
	private $dataresposta;
	private $resposta;
	private $usuarioresposta;
	private $idsecretariaselecionada;
	private $idsecretariaresposta;
	private $erro;	
        
	//campos de movimentação
	private $idsecretariadestino;
	private $despacho;
	//campos de finalização
	private $tiporesposta;
        
        
	//instancia
	public function getInstancia(){
		return $this->instancia;
	}
        
	//dataprevisaoresposta
	public function getDataPrevisaoResposta(){
		return $this->dataprevisaoresposta;
	}
	public function setDataPrevisaoResposta($valor){
		$this->dataprevisaoresposta = $valor;
	}

	//dataprorrogaca
	public function getDataProrrogacao(){
		return $this->dataprorrogacao;
	}
	public function setDataProrrogacao($valor){
		$this->dataprorrogacao = $valor;
	}

	//motivoprorrogacao
	public function getMotivoProrrogacao(){
		return $this->motivoprorrogacao;
	}
	public function setMotivoProrrogacao($valor){
		$this->motivoprorrogacao = str_replace("'","\'",$valor);
	}
        
	//idsolicitacaoorigem
	public function getUsuarioProrrogacao(){
		return $this->usuarioprorrogacao;
	}
	public function setUsuarioProrrogacao($valor){
		$this->usuarioprorrogacao = $valor;
	}
        
	//dataresposta
	public function getDataResposta(){
		return $this->dataresposta;
	}
	public function setDataResposta($valor){
		$this->dataresposta = $valor;
	}
        
	//resposta
	public function getResposta(){
		return $this->resposta;
	}
	public function setResposta($valor){
		$this->resposta = $valor;
	}
        
	//usuarioresposta
	public function getUsuarioResposta(){
		return $this->usuarioresposta;
	}
	public function setUsuarioResposta($valor){
		$this->usuarioresposta = $valor;
	}
        
	//idsecretariaresposta
	public function getIdSecretariaResposta(){
		return $this->idsecretariaresposta;
	}
	public function setIdSecretariaResposta($valor){
		$this->idsecretariaresposta = $valor;
	}
	

	//usuariorecebimento
	public function getUsuarioRecebimento(){
		return $this->usuariorecebimento;
	}
	public function setUsuarioRecebimento($valor){
		$this->usuariorecebimento = $valor;
	}
        
	//idsolicitacao
	public function getIdSolicitacao(){
		return $this->idsolicitacao;
	}
	public function setIdSolicitacao($valor){
		$this->idsolicitacao = $valor;
	}

        //datasolicitacao
	public function getDataSolicitacao(){
		return $this->datasolicitacao;
	}
	public function setDataSolicitacao($valor){
		$this->datasolicitacao = $valor;
	}
        
	//datarecebimentosolicitacao
	public function getDataRecebimentoSolicitacao(){
		return $this->datarecebimentosolicitacao;
	}
	public function setDataRecebimentoSolicitacao($valor){
		$this->datarecebimentosolicitacao = $valor;
	}
        
	//idsolicitacaoorigem
	public function getIdSolicitacaoOrigem(){
		return $this->idsolicitacaoorigem;
	}
	public function setIdSolicitacaoOrigem($valor){
		$this->idsolicitacaoorigem = $valor;
	}

	//idtiposolicitacao
	public function getIdTipoSolicitacao(){
		return $this->idtiposolicitacao;
	}
	public function setIdTipoSolicitacao($valor){
		$this->idtiposolicitacao = $valor;
	}
	//descrição tipo solicitação
	public static function getDescricaoTipoSolicitacao($idtiposolicitacao){
            
                $rs = execQuery("select nome from lda_tiposolicitacao where idtiposolicitacao = $idtiposolicitacao");
		
		if(mysqli_num_rows($rs)>0)
		{
                        $row = mysqli_fetch_array($rs);
                        return $row["nome"];
                }	
                else
                    return "Tipo de solicitação não encontrado";
                
	}
        
	//textosolicitacao
	public function getTextoSolicitacao(){
		return $this->textosolicitacao;
	}
	public function setTextoSolicitacao($valor){
		$this->textosolicitacao = str_replace("'","\'",$valor);
	}

       	//numprotocolo
	public function getNumeroProtocolo(){
		return $this->numeroprotocolo;
	}
	public function setNumeroProtocolo($numero,$ano){
		$this->numeroprotocolo = $numero."/".$ano;
	}

        //secretaria selecionada (pelo usuario na hora de fazer a solicitação)
	public function getIdSecretariaSelecionada(){
		return $this->idsecretariaselecionada;
	}
	public function setIdSecretariaSelecionada($valor){
		$this->idsecretariaselecionada = $valor;
	}

        //formaretorno
	public function getFormaRetorno(){
		return $this->formaretorno;
	}
	public function setFormaRetorno($valor){
		$this->formaretorno = $valor;
	}

	//descrição tipo retorno
	public static function getDescricaoFormaRetorno($formaretorno){
		switch($formaretorno)       
			{
				case "E": return "E-mail"; break;
				case "F": return "Fax"; break; 
				case "C": return "Correio"; break; 
				default: return "Forma de retorno inexistente";
			}
	}

	//descrição tipo de instancia
	public static function getDescricaoTipoInstancia($instancia){
		switch($instancia)       
                {
                    case "I": return "Inicial"; break;
                    case "S": return "Seguimento"; break; 
                    case "U": return "Última"; break; 
                    default: return "Instancia inexistente";
                }
	}
        
	//situacao
	public function getSituacao(){
		return $this->situacao;
	}
	public function setSituacao($valor){
		$this->situacao = $valor;
	}	
	//descrição situacao
	public static function getDescricaoSituacao($situacao){
		switch($situacao)       
                {
                    case "A": return "Aberto"; break;
                    case "T": return "Em tramitacao"; break; 
                    case "N": return "Negado"; break; 
                    case "R": return "Solicitação Respondida"; break;
                    default: return "Situação inexistente";
                }
	}
	
	
	//idsolicitante
	public function getIdSolicitante(){
		return $this->idsolicitante;
	}
	public function setIdSolicitante($valor){
		$this->idsolicitante = $valor;
	}
	
	//erro
	public function getErro(){
		return $this->erro;
	}
	

	public function getSolicitante(){
		return $this->solicitante;
	}
	
	
	//--------CONSTRUTOR---------------------------
	
	function Solicitacao($idsolicitacao=null)
	{
		if(!empty($idsolicitacao))
		{
			$this->getDados($idsolicitacao);
		}
	}
	
	//---------------------------------------------
	
	function getDados($idsolicitacao)
	{
		$sql = "select t.*, c.nome as solicitante, 
                        urec.nome as usuariorecebimento, upro.nome as usuarioprorrogacao, 
                        ures.nome as usuarioresposta, ts.instancia
                        from lda_solicitacao t
                        join lda_solicitante c on c.idsolicitante = t.idsolicitante
                        join lda_tiposolicitacao ts on ts.idtiposolicitacao = t.idtiposolicitacao
                        left join sis_usuario urec on urec.idusuario = t.idusuariorecebimento
                        left join sis_usuario upro on upro.idusuario = t.idusuarioprorrogacao
                        left join sis_usuario ures on ures.idusuario = t.idusuarioresposta
                        where idsolicitacao = $idsolicitacao";
		
		$rs = execQuery($sql);
		
		if(mysqli_num_rows($rs)>0)
		{
			$row = mysqli_fetch_array($rs);

			$this->idsolicitacao		= $row["idsolicitacao"];
			$this->idsolicitacaoorigem	= $row["idsolicitacaoorigem"];
			$this->textosolicitacao 	= $row["textosolicitacao"];
			$this->situacao				= $row["situacao"];
			$this->formaretorno			= $row["formaretorno"];		
			$this->idsolicitante		= $row["idsolicitante"];
			$this->solicitante			= $row["solicitante"];
			$this->idtiposolicitacao	= $row["idtiposolicitacao"];
			$this->instancia			= $row["instancia"];
			$this->setNumeroProtocolo($row["numprotocolo"],$row["anoprotocolo"]);
			$this->datasolicitacao				= bdToDate($row["datasolicitacao"]);
			$this->datarecebimentosolicitacao	= bdToDate($row["datarecebimentosolicitacao"]);
			$this->usuariorecebimento         	= $row["usuariorecebimento"];
			$this->dataprevisaoresposta       	= bdToDate($row["dataprevisaoresposta"]);
			$this->dataprorrogacao            	= bdToDate($row["dataprorrogacao"]);
			$this->motivoprorrogacao          	= $row["motivoprorrogacao"];
			$this->usuarioprorrogacao         	= $row["usuarioprorrogacao"];
			$this->dataresposta					= bdToDate($row["dataresposta"]);
			$this->resposta						= $row["resposta"];
			$this->usuarioresposta				= $row["usuarioresposta"];
			$this->idsecretariaselecionada		= $row["idsecretariaselecionada"];
			$this->idsecretariaresposta			= $row["idsecretariaresposta"];						
		}
		else
			die("Solicitação nao informada");
	}

	public static function getParametrosConfiguracao()
        {
                //recupera parametros de configuracao
                $sql = "select * from lda_configuracao";
                $rs = execQuery($sql);

                return mysqli_fetch_array($rs);

        }


        //recupera a instancia do tipo de solicitação passado: [I]inicial - [S]eguimento - [U]ltima
       	public static function getInstaciaTipoSolicitacao($idtiposolicitacao)
        {
                //recupera a instancia do tipo de solicitação
                $sql = "select instancia from lda_tiposolicitacao where idtiposolicitacao = $idtiposolicitacao";
                $rs = execQuery($sql);

                $row = mysqli_fetch_array($rs);
                
                return $row['instancia'];

        }
        
        
        //recupera o proximo tipo de solicitação para uma solicitação informada
       	public function getProximoTipoSolicitacao($idsolicitacao="",&$idtiposolicitacao, &$erro="")
        {
            $erro="";
            
            //se for passado uma solicitação
            if(!empty($idsolicitacao))
            {
                //recupera o proximo tipo de solicitacao
                $sql = "select idtiposolicitacao_seguinte from lda_tiposolicitacao
                        where idtiposolicitacao = (select idtiposolicitacao 
                                                    from lda_solicitacao 
                                                    where idsolicitacao = $idsolicitacao)";
                $rs = execQuery($sql);

                if (mysqli_num_rows($rs)>0)
                {
                    $row = mysqli_fetch_array($rs);
                    $idtiposolicitacao = $row['idtiposolicitacao_seguinte'];

                    //se não for encontrado novo tipo de solicitação
                    if(empty($idtiposolicitacao))
                    {
                        $erro = "Não é possível inserir novo recurso para essa solicitação, pois essa solicitação já está na última instância.";
                        return false;
                    }
                }
                else
                {
                    $erro = "Não foi encontrado tipo de solicitação para essa solicitação";
                    return false;
                }
                
            }
            else
            {
                //recupera a solicitação inicial
                $sql = "select idtiposolicitacao from lda_tiposolicitacao where instancia = 'I'";
                $rs = execQuery($sql);

                if (mysqli_num_rows($rs)>0)
                {
                    $row = mysqli_fetch_array($rs);
                    $idtiposolicitacao = $row['idtiposolicitacao'];
                }                
                else
                {
                    $erro = "Não foi encontrado instância inicial cadastrada no sistema.";
                    return false;
                }
            }

            return true;
        }

        
	function validaDados($instancia="I")
	{
					
		if($instancia != "I")
		{
			if (empty($this->idsolicitacaoorigem))
			{
				$this->erro = "Processo não informado.";
				return false;
			}
                    
		}
                    
		if (empty($this->textosolicitacao))
		{
			$this->erro = "Especificação da solicitação não informada.";
			return false;
		}
		elseif (empty($this->formaretorno))
		{
			$this->erro = "Forma de retorno não informado";
			return false;
		}
		elseif (empty($this->idsolicitante))
		{
			$this->erro = "Solicitante não informado";
			return false;
		}
		
                if ($this->formaretorno == "C" or $this->formaretorno == "F")
                {
                    $rs = execQuery("select logradouro, uf, cidade, telefone, dddtelefone from lda_solicitante where idsolicitante = $this->idsolicitante");
                    $row = mysqli_fetch_array($rs);
                    
                    //se a forma de retorno for correio, verifica se existe endereço cadastrado
                    if($this->formaretorno == "C" and (empty($row['logradouro']) or empty($row['uf']) or empty($row['cidade'])))
                    {
                            $this->erro = "Para forma de retorno via correio é necessário atualizar o endereço no seu cadastro.";
                            return false;
                    }
                    //se a forma de retorno for telefone
                    elseif($this->formaretorno == "F" and (empty($row['telefone']) or empty($row['dddtelefone'])))
                    {
                            $this->erro = "Para forma de retorno via correio é necessário atualizar o telefone no seu cadastro.";
                            return false;
                    }
                }
                
		//verifica se ja existe registro cadastrado com a informaçao passada ---
		if (!empty($this->idsolicitacao))
			$sql = "select * from lda_solicitacao 
					where textosolicitacao = '$this->textosolicitacao' 
						  and formaretorno = '$this->formaretorno' 
						  and idsolicitante = $this->idsolicitante 
						  and idsolicitacao <> $this->idsolicitacao";
		else
			$sql = "select * from lda_solicitacao
					where textosolicitacao = '$this->textosolicitacao' 
						  and formaretorno = '$this->formaretorno' 
						  and idsolicitante = $this->idsolicitante ";

				
		if(mysqli_num_rows(execQuery($sql)) > 0)
		{
			$this->erro = "Essa solicitação já está cadastrada.";
			return false;
		}
		//-----------------------------------------------------------------------
		
		return true;
	}

        
        //envia email de aviso de nova solicitação para o SIC 
        //secretaria -> recebe o idsecretaria ou sigla
        //tipomsg    -> identifica o tipo de mensagem: [M]ovimentação - [N]ova solicitação - [R]ecurso
        public static function enviaEmailSic($secretaria, $tipomsg="M")
        {
                //recupera o email do SIC
                $sql = "select emailsic
                        from sis_secretaria
                        where sigla = '$secretaria' or idsecretaria = '$secretaria'";

                $rs = execQuery($sql);

                if(mysqli_num_rows($rs)>0)
                {
                        $row = mysqli_fetch_array($rs);
                        $emailsic = $row["emailsic"];
                }

                //se houver email cadastrado, faz o envio
                if(!empty($emailsic))
                {
                    //se for movimentação
                    if($tipomsg == "M")
                    {
                        $titulo = "Movimentação de solicitação de informação";
                        $body="Prezado(a) colaborador(a),<br> <br>
                                Foi movimentada uma solicitação de informação para o seu órgão. Favor verificar a demanda no sistema ".SISTEMA_NOME." no endereço: ".URL_BASE_SISTEMA."<br><br>
                                Mensagem Automática do Sistema ".SISTEMA_NOME;
                    }
                    //se for nova solicitação
                    else if($tipomsg == "N")
                    {
                        $titulo = "Nova de solicitação de informação";
                        $body="Prezado(a) colaborador(a),<br> <br>
                                Foi aberta uma solicitação de informação. Favor verificar a demanda no sistema ".SISTEMA_NOME." no endereço: ".URL_BASE_SISTEMA."<br><br>
                                Mensagem Automática do Sistema ".SISTEMA_NOME;
                    }
                    //se for novo recurso
                    else if($tipomsg == "R")
                    {
                        $titulo = "Novo recurso de solicitação de informação";
                        $body="Prezado(a) colaborador(a),<br> <br>
                                Foi aberta uma solicitação de informação. Favor verificar a demanda no sistema ".SISTEMA_NOME." no endereço: ".URL_BASE_SISTEMA."<br><br>
                                Mensagem Automática do Sistema ".SISTEMA_NOME;
                    }
                    else
                    {
                        $titulo = "Solicitação de informação";
                        $body="Prezado(a) colaborador(a),<br> <br>
                                Foi aberta uma solicitação de informação. Favor verificar a demanda no sistema ".SISTEMA_NOME." no endereço: ".URL_BASE_SISTEMA."<br><br>
                                Mensagem Automática do Sistema ".SISTEMA_NOME;
                    }
                    
					if (!empty($emailsic) and !empty($body)) {
						if(!sendMail($emailsic,$titulo,$body))						
						{	
							//caso de erro loga o erro
							logger("Lei de acesso - Não foi possível enviar e-mail para o SIC: $emailsic");
						}
					}
                }
            
        }
        
        //envia email de aviso para o solicitante
        //secretaria -> recebe o idsecretaria ou sigla
        //tipomsg    -> identifica o tipo de mensagem: [N]ova solicitação - [P]rorrogada - [R]esposta da solicitação
        public static function enviaEmailSolicitante($idsolicitacao, $tipomsg="N")
        {
                //recupera o email do solicitante
                $sql = "select pes.email, pes.nome, sol.dataprevisaoresposta, sol.numprotocolo, sol.anoprotocolo
                        from lda_solicitacao sol, lda_solicitante pes
                        where sol.idsolicitante = pes.idsolicitante
                              and sol.idsolicitacao = $idsolicitacao";

                $rs = execQuery($sql);

                if(mysqli_num_rows($rs)>0)
                {
					$row = mysqli_fetch_array($rs);
					$email = $row["email"];
					$nome =  $row["nome"];
					$processo = $row["numprotocolo"]."/".$row["anoprotocolo"];
					$dataprevisaoresposta = bdToDate($row['dataprevisaoresposta']);
                        
                }

                //se houver email cadastrado, faz o envio
                if(!empty($email))
                {
                    //se for movimentação
                    if($tipomsg == "N")
                    {
                        $titulo = "Solicitação cadastrada";
                        $body="Prezado(a) $nome,<br> <br>
                                Sua solicitação <b>$processo</b> foi cadastrada com sucesso.<br><br>
                                Data prevista para resposta: $dataprevisaoresposta
                                <br><br>Para acompanhar o andamento, acesse o sistema ".SISTEMA_NOME." no endereço: ".URL_SITE_SISTEMA.".<br><br>
                                Mensagem Automática do Sistema ".SISTEMA_NOME;
                    }
                    //se for resposta
                    else if($tipomsg == "R")
                    {
                        $titulo = "Sua solicitação foi respondida";
                        $body="Prezado(a) $nome,<br> <br>
                                Sua solicitação <b>$processo</b> foi respondida. Para mais informações acesse o sistema ".SISTEMA_NOME." no endereço: ".URL_SITE_SISTEMA.".<br><br>
                                Mensagem Automática do Sistema ".SISTEMA_NOME;
                    }
                    //se for prorrogada
                    else if($tipomsg == "P")
                    {
                        $titulo = "A resposta a sua solicitação foi prorrogada";
                        $body="Prezado(a) $nome,<br> <br>
                                O atendimento a sua solicitação <b>$processo</b> foi prorrogado, data de previsão de resposta: $dataprevisaoresposta. Para mais informações acesse o sistema ".SISTEMA_NOME." no endereço: ".URL_SISTEMA_NOME.".<br><br>
                                Mensagem Automática do Sistema ".SISTEMA_NOME;
                    }
                    
                    if (!sendmail($email,$titulo,$body))
                    {   
                            //caso de erro loga o erro
                            logger("Lei de acesso - Não foi possível enviar e-mail para o solicitante: $email");
                    }
                }
            
        }

        
	public function cadastra()
	{

		if($this->validaDados())
		{
			$configuracao = $this->getParametrosConfiguracao();
			$prazoresposta = $configuracao['prazoresposta'];
                        
            //recupera o proximo tipo de solicitação, caso retorne falso, deu erro
            if(!$this->getProximoTipoSolicitacao("",$idtiposolicitacao,$this->erro))
            {
            	$this->erro = "Erro ao inserir solicitação #1.";
				return false;
            }

			$sql="INSERT INTO lda_solicitacao (
						textosolicitacao,
						formaretorno,
						idsolicitante,
                        datasolicitacao,
                        dataprevisaoresposta,
                        idtiposolicitacao,
                        idsecretariaselecionada,
						origem
				) VALUES (
						'$this->textosolicitacao',
						'$this->formaretorno',
						'$this->idsolicitante',
                        NOW(),
                        date_add(NOW(), interval $prazoresposta DAY ),
                        $idtiposolicitacao,
                        ".(!empty($this->idsecretariaselecionada)?$this->idsecretariaselecionada:"null").",
						'1'
				)";
				
			$con = db_open();
			
			if (!mysqli_query($con,$sql)) 
			{
				echo mysqli_error();
				$this->erro = "Erro ao inserir solicitação #2.";//.$sql;
				return false;
			}
			else
			{
				$this->idsolicitacao = mysqli_insert_id();

                //recupera o numero do protocolo
                $sql = "select numprotocolo, anoprotocolo
                        from lda_solicitacao t
                        where idsolicitacao = $this->idsolicitacao";

                $rs = execQuery($sql);

                if(mysqli_num_rows($rs)>0)
                {
                    $row = mysqli_fetch_array($rs);
                    $this->setNumeroProtocolo($row["numprotocolo"],$row["anoprotocolo"]);
                }
                else
                {
					$this->erro = "Erro ao inserir solicitação #3."; //.$sql;
					return false;
                }

                //se tiver sido selecionado um SIC
                if(!empty($this->idsecretariaselecionada))
                {
                    //envia email de aviso de nova solicitação ao SIC centralizador
                    Solicitacao::enviaEmailSic($rec['idsecretaria'],"N");
                }
                else
                {
                    //envia email para os SIC's centralizadores
                    $sql = "select idsecretaria
                            from sis_secretaria
                            where siccentral = 1";

                    $rs = execQuery($sql);

                    if(mysqli_num_rows($rs)>0)
                    {    
                        while($rec = mysqli_fetch_array($rs))
                        {
                            //envia email de aviso de nova solicitação ao SIC centralizador
                            Solicitacao::enviaEmailSic($rec['idsecretaria'],"N");

                        }
                    }
                }
                                
                //envia email de aviso de cadastro de solicitação ao solicitante
                Solicitacao::enviaEmailSolicitante($this->idsolicitacao,"N");                                
			}
			
			return true;
		}
		else
				echo $this->erro;
			return false;
	}

        
        
	public function cadastraRecurso($idtiposolicitacao)
	{
		if($this->validaDados($tiposolicitacao))
		{
                        $configuracao = Solicitacao::getParametrosConfiguracao();
                        $prazoresposta = $configuracao['prazorespostarecurso'];
                        
			$sql="INSERT INTO lda_solicitacao (
						textosolicitacao,
						formaretorno,
						idsolicitante,
                                                datasolicitacao,
                                                dataprevisaoresposta,
                                                idtiposolicitacao,
                                                idsolicitacaoorigem,
                                                idsecretariaselecionada
				) VALUES (
						'$this->textosolicitacao',
						'$this->formaretorno',
						'$this->idsolicitante',
                                                NOW(),
                                                date_add(NOW(), interval $prazoresposta DAY ),
                                                '$idtiposolicitacao',
                                                $this->idsolicitacaoorigem,
                                                ".(!empty($this->idsecretariaselecionada)?$this->idsecretariaselecionada:"null")."
				)";
				
			$con = db_open();
			
			if (!mysqli_query($con,$sql)) 
			{
                            
				$this->erro = "Erro ao inserir solicitação".$sql;
				$sucesso = false;
			}
			else
			{
                            
				$this->erro = "";
				$sucesso = true;
                                
                                //se tiver sido selecionado um SIC
                                if(!empty($this->idsecretariaselecionada))
                                {
                                    //envia email de aviso de nova solicitação ao SIC centralizador
                                    Solicitacao::enviaEmailSic($rec['idsecretaria'],"N");
                                }
                                else
                                {
                                    //envia email para os SIC's centralizadores
                                    $sql = "select idsecretaria
                                            from sis_secretaria
                                            where siccentral = 1";

                                    $rs = execQuery($sql);

                                    if(mysqli_num_rows($rs)>0)
                                    {    
                                        while($rec = mysqli_fetch_array($rs))
                                        {
                                            //envia email de aviso de nova solicitação ao SIC centralizador
                                            Solicitacao::enviaEmailSic($rec['idsecretaria'],"N");

                                        }
                                    }
                                }
                                
                                //envia email de aviso de cadastro de solicitação ao solicitante
                                Solicitacao::enviaEmailSolicitante($this->idsolicitacaoorigem,"N");
                                
                                
			}
			//db_close($con);
			
			return $sucesso;
		}
		else
			return false;
	}
	
        static public function movimenta($idsolicitacao, $secretariadestino, $despacho, $arquivo)
        {
			
			if(empty($secretariadestino))
			{
				return "O campo secretaria de destino deve ser preenchido";
			}
			if(empty($despacho))
			{
				return "O campo despacho deve ser preenchido";
			}
			
			//verifica se existe alguma movimentacao
			$sql = "select count(*) as tot from lda_movimentacao where idsolicitacao = $idsolicitacao";                
			$row = mysqli_fetch_array(execQuery($sql));
			
			//se existir movimentação
			if($row["tot"] > 0)
			{
				//Não permite movimentar se a última movimentação não tiver sido dado o recebimento.
				//Também não permite movimentar se o SIC de destino for diferente do SIC do usuário logado.
				$sql = "select 
							count(*) as tot, idsecretariadestino 
						from 
							lda_movimentacao 
						where 
							idmovimentacao = (select max(idmovimentacao) from lda_movimentacao where idsolicitacao = $idsolicitacao)
							and datarecebimento is null";
				
				$row = mysqli_fetch_array(execQuery($sql));
				
				//se ultima movimentação nao tiver sido recebida
				if($row["tot"] > 0)
					if ($row["idsecretariadestino"] <> getSession("idsecretaria"))
						return "A demanda não pode ser movimentada. A demanda não encontra-se mais no seu setor.";
					else
						return "A demanda não pode ser movimentada. A demanda não ainda não foi recebida.";
			}

			//recupera o status da demanda
			$sql="select situacao from lda_solicitacao where idsolicitacao = $idsolicitacao";
			$row = mysqli_fetch_array(execQuery($sql));
			
			$status = $row["situacao"];
			
			$con = db_open_trans();
			$all_query_ok=true;

			$sql = "INSERT INTO lda_movimentacao 
					(
					 idsolicitacao,
					 idsecretariaorigem,
					 idsecretariadestino,
					 dataenvio,
					 idusuarioenvio,
					 despacho
					) VALUES (
					 $idsolicitacao,
					 ".getSession("idsecretaria").",
					 $secretariadestino,
					 NOW(),
					 ".getSession("uid").",
					 '".str_replace("'","\'",$despacho)."'
					)
				";

			if (!$con->query($sql)) 
			{
				$con->rollback();
				//echo $sql;
				return "Erro na movimentação da solicitação #1.";
			}
			else
			{
				//se houver arquivo faz upload
				if(!empty($arquivo["tmp_name"]))
				{
					$idmovimentacao = $con->insert_id;
					$dir = getDiretorio("lda")."/";
					$ext = getExtensaoArquivo($arquivo['name']);

					$fullArquivo = "lda_".$idsolicitacao."_mov_".$idmovimentacao.".".$ext;

					if (!@move_uploaded_file($arquivo["tmp_name"], $dir.$fullArquivo))
					{
						$erro = "Ocorreu um erro ao efetuar o upload do arquivo ".$dir.$fullArquivo."; nome:".$arquivo["tmp_name"];
						$all_query_ok=false;
						return $erro;
					}
					else
					{
						$sql = "update lda_movimentacao set arquivo = '$fullArquivo' where idmovimentacao = $idmovimentacao";
						if (!$con->query($sql))
						{
							$erro = "Ocorreu um erro ao efetuar atualizar nome do arquivo";
							$all_query_ok=false;
							return $erro;
						}
					}
				}
				
				//se o status da demanda for "aberto" altera para "em tramitação"
				if($status == "A")
				{
					$sql = "update lda_solicitacao set situacao = 'T' where idsolicitacao=$idsolicitacao";
					if (!$con->query($sql)) 
					{
						$con->rollback();
						return "Ocorreu um erro ao atualizar a situação da solicitação #1";
					}
				}
				$con->commit();
				
				//envia email de aviso de nova solicitação ao SIC de destino
				Solicitacao::enviaEmailSic($secretariadestino,"M");
				
			}
			return "";
        }

        static public function recebe($idsolicitacao)
        {
			$sql = "select situacao from lda_solicitacao where idsolicitacao = $idsolicitacao";
			$row = mysqli_fetch_array(execQuery($sql));
			$situacao = $row['situacao'];
			
			//se a situação for aberta (não houve tramitação), da o recebimento inicial da solicitação
			if ($situacao == "A")
			{
				$sql = "UPDATE 
							lda_solicitacao 
						SET
							datarecebimentosolicitacao = NOW(),
							idusuariorecebimento = ".getSession("uid")."
						WHERE 
							idsolicitacao = $idsolicitacao";

				if (!execQuery($sql)) 
					//die($sql);
					return "Erro no recebimento da solicitação";

			}
			else
			{
			
				//verifica se já houve recebimento
				$sql = "select count(*) as tot, idsecretariadestino from lda_movimentacao 
						where idmovimentacao = (select max(idmovimentacao) from lda_movimentacao where idsolicitacao = $idsolicitacao)
						and datarecebimento is null";

				$row = mysqli_fetch_array(execQuery($sql));

				//se a ultima movimentação nao tiver sido recebida, executa o recebimento
				if($row["tot"] > 0)
				{    
					//verifica se o usuario é do SIC de destino
					$sql = "select count(*) as tot from lda_movimentacao 
							where idmovimentacao = (select max(idmovimentacao) from lda_movimentacao where idsolicitacao = $idsolicitacao)
							and idsecretariadestino = ".getSession("idsecretaria");

					$row = mysqli_fetch_array(execQuery($sql));

					//se o ususario pertencer ao SIC de destino, da o recebimento
					if($row["idsecretariadestino"] == getSession("idSecretaria"))
					{    
						$sql = "UPDATE 
									lda_movimentacao 
								SET
									datarecebimento = NOW(),
									idusuariorecebimento = ".getSession("uid")."
								WHERE 
									idsolicitacao = $idsolicitacao
									and datarecebimento is null";

						if (!execQuery($sql)) 					   
							return "Erro no recebimento da solicitação";

					}
					else
					{
						return "Usuário não pertence a secretaria de destino";
					}
				}
			}
			
			return "";
        }

        //retorna se existe sic centralizador
        public static function existeSicCentralizador(){
            $sql = "select count(*) as tot from sis_secretaria where ativado = 1 and siccentral = 1";
            $rs = execQuery($sql);
            $row = mysqli_fetch_array($rs);
            return ($row['tot']>0);
        }
        
        //retorna consulta de movimentações da solicitação
        public static function getMovimentacao($idsolicitacao)
        {
            
            $sql = "select m.*, sOri.sigla as origem, sDes.sigla as destino, usrDes.nome as usuariorecebimento, usrOri.nome as usuarioenvio
                    from lda_movimentacao m
                    join sis_secretaria sOri on sOri.idsecretaria = m.idsecretariaorigem
                    join sis_secretaria sDes on sDes.idsecretaria = m.idsecretariadestino
                    join sis_usuario usrOri on usrOri.idusuario = m.idusuarioenvio
                    left join sis_usuario usrDes on usrDes.idusuario = m.idusuariorecebimento
                    where idsolicitacao=$idsolicitacao ";
            
            $sql .= " order by idmovimentacao"; //ordena
            
            return execQuery($sql);
        }

        //retorna consulta com os recursos da solicitação
        public static function getRecursos($idsolicitacao)
        {
            
            $sql = "select sol.*, tip.nome as tiposolicitacao
                    from lda_solicitacao sol, lda_tiposolicitacao tip
                    where sol.idtiposolicitacao = tip.idtiposolicitacao
                            and sol.idsolicitacaoorigem=$idsolicitacao 
                     order by sol.idsolicitacao";
            
            return execQuery($sql);
        }

        //retorna se ainda cabe recurso para a solicitação
        public static function getPodeRecurso($idsolicitacao, $idsolicitacaoorigem)
        {
            //recupera o id do tipo de solicitação seguinte a atual
            $sql = "select idtiposolicitacao_seguinte 
                    from lda_tiposolicitacao 
                    where idtiposolicitacao = (select idtiposolicitacao 
                                               from lda_solicitacao 
                                               where idsolicitacao= $idsolicitacao)";
            
            $result = execQuery($sql);
            $row = mysqli_fetch_array($result);
            $idtiposolicitacaoseguinte = $row['idtiposolicitacao_seguinte'];
            
            //se não houver solicitação seguinte, é a de ultima instancia, portanto não cabe mais recurso
            if(empty($idtiposolicitacaoseguinte))
                return false;
            else
            {
                //verifica se existe recurso pedido para a solicitação passada
                $sql = "select *
                        from lda_solicitacao
                        where idsolicitacaoorigem = $idsolicitacaoorigem 
                            and idtiposolicitacao = $idtiposolicitacaoseguinte
                        ";
                
                //se nao encontrar recurso, pode solicitar
                return (mysqli_num_rows(execQuery($sql))==0);
            }
            
        }
        
	static public function finaliza($idsolicitacao,$tiporesposta,$resposta, $arquivos)
	{
                if(empty($tiporesposta))
                {
                    return "O campo Tipo de Resposta deve ser preenchido";
                }

                if(empty($resposta))
                {
                    return "O campo Observação deve ser preenchido";
                }
                
                
		$sql="UPDATE lda_solicitacao SET 
			situacao = '$tiporesposta',
                        idusuarioresposta = ".getSession("uid").",
                        dataresposta = NOW(),
                        resposta = '".str_replace("'","\'",$resposta)."',
                        idsecretariaresposta = ".getSession("idsecretaria")."
                      WHERE idsolicitacao = '$idsolicitacao'";

                $con = db_open_trans();
                $all_query_ok=true;
                
                $erro="";

                if (!$con->query($sql))
                {	
                	die($con->error);
                    $erro = "Ocorreu um erro ao atualizar solicitação #2";
                    $all_query_ok = false;
                }
                else
                {
                    if(!empty($arquivos))
                    {
                            $numeroCampos = 3; //numero de campos de arquivo
                            $dir = getDiretorio("lda")."/";

                            for($i=0;$i<$numeroCampos;$i++) 
                            {

                                    if(!empty($arquivos["tmp_name"][$i]))
                                    {
                                            //insere arquivos
                                            $sql="INSERT INTO lda_anexo (
                                                                    idsolicitacao,
                                                                    nome,
                                                                    idusuarioinclusao,
                                                                    datainclusao
                                                            ) VALUES (
                                                                    '$idsolicitacao',
                                                                    null,
                                                                    ".getSession("uid").",
                                                                    NOW()
                                                            )";

                                            if ($con->query($sql))
                                            {
                                                    $idarquivo = $con->insert_id;
													$ext = getExtensaoArquivo($arquivos["name"][$i]);
		
                                                    $fullArquivo = "lda_".$idsolicitacao."_file_".$idarquivo.".".$ext;

                                                    if (!@move_uploaded_file($arquivos["tmp_name"][$i], $dir.$fullArquivo))
                                                    {
                                                            $erro = "Ocorreu um erro ao efetuar o upload do arquivo ".$dir.$fullArquivo."; nome:".$arquivos["tmp_name"][$i];
                                                            $all_query_ok=false;
                                                            break;
                                                    }
                                                    else
                                                    {
                                                            $sql = "update lda_anexo set nome = '$fullArquivo' where idanexo = $idarquivo";
                                                            if (!$con->query($sql))
                                                            {
                                                                    $erro = "Ocorreu um erro ao efetuar atualizar nome do arquivo";
                                                                    $all_query_ok=false;
                                                                    break;
                                                            }
                                                    }
                                            }
                                            else
                                            {
                                                    $erro = "Erro ao inserir arquivo";
                                                    $all_query_ok = false;					
                                                    break;
                                            }		
                                    }
                            }
                    }
                }
                
		if (!$all_query_ok) 	
                {
                    $con->rollback();
                    return $erro;
                }
                else
                {
                    $con->commit();
                    
                    //envia email de aviso de cadastro de solicitação ao solicitante
                    Solicitacao::enviaEmailSolicitante($idsolicitacao,"R");

                    return "";
                }
                    
                
		
	}

	static public function prorrogar($idsolicitacao,$motivo)
	{
                if(empty($motivo))
                {
                    return "O campo motivo deve ser preenchido";
                }
                
                $configuracao = Solicitacao::getParametrosConfiguracao();
                
                
                $sql = "select t.instancia from lda_solicitacao s, lda_tiposolicitacao t
                        where s.idtiposolicitacao = t.idtiposolicitacao
                               and s.idsolicitacao = $idsolicitacao";
                $rs = execQuery($sql);
                $row = mysqli_fetch_array($rs);
                
                //se não for prorrogação de primeira instancia
                if($row['instancia'] != "I")
                    $prazoresposta = $configuracao['qtdeprorrogacaorecurso'];
                else
                    $prazoresposta = $configuracao['qtdprorrogacaoresposta'];
                        
                
                $sql="UPDATE lda_solicitacao SET 
                        idusuarioprorrogacao = ".getSession("uid").",
                        dataprorrogacao = NOW(),
                        motivoprorrogacao = '".str_replace("'","\'",$motivo)."',
                        dataprevisaoresposta = date_add(dataprevisaoresposta, interval $prazoresposta DAY )
                      WHERE idsolicitacao = '$idsolicitacao'";

		if (!execQuery($sql)) 		
                {
                    return "Erro na prorrogação da solicitação";
                }
                else
                {
                    //envia email de aviso de cadastro de solicitação ao solicitante
                    Solicitacao::enviaEmailSolicitante($idsolicitacao,"P");

                }
                
		return "";
	}
        
                       
} //fecha a classe
?>
