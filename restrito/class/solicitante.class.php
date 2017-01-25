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

class Solicitante {
		
		
	private $idsolicitante;
	private $nome;
	private $profissao;
	private $cpfcnpj;
	private $idescolaridade;
	private $idfaixaetaria;
	private $email;
        private $idtipotelefone;
        private $dddtelefone;
        private $telefone;	
	private $tipopessoa;
	private $confirmeemail;
	private $logradouro;
	private $numero;
	private $complemento;
	private $bairro;
	private $cep;
	private $cidade;
	private $uf;
        private $escolaridade;
        private $faixaetaria;
        private $tipotelefone;
        private $senha;
        private $confirmesenha;
	private $erro;

	//idsolicitante
	public function getIdSolicitante(){
		return $this->idsolicitante;
	}
	public function setIdSolicitante($valor){
		$this->idsolicitante = $valor;
	}

	//nome
	public function getNome(){
                return $this->nome;
	}
	public function setNome($valor){
		$this->nome = $valor;
	}

	//profissao
	public function getProfissao(){
		return $this->profissao;
	}
	public function setProfissao($valor){
		$this->profissao = $valor;
	}

	//cpfcnpj
	public function getCpfCnpj(){
		return $this->cpfcnpj;
	}
	public function setCpfCnpj($valor){
		$this->cpfcnpj = $valor;
	}	
	
	//idescolaridade
	public function getIdEscolaridade(){
		return $this->idescolaridade;
	}
	public function setIdEscolaridade($valor){
		$this->idescolaridade = $valor;
	}
	public function getEscolaridade(){
		return $this->escolaridade;
	}
	
	//idfaixaetaria
	public function getIdFaixaetaria(){
		return $this->idfaixaetaria;
	}
	public function setIdFaixaetaria($valor){
		$this->idfaixaetaria = $valor;
	}
	public function getFaixaetaria(){
		return $this->faixaetaria;
	}
	
	//email
	public function getEmail(){
		return $this->email;
	}
	public function setEmail($valor){
		$this->email = $valor;
	}
	
	//telefone
	public function getIdTipoTelefone(){
		return $this->idtipotelefone;
	}
	public function setIdTipoTelefone($valor){
		$this->idtipotelefone = $valor;
	}
	public function getTipoTelefone(){
		return $this->tipotelefone;
	}

        //ddd telefone
	public function getDDDTelefone(){
		return $this->dddtelefone;
	}
	public function setDDDTelefone($valor){
		$this->dddtelefone = $valor;
	}

        //telefone
	public function getTelefone(){
		return $this->telefone;
	}
	public function setTelefone($valor){
		$this->telefone = $valor;
	}
	
	//tipopessoa
	public function getTipoPessoa(){
		return $this->tipopessoa;
	}
	public function setTipoPessoa($valor){
		$this->tipopessoa = $valor;
	}

	public function setConfirmeEmail($valor){
		$this->confirmeemail = $valor;
	}
	
	//logradouro
	public function getLogradouro(){
		return $this->logradouro;
	}
	public function setLogradouro($valor){
		$this->logradouro = $valor;
	}

	//bairro
	public function getBairro(){
		return $this->bairro;
	}
	public function setBairro($valor){
		$this->bairro = $valor;
	}
	
	//numero
	public function getNumero(){
		return $this->numero;
	}
	public function setNumero($valor){
		$this->numero = $valor;
	}
	
	//complemento
	public function getComplemento(){
		return $this->complemento;
	}
	public function setComplemento($valor){
		$this->complemento = $valor;
	}
	
	//cep
	public function getCep(){
		return $this->cep;
	}
	public function setCep($valor){
		$this->cep = $valor;
	}
	
	//cidade
	public function getCidade(){
		return $this->cidade;
	}
	public function setCidade($valor){
		$this->cidade = $valor;
	}
	
	//uf
	public function getUf(){
		return $this->uf;
	}
	public function setUf($valor){
		$this->uf = $valor;
	}

	//senha
	public function getSenha(){
		return $this->senha;
	}
	public function setSenha($valor){
		$this->senha = $valor;
	}
        
	//confirmasenha
	public function getConfirmaSenha(){
		return $this->confirmasenha;
	}
	public function setConfirmaSenha($valor){
		$this->confirmasenha = $valor;
	}
	
	//erro
	public function getErro(){
		return $this->erro;
	}
	
	//--------CONSTRUTOR---------------------------
	
	function Solicitante($idsolicitante=null)
	{
		if(!empty($idsolicitante))
		{
			$this->getDados($idsolicitante);
		}
	}
	
	//---------------------------------------------
	
	function getDados($idsolicitante)
	{
		$sql = "select s.*, 
                               tt.nome as tipotelefone,
                               fe.nome as faixaetaria,
                               e.nome as escolaridade
                        from lda_solicitante s
                        left join lda_tipotelefone tt on tt.idtipotelefone = s.idtipotelefone
                        left join lda_faixaetaria fe on fe.idfaixaetaria = s.idfaixaetaria
                        left join lda_escolaridade e on e.idescolaridade = s.idescolaridade
                        where idsolicitante = $idsolicitante";
		
		$rs = execQuery($sql);
		
		if(mysqli_num_rows($rs)>0)
		{
			$row = mysqli_fetch_array($rs);
	
			$this->idsolicitante		= $row["idsolicitante"];
			$this->nome 			= $row["nome"];
			$this->cpfcnpj			= $row["cpfcnpj"];
			$this->idescolaridade		= $row["idescolaridade"];
			$this->idfaixaetaria            = $row["idfaixaetaria"];
			$this->profissao		= $row["profissao"];		
			$this->tipopessoa		= $row["tipopessoa"];
                        $this->idtipotelefone           = $row["idtipotelefone"];
                        $this->dddtelefone              = $row["dddtelefone"];
			$this->telefone                 = $row["telefone"];
			$this->email			= $row["email"];
			$this->logradouro		= $row["logradouro"];
			$this->cep			= $row["cep"];
			$this->bairro			= $row["bairro"];
			$this->cidade			= $row["cidade"];
			$this->uf			= $row["uf"];
			$this->numero			= $row["numero"];
			$this->tipotelefone		= $row["tipotelefone"];
                        $this->complemento		= $row["complemento"];
                        $this->faixaetaria		= $row["faixaetaria"];
                        $this->escolaridade		= $row["escolaridade"];
			
		}
		else
			die("Solicitante nao informado");
	}
	
	function validaDados()
	{
						
		if (empty($this->tipopessoa))
		{
			$this->erro = "Tipo de Pessoa não informado.";
			return false;
		}
		
		if($this->tipopessoa == "F")
		{
                        if (empty($this->nome))
                        {
                                $this->erro = "Nome não informado.";
                                return false;
                        }
			elseif (empty($this->cpfcnpj))
			{
				$this->erro = "CPF não informado.";
				return false;
			}
			elseif (!isCpf($this->cpfcnpj))
			{
				$this->erro = "CPF inválido.";
				return false;
			}
		}
		else
		{
                        if (empty($this->nome))
                        {
                                $this->erro = "Nome não informado.";
                                return false;
                        }
			if (empty($this->cpfcnpj))
			{
				$this->erro = "CNPJ não informado.";
				return false;
			}
			elseif (!isCnpj($this->cpfcnpj))
			{
				$this->erro = "CNPJ inválido.";
				return false;
			}
		}
		
		if (empty($this->email))
		{
			$this->erro = "E-mail não informado";
			return false;
		}
		elseif (!isEmail($this->email))
		{
			$this->erro = "E-mail inválido";
			return false;
		}
		elseif (empty($this->confirmeemail))
		{
			$this->erro = "Confirmação do e-mail não informado";
			return false;
		}
		elseif (!isEmail($this->confirmeemail))
		{
			$this->erro = "E-mail para confirmação está inválido";
			return false;
		}
		elseif ($this->confirmeemail != $this->email)
		{
			$this->erro = "E-mail não confere com a confirmação";
			return false;
		}

		if (empty($this->senha))
		{
			$this->erro = "Senha de acesso não informada";
			return false;
		}
		elseif (empty($this->confirmasenha))
		{
			$this->erro = "Confirmação da senha não informada";
			return false;
		}
		elseif ($this->confirmasenha != $this->senha)
		{
			$this->erro = "Senha não confere com a confirmação";
			return false;
		}
                
		//validação de endereço
                /*
		if (empty($this->cep))
		{
			$this->erro = "CEP não informado.";
			return false;
		}
		elseif (empty($this->logradouro))
		{
			$this->erro = "Logradouro não informado";
			return false;
		}
		elseif (empty($this->bairro))
		{
			$this->erro = "Bairro não informado";
			return false;
		}
		elseif (empty($this->cidade))
		{
			$this->erro = "Cidade não informada";
			return false;
		}
		elseif (empty($this->numero))
		{
			$this->erro = "Numero não informado";
			return false;
		}
		elseif (empty($this->uf))
		{
			$this->erro = "UF não informada";
			return false;
		}
		*/
		
		//verifica se ja existe registro cadastrado com o cpfcnpj ---
		if (!empty($this->idsolicitante))
			$sql = "select * from lda_solicitante where cpfcnpj = '$this->cpfcnpj' and tipopessoa = '$this->tipopessoa' and idsolicitante <> $this->idsolicitante";
		else
			$sql = "select * from lda_solicitante where cpfcnpj = '$this->cpfcnpj' and tipopessoa = '$this->tipopessoa'";
				
		if(mysqli_num_rows(execQuery($sql)) > 0)
		{
			$this->erro = "Cadastro já realizado.";
			return false;
		}
		//-----------------------------------------------------------------------
		
		return true;
	}

	function cadastra()
	{
		if($this->validaDados())
		{
			$sql="INSERT INTO lda_solicitante (
						nome,
						profissao,
						cpfcnpj,
						idescolaridade,
						idfaixaetaria,
						email,
                                                idtipotelefone,
                                                dddtelefone,
						telefone,
						tipopessoa,
						logradouro,
						numero,
						complemento,
						bairro,
						cep,
						cidade,
						uf,
						chave
				) VALUES (
						'$this->nome',
						'$this->profissao',
						'$this->cpfcnpj',
                                                ".(empty($this->idescolaridade)?"null":$this->idescolaridade).",
                                                ".(empty($this->idfaixaetaria)?"null":$this->idfaixaetaria).",
						'$this->email',
                                                ".(empty($this->idtipotelefone)?"null":$this->idtipotelefone).",
                                                '$this->dddtelefone',
						'$this->telefone',
						'$this->tipopessoa',
						'$this->logradouro',
						'$this->numero',
						'$this->complemento',
						'$this->bairro',
						'$this->cep',
						'$this->cidade',
						'$this->uf',
						md5('$this->senha')
				);";

			$con = db_open_trans();
			$all_query_ok= mysqli_query($con, $sql);

			if (!$all_query_ok) 
			{	
				 printf("Errormessage: %s\n", mysqli_error());
				
				$this->erro = "Erro ao inserir Solicitante #1";
				$con->rollback(); 
			}
			else
			{
				$this->idsolicitante = $con->insert_id;
					
				$body="Prezado(a) $this->nome,<br> <br>
                                        
                                       Você se cadastrou no sistema ".SISTEMA_NOME.". Para confirmar seu cadastro, favor acesse o seguinte endereço: <br/><br>
                                       ".SITELNK."confirmacao/?k=".md5($this->idsolicitante)."<br><br>
                                            
                                        Mensagem automatica do ".SISTEMA_NOME;
				
				if (!sendmail($this->email,'Confirmação de cadastro no '.SISTEMA_NOME,$body))
					$this->erro = "Não foi possível enviar e-mail de confirmação."; //$all_query_ok = false;

				if ($all_query_ok)
				{
					$con->commit(); 
					//logger("Cadastrou Consumidor");  
					$this->erro = "";
				}
				else
				{
					//echo $sql;
					$con->rollback(); 
					$this->erro = "Ocorreu um erro na inclusao dos dados do Solicitante.";
				}
			}
			
			$con->close(); 
			
			return $all_query_ok;
		}
		else
			return false;
	}

        public function reenvioConfirmacao(){
                
                $sql="select nome, email from lda_solicitante where idsolicitante = $this->idsolicitante";
                $result = execQuery($sql);
                $row = mysqli_fetch_array($result);
            
                $body="Prezado(a) ".$row['nome'].",<br> <br>

                        Você precisa completar seu cadastro para ter acesso ao sistema ".SISTEMA_NOME.". Para isso, precisamos da sua confirmação, favor acesse o seguinte endereço: <br/><br>
                        ".SITELNK."confirmacao/?k=".md5($this->idsolicitante)."<br><br>

                        Mensagem automatica do sistema ".SISTEMA_NOME;

                if (!sendmail($row['email'],'Confirmação de cadastro no '.SISTEMA_NOME,$body))
                        return false;
                else
                        return true;
            
        }
        
	function atualiza()
	{
		if($this->validaDados())
		{
			$sql="UPDATE lda_solicitante SET
						nome  		= '$this->nome',
						cpfcnpj		= '$this->cpfcnpj',
						profissao  	= '$this->profissao',
						idescolaridade	= ".(empty($this->idescolaridade)?"null":$this->idescolaridade).",
						idfaixaetaria	= ".(empty($this->idfaixaetaria)?"null":$this->idfaixaetaria).",
						email		= '$this->email',
                                                idtipotelefone	= ".(empty($this->idtipotelefone)?"null":$this->idtipotelefone).",
                                                dddtelefone	= '$this->dddtelefone',
						telefone	= '$this->telefone',
						tipopessoa	= '$this->tipopessoa',
						logradouro	= '$this->logradouro',
						numero		= '$this->numero',
						complemento	= '$this->complemento',
						bairro		= '$this->bairro',
						cep		= '$this->cep',
						cidade		= '$this->cidade',
						uf		= '$this->uf'
				 WHERE idsolicitante = $this->idsolicitante";

			$con = db_open_trans();
			$all_query_ok=true;

			if (!$con->query($sql)) 
			{
				$this->erro = "Erro ao atualizar Solicitante.";
				$con->rollback(); 
				$all_query_ok=false;
			}
			else
			{
				$con->commit(); 
				logger("Atualizou Consumidor");  
				$this->erro = "";
			}
			
			$con->close(); 
			
			return $all_query_ok;
		}
		else
			return false;
	}
	
	function confirmaCadastro($idsolicitantecripto)
	{
		$sql = "select idsolicitante, nome, email, telefone,tipopessoa, cpfcnpj from lda_solicitante where md5(idsolicitante) = '$idsolicitantecripto' and dataconfirmacao is null";
		$rs = execQuery($sql);
		
		if (mysqli_num_rows($rs)>0)
		{
			$row = mysqli_fetch_array($rs);
			$nome = ucwords2($row['nome']);
			$email = $row['email'];
			$this->cpfcnpj = $row['cpfcnpj'];
			$idsolicitante = $row['idsolicitante'];

			$sql="UPDATE lda_solicitante SET 
					dataconfirmacao = CURRENT_DATE(),
					confirmado = 1
				  WHERE idsolicitante = '$idsolicitante'";

			$con = db_open_trans();
			$all_query_ok=true;

			if ($con->query($sql)) 					   
			{
			
				$body="Prezado(a) $this->nome,<br> <br>
                                        Seu cadastro no ".SISTEMA_NOME." foi confirmado com sucesso. <br>
                                        Link de acesso: ".SITELNK." <br>
                                        Usuário: $this->cpfcnpj<br><br>
                                        **A senha de acesso é aquela informada no cadastro. Caso não se lembre, solicite o envio de uma nova senha pelo link \"Esqueci a senha\" no formulário de login do sistema.
                                        ";
				
				if (!sendmail($email,'Cadastro realizado com sucesso!',$body))
					$all_query_ok = false;
			}
			else
			{
				$all_query_ok = false;
			}
			
			if($all_query_ok)
			{
				$this->nome = $nome;
				$con->commit(); 
			}
			else
			{
				$this->erro = "erro na confirmação da solicitação";//.$con->error;			
				$con->rollback();
			}
			
			return $all_query_ok;
		}
		else
		{
			$this->erro = "Sua confirmação de cadastro já foi realizada.";
			return false;
		}
	}

	function resetaSenha($cpfcnpj)
	{
		if (empty($cpfcnpj))
		{
			$this->erro = "cpfcnpj nao informado";
			return false;
		}
		
		$sql = "select idsolicitante, nome, email, cpfcnpj, confirmado from lda_solicitante where cpfcnpj = '$cpfcnpj'";
		$rs = execQuery($sql);
		
		if (mysqli_num_rows($rs)>0)
		{
			$row = mysqli_fetch_array($rs);
			$nome = ucwords2($row['nome']);
			$chave = substr(md5($row['cpfcnpj']),0,8);
			$cpfcnpj = $row['cpfcnpj'];
			$email = $row['email'];
			$idsolicitante = $row['idsolicitante'];

			//se ja tiver confirmado o cadastro reseta senha no banco e envia o email
			if($row['confirmado'])
			{
				$sql="UPDATE lda_solicitante SET 
						chave = '".md5($chave)."'
					  WHERE idsolicitante = $idsolicitante";

				$con = db_open_trans();
				$all_query_ok=true;
				
				if ($con->query($sql)) 
				{
					$body="Caro(a) $nome,<br> <br>
						   Foi solicitado redefinição de senha de acesso ao sistema do ".SISTEMA_NOME.". Para acessar o sistema entre no endereço ".URL_BASE_SISTEMA." <br>
						   Dados de acesso: <br>
						   Login: $cpfcnpj<br>
						   Senha: $chave";
					
					if (!sendmail($email,'Redefinição de Senha',$body))
					{
						$this->erro = "Ocorreu um erro no envio do e-mail. Favor tente mais tarde.";
						$all_query_ok = false;
					}
				}
				else
				{
					$this->erro = "Ocorreu um erro na redefinição da senha. Favor tente mais tarde.";
					$all_query_ok = false;
				}
				
				if($all_query_ok)
				{
					$this->email = $email;
					$this->nome = $nome;
					$con->commit();
					return true;
				}
				else
				{
					$con->rollback();
					return false;
				}
			}
			//caso nao tenha confirmado, reenvia email de confirmação
			else
			{
				$body="Caro(a) $nome,<br> <br>
					   Para confirmação do seu cadastro no ".SISTEMA_NOME." efetue os seguintes passos: <br/>
					     Selecione e Copie o endereço ao lado : ".SITELNK."confirmacao/?k=".md5($idsolicitante).
						"Cole-o na barra de endereços do navegador
						 Pressione no teclado a tecla ENTER";
				
				if (!sendmail($email,'Solicitação de confirmação de cadastro',$body))
				{
					$this->erro = "Ocorreu um erro no envio do e-mail. Favor tente mais tarde.";
					return false;
				}
				else
				{
					$this->erro = "Caro(a) $nome, estamos aguardando a confirmação do seu cadastro. Para tanto, reenviamos o pedido de confirmação para o seu email: $email";
					return false;
				}
			}
		}
		//caso nao tenha sido cadastrado
		else
		{
			$this->erro = "Não existe cadastro para o CPF/CNPJ informado.";
			return false;
		}
	}

	function alteraSenha($idsolicitante,$senhaatual,$novasenha,$confirmasenha)
	{
		if(empty($idsolicitante) or empty($senhaatual) or empty($novasenha) or empty($confirmasenha))
		{
			$this->erro = "parametros nao informados.";
			return false;
		}
		
		$sql = "select chave from lda_solicitante where idsolicitante = $idsolicitante";
		$rs = execQuery($sql);
		
		if(mysqli_num_rows($rs) == 0)
		{
			$this->erro = "Solicitante nao encontrado";
			return false;
		}
		else
		{
			$row = mysqli_fetch_array($rs);
			$chave = $row['chave'];
			
			if(md5($senhaatual) != $chave)
			{
				$this->erro = "Senha atual está incorreta.";
				return false;
			}
			
			if($novasenha <> $confirmasenha)
			{
				$this->erro = "Nova senha não confere com a confirmação";
				return false;
			}
		}

		$sql="UPDATE lda_solicitante SET
                            chave = '".md5($novasenha)."'
			 WHERE idsolicitante = $idsolicitante";

		if (!execQuery($sql)) 
		{
			$this->erro = "Erro ao alterar senha do solicitante";
			return false;
		}
		else
		{
			//logger("Alterou senha do Cidadão");  
			return true;
		}
	}	
	
} //fecha a classe
?>
