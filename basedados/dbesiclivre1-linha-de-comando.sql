-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Servidor:
-- Tempo de Geração: 11/09/2014 às 16:16:24
-- Versão do Servidor: 5.5.38
-- Versão do PHP: 5.4.4-14+deb7u14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- Estrutura da tabela `lda_anexo` ---------Tabela responsavel pela anexacao dos dados dos arquivos 
--

CREATE TABLE IF NOT EXISTS `lda_anexo` (
  `idanexo` int(10) NOT NULL AUTO_INCREMENT,
  `idsolicitacao` int(11) NOT NULL,
  `nome` varchar(200) DEFAULT NULL,
  `datainclusao` datetime NOT NULL,
  `idusuarioinclusao` int(11) DEFAULT NULL,
  PRIMARY KEY (`idanexo`),
  KEY `idsolicitacao` (`idsolicitacao`),
  KEY `idusuarioinclusao` (`idusuarioinclusao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='anexos da lei de acesso' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lda_configuracao` --- Tabela dinamica que permite alteraco das respostas , datas prorragativas 
--

CREATE TABLE IF NOT EXISTS `lda_configuracao` (
  `prazoresposta` int(11) NOT NULL COMMENT 'Prazo, em dias, para resposta a solicitação',
  `qtdprorrogacaoresposta` int(11) NOT NULL COMMENT 'Quantidade de dias que podera ser prorrogada a resposta da solicitação',
  `prazosolicitacaorecurso` int(11) NOT NULL COMMENT 'Prazo, em dias, para solicitação de recurso após a resposta negada',
  `prazorespostarecurso` int(11) NOT NULL COMMENT 'Prazo, em dias, para resposta ao recurso',
  `qtdeprorrogacaorecurso` int(11) NOT NULL COMMENT 'Quantidade de dias que podera ser prorrogada resposta ao recurso',
  `diretorioarquivos` varchar(300) NOT NULL COMMENT 'Diretorio onde será armazenado os anexos do sistema',
  `urlarquivos` varchar(300) NOT NULL COMMENT 'URL de acesso aos anexos do sistema',
  `nomeremetenteemail` varchar(100) NOT NULL COMMENT 'nome do remetende para envio de emails pelo sistema',
  `emailremetente` varchar(100) NOT NULL COMMENT 'email do remetente para envio de emails pelo sistema'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `lda_configuracao` ----- Configuracao do recebimento das solicitacores ------- Esta tabela e de suma importancia manter atualizada para o recebimento das solicitacoes  dos usuarios e direcionamento das respostas pelo administrados , e aconselhavel seguir o modelo--------
--

INSERT INTO `lda_configuracao` (`prazoresposta`, `qtdprorrogacaoresposta`, `prazosolicitacaorecurso`, `prazorespostarecurso`, `qtdeprorrogacaorecurso`, `diretorioarquivos`, `urlarquivos`, `nomeremetenteemail`, `emailremetente`) VALUES(20, 10, 10, 10, 10, '/internet/arquivos_anexos/leideacesso', 'http://portal.com.br ', 'Sistema Lei de Acesso a Informação - ORGAO', 'emailremetente@orgao.gov.br');

-- --------------------------------------------------------

--
-- Estrutura da tabela `lda_escolaridade` --------------------- Estrutura alteravel --Responsavel por indicar indice de escolaridade 
--

CREATE TABLE IF NOT EXISTS `lda_escolaridade` (
  `idescolaridade` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  PRIMARY KEY (`idescolaridade`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='escolaridades do sistema de lei de acesso' AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `lda_escolaridade` -------- Extracao de dados 
--

INSERT INTO `lda_escolaridade` (`idescolaridade`, `nome`) VALUES
(1, 'Sem instrução formal'),
(2, 'Ensino fundamental'),
(3, 'Ensino Medio'),
(4, 'Ensino Superior'),
(5, 'Pós-graduação'),
(6, 'Mestrado/Doutorado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `lda_faixaetaria` -----------  Estrutura alteravel --Responsavel por indicar indice de faixa etaria
--

CREATE TABLE IF NOT EXISTS `lda_faixaetaria` (
  `idfaixaetaria` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  PRIMARY KEY (`idfaixaetaria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='faixa etaria do sistema de lei de acesso' AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `lda_faixaetaria` ----Extracao de dados 
--

INSERT INTO `lda_faixaetaria` (`idfaixaetaria`, `nome`) VALUES
(1, 'Até 20 anos'),
(2, 'de 21 a 40 anos'),
(3, 'de 41 a 59 anos'),
(4, 'acima de 59 anos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `lda_movimentacao` --------Estrutura alteravel --Responsavel por indicar indice de movimentacao 
--

CREATE TABLE IF NOT EXISTS `lda_movimentacao` (
  `idmovimentacao` int(11) NOT NULL AUTO_INCREMENT,
  `idsecretariaorigem` int(10) NOT NULL,
  `idusuarioenvio` int(10) NOT NULL,
  `idsecretariadestino` int(10) NOT NULL,
  `idusuariorecebimento` int(10) DEFAULT NULL,
  `dataenvio` datetime NOT NULL,
  `datarecebimento` datetime DEFAULT NULL,
  `idsolicitacao` int(11) NOT NULL,
  `despacho` varchar(4000) DEFAULT NULL,
  `arquivo` varchar(100) DEFAULT NULL COMMENT 'nome do arquivo anexado a movimentação',
  PRIMARY KEY (`idmovimentacao`),
  KEY `idsecretariaorigem` (`idsecretariaorigem`),
  KEY `idusuarioenvio` (`idusuarioenvio`),
  KEY `idsecretariadestino` (`idsecretariadestino`),
  KEY `idusuariorecebimento` (`idusuariorecebimento`),
  KEY `idsolicitacao` (`idsolicitacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='movimentação das solicitações do lei de acesso' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lda_numeracao` -------Estrutura alteravel --Responsavel por indicar indice de numeracao 
--

CREATE TABLE IF NOT EXISTS `lda_numeracao` (
  `numero` int(11) NOT NULL DEFAULT '0' COMMENT 'ultimo numero no ano para as demandas',
  `ano` int(4) NOT NULL,
  `dataalteracao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lda_solicitacao`--------Estrutura alteravel --Responsavel por indicar indice de solicitacao 
--

CREATE TABLE IF NOT EXISTS `lda_solicitacao` (
  `idsolicitacao` int(11) NOT NULL AUTO_INCREMENT,
  `idsolicitante` int(11) NOT NULL,
  `numprotocolo` int(11) NOT NULL,
  `anoprotocolo` int(5) NOT NULL,
  `idtiposolicitacao` int(5) NOT NULL COMMENT 'Identifica o tipo de solicitação',
  `idsolicitacaoorigem` int(11) DEFAULT NULL COMMENT 'identifica a solicitação original quando a solicitação for de recurso (tiposolicitao ser P ou S)',
  `situacao` varchar(2) NOT NULL DEFAULT 'A' COMMENT 'A - aberto; T - em tramitacao; N - negado; R - respondido;',
  `formaretorno` char(1) NOT NULL COMMENT '[E]mail - [F]ax - [C]orreio',
  `datasolicitacao` datetime NOT NULL,
  `textosolicitacao` varchar(4000) NOT NULL,
  `datarecebimentosolicitacao` datetime DEFAULT NULL COMMENT 'data de recebimento da solicitação',
  `idusuariorecebimento` int(11) DEFAULT NULL COMMENT 'dados da sessao de recebimento da solicitação',
  `dataprevisaoresposta` datetime NOT NULL COMMENT 'data prevista para a solicitação ser respondida',
  `dataprorrogacao` datetime DEFAULT NULL COMMENT 'Indica se a data prevista para resposta foi prorrogada',
  `motivoprorrogacao` varchar(2000) DEFAULT NULL,
  `idusuarioprorrogacao` int(11) DEFAULT NULL COMMENT 'dados da sessao da prorrogação',
  `dataresposta` datetime DEFAULT NULL COMMENT 'data da resposta da solicitação',
  `resposta` varchar(4000) NOT NULL,
  `idusuarioresposta` int(11) DEFAULT NULL,
  `idsecretariaselecionada` int(10) DEFAULT NULL COMMENT 'Identifica o SIC direcionado pelo solicitante no momento do cadastro da solicitação',
  `idsecretariaresposta` int(10) DEFAULT NULL COMMENT 'Identificador da secretaria que respondeu a requisição',
  PRIMARY KEY (`idsolicitacao`),
  KEY `idsolicitante` (`idsolicitante`),
  KEY `idsolicitacaoorigem` (`idsolicitacaoorigem`),
  KEY `idusuariorecebimento` (`idusuariorecebimento`),
  KEY `idusuarioprorrogacao` (`idusuarioprorrogacao`),
  KEY `idusuarioresposta` (`idusuarioresposta`),
  KEY `idtiposolicitacao` (`idtiposolicitacao`),
  KEY `idsecretariaselecionada` (`idsecretariaselecionada`),
  KEY `idsecretariaresposta` (`idsecretariaresposta`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='solicitações do lei de acesso' AUTO_INCREMENT=9 ;

--
-- Gatilhos `lda_solicitacao`
--
DROP TRIGGER IF EXISTS `tBI_lda_solicitacao`;


-- DELIMITER é necessário na linha de comando, mas só funciona nela:
-- http://dev.mysql.com/doc/refman/5.7/en/stored-programs-defining.html
DELIMITER //

CREATE TRIGGER `tBI_lda_solicitacao` BEFORE INSERT ON `lda_solicitacao`
 FOR EACH ROW BEGIN

    SELECT instancia into @instancia FROM lda_tiposolicitacao
    WHERE idtiposolicitacao = NEW.idtiposolicitacao;

    if @instancia = 'I' then
        set @ano = date_format(current_date(),'%Y');

		SELECT numero into @numero FROM lda_numeracao
		WHERE ano = @ano;

		if @numero is null then
			 set @numero = 1;
			 insert into lda_numeracao (ano, numero, dataalteracao)
			 values(@ano, @numero, NOW());
		else
			 set @numero = @numero + 1;

			 update lda_numeracao set
			 numero = @numero,
			 dataalteracao = NOW()
			 where ano = @ano;
		end if;

	else
		SELECT numprotocolo, anoprotocolo into @numero, @ano FROM lda_solicitacao
		WHERE idsolicitacao = NEW.idsolicitacaoorigem;
	
	end if;

	set NEW.numprotocolo = @numero;
	set NEW.anoprotocolo = @ano;


  END;

//

-- --------------------------------------------------------

--
-- Estrutura da tabela `lda_solicitante`
--

CREATE TABLE IF NOT EXISTS `lda_solicitante` (
  `idsolicitante` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `tipopessoa` char(1) NOT NULL COMMENT '[F]isica - [J]uridica',
  `cpfcnpj` varchar(14) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `idtipotelefone` int(5) DEFAULT NULL,
  `dddtelefone` varchar(2) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `logradouro` varchar(200) NOT NULL,
  `numero` varchar(20) NOT NULL COMMENT 'numero do endereço',
  `complemento` varchar(30) DEFAULT NULL,
  `bairro` varchar(60) NOT NULL,
  `cep` varchar(8) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `uf` char(2) NOT NULL,
  `profissao` varchar(50) DEFAULT NULL,
  `idescolaridade` int(5) DEFAULT NULL,
  `idfaixaetaria` int(5) DEFAULT NULL,
  `datacadastro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmado` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Se o cadastro foi confirmado. 1-sim; 0-nao',
  `dataconfirmacao` datetime DEFAULT NULL,
  `chave` varchar(50) NOT NULL COMMENT 'Senha criptografada, gerada aleatoria no cadastro',
  PRIMARY KEY (`idsolicitante`),
  KEY `idescolaridade` (`idescolaridade`),
  KEY `idfaixaetaria` (`idfaixaetaria`),
  KEY `idtipotelefone` (`idtipotelefone`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lda_tiposolicitacao`
--

CREATE TABLE IF NOT EXISTS `lda_tiposolicitacao` (
  `idtiposolicitacao` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `idtiposolicitacao_seguinte` int(5) DEFAULT NULL COMMENT 'Identificador do tipo de solicitação que é feita após essa.',
  `instancia` varchar(1) NOT NULL COMMENT 'I-inicial; S-seguimento; U-ultima',
  `idusuarioinclusao` int(11) NOT NULL,
  `datainclusao` datetime NOT NULL,
  `idusuarioalteracao` int(11) DEFAULT NULL,
  `dataalteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`idtiposolicitacao`),
  UNIQUE KEY `idtiposolicitacao_seguinte` (`idtiposolicitacao_seguinte`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tipos de solicitação da solicitação de informação' AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `lda_tiposolicitacao`
--

INSERT INTO `lda_tiposolicitacao` (`idtiposolicitacao`, `nome`, `idtiposolicitacao_seguinte`, `instancia`, `idusuarioinclusao`, `datainclusao`, `idusuarioalteracao`, `dataalteracao`) VALUES
(1, 'Inicial', 2, 'I', 16, '2014-09-11 16:12:41', NULL, NULL),
(2, 'Recurso Primeira Instancia', 3, 'S', 16, '2014-09-11 16:12:41', NULL, NULL),
(3, 'Recurso Segunda Instancia', 4, 'S', 16, '2014-09-11 16:12:41', NULL, NULL),
(4, 'Recurso de Terceira Instancia', NULL, 'U', 16, '2014-09-11 16:12:41', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `lda_tipotelefone` --- Estrutura alteravel --Responsavel por indicar indice de tipo telefone
--

CREATE TABLE IF NOT EXISTS `lda_tipotelefone` (
  `idtipotelefone` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  PRIMARY KEY (`idtipotelefone`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='escolaridades do sistema de lei de acesso' AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `lda_tipotelefone` ---Extracao de dados 
--

INSERT INTO `lda_tipotelefone` (`idtipotelefone`, `nome`) VALUES
(1, 'Comercial'),
(2, 'Residencial'),
(3, 'Pessoal');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sis_acao` -----Estrutura alteravel ----Determina a utilizacao do usuario - administrador quanto a atividade do perfil 1.Ativo 2.Inativo - Tabela deve ser configurada a partir dos  padroes de privacidade definidos pelo administrador ----------
--

CREATE TABLE IF NOT EXISTS `sis_acao` (
  `idacao` int(11) NOT NULL AUTO_INCREMENT,
  `idtela` int(5) NOT NULL,
  `denominacao` varchar(50) NOT NULL DEFAULT '',
  `operacao` varchar(20) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'A' COMMENT '[A]tivo - [I]nativo',
  PRIMARY KEY (`idacao`),
  KEY `idtela` (`idtela`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=529 ;

--
-- Extraindo dados da tabela `sis_acao` Extracao de dados
--

INSERT INTO `sis_acao` (`idacao`, `idtela`, `denominacao`, `operacao`, `status`) VALUES
(4, 3, 'Adicionar', 'ADDUSR', 'A'),
(5, 3, 'Remover', 'DELUSR', 'A'),
(6, 3, 'Atualizar', 'UPTUSR', 'A'),
(7, 3, 'Listar', 'LSTUSR', 'A'),
(8, 3, 'Ativar/Desativar', 'DEAUSR', 'A'),
(9, 3, 'Atualizar', 'CHPERM', 'A'),
(11, 16, 'Atualizar', 'UPTSEC', 'A'),
(12, 16, 'Adicionar', 'INSSEC', 'A'),
(13, 16, 'Remover', 'DELSEC', 'A'),
(14, 16, 'Listar', 'LSTSEC', 'A'),
(71, 18, 'Adicionar', 'INSGRP', 'A'),
(72, 18, 'Remover', 'DELGRP', 'A'),
(73, 18, 'Atualizar', 'UPTGRP', 'A'),
(74, 18, 'Listar', 'LSTGRP', 'A'),
(178, 50, 'Listar Configuração', 'LSTLDACONF', 'A'),
(180, 50, 'Atualizar Configuração', 'UPTLDACONF', 'A'),
(515, 126, 'Listar', 'LSTLDASOLICITACAO', 'A'),
(516, 126, 'Movimentar', 'LDAMOVIMENTAR', 'A'),
(517, 126, 'Responder Solicitação', 'LDARESPONDER', 'A'),
(518, 126, 'Prorrogar Solicitação', 'LDAPRORROGAR', 'A'),
(519, 128, 'Consulta', 'LDACONSULTAR', 'A'),
(524, 18, 'Associa usuários ao perfil', 'INSGRU', 'A'),
(525, 129, 'Adicionar', 'INSTIPOSOL', 'A'),
(526, 129, 'Remover', 'DELTIPOSOL', 'A'),
(527, 129, 'Listar', 'LSTTIPOSOL', 'A'),
(528, 129, 'Atualizar', 'UPTTIPOSOL', 'A');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sis_errologin` -------- Tabela de erro ------------ Aloca a quantidade de erros por data e login ------------------
--

CREATE TABLE IF NOT EXISTS `sis_errologin` (
  `sistema` varchar(10) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='registro de tentativas de login de usuario';

-- --------------------------------------------------------

--
-- Estrutura da tabela `sis_grupo` ---------- Alocacao dos dados dos usuarios ,informando a sessao do usuario e seu id para identificacao -----------
--

CREATE TABLE IF NOT EXISTS `sis_grupo` (
  `idgrupo` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-ativo; 0-inativo',
  `idusuarioinclusao` int(10) DEFAULT NULL,
  `idusuarioalteracao` int(10) DEFAULT NULL,
  `datainclusao` datetime DEFAULT NULL,
  `dataalteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`idgrupo`),
  KEY `idusuarioinclusao` (`idusuarioinclusao`),
  KEY `idusuarioalteracao` (`idusuarioalteracao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `sis_grupo` --------- Alocacao dos dados na tabela sis_grupo - grupo 1- Administrador , grupo 2-Usuario , edicao de atributos e privelegios para acesso o sistema ----
--

INSERT INTO `sis_grupo` (`idgrupo`, `nome`, `descricao`, `ativo`, `idusuarioinclusao`, `idusuarioalteracao`, `datainclusao`, `dataalteracao`) VALUES
(1, 'Administrador Geral', 'Administra o sistema com permissão total', 1, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Usuários', 'Usuários que efetuarão movimentação no sistema', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sis_grupousuario` -------- Tabela de divisao dos grupos -- Principais grupos ---- 1-Administrador ---2- Usuario ----
--

CREATE TABLE IF NOT EXISTS `sis_grupousuario` (
  `idgrupousuario` int(10) NOT NULL AUTO_INCREMENT,
  `idgrupo` int(5) NOT NULL,
  `idusuario` int(10) NOT NULL,
  PRIMARY KEY (`idgrupousuario`),
  KEY `idgrupo_fk` (`idgrupo`),
  KEY `idusuario_fk` (`idusuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1182 ;

--
-- Extraindo dados da tabela `sis_grupousuario` -----------------------Necessario alteracao ,caso ocorra alteraco dos grupos-------------------Alteracao deve estar relacionada a alteracao dos dados da tabela sis_grupo
--

INSERT INTO `sis_grupousuario` (`idgrupousuario`, `idgrupo`, `idusuario`) VALUES
(1175, 1, 16),
(1176, 2, 16);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sis_log` -----------  Tabela que abriga dados da sessao no sistema ----------------------
--

CREATE TABLE IF NOT EXISTS `sis_log` (
  `idlog` int(11) NOT NULL AUTO_INCREMENT,
  `datahora` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `usuario` varchar(20) NOT NULL DEFAULT '',
  `ipaddr` varchar(15) NOT NULL DEFAULT '',
  `mensagem` varchar(250) NOT NULL DEFAULT '',
  `dados_get` text NOT NULL,
  `dados_post` text NOT NULL,
  PRIMARY KEY (`idlog`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sis_menu`
--

CREATE TABLE IF NOT EXISTS `sis_menu` (
  `idmenu` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-ativo; 0-inativo',
  `ordem` int(5) NOT NULL DEFAULT '1' COMMENT 'Ordem de exibição',
  PRIMARY KEY (`idmenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Extraindo dados da tabela `sis_menu`
--

INSERT INTO `sis_menu` (`idmenu`, `nome`, `ativo`, `ordem`) VALUES
(7, 'Administração', 1, 6),
(45, 'Atendimento', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sis_permissao`
--

CREATE TABLE IF NOT EXISTS `sis_permissao` (
  `idpermissao` int(11) NOT NULL AUTO_INCREMENT,
  `idacao` int(11) NOT NULL DEFAULT '0',
  `idgrupo` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idpermissao`),
  KEY `idacao` (`idacao`),
  KEY `idgrupo` (`idgrupo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56561 ;

--
-- Extraindo dados da tabela `sis_permissao`
--

INSERT INTO `sis_permissao` (`idpermissao`, `idacao`, `idgrupo`) VALUES
(56508, 515, 2),
(56509, 516, 2),
(56510, 518, 2),
(56511, 517, 2),
(56512, 519, 2),
(56535, 4, 1),
(56536, 8, 1),
(56537, 6, 1),
(56538, 9, 1),
(56539, 7, 1),
(56540, 5, 1),
(56541, 12, 1),
(56542, 11, 1),
(56543, 14, 1),
(56544, 13, 1),
(56545, 71, 1),
(56546, 524, 1),
(56547, 73, 1),
(56548, 74, 1),
(56549, 72, 1),
(56550, 180, 1),
(56551, 178, 1),
(56552, 525, 1),
(56553, 528, 1),
(56554, 527, 1),
(56555, 526, 1),
(56556, 515, 1),
(56557, 516, 1),
(56558, 518, 1),
(56559, 517, 1),
(56560, 519, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sis_secretaria`
--

CREATE TABLE IF NOT EXISTS `sis_secretaria` (
  `idsecretaria` int(10) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `sigla` varchar(30) NOT NULL,
  `responsavel` varchar(50) DEFAULT NULL,
  `telefonecontato` varchar(20) DEFAULT NULL,
  `ativado` tinyint(1) NOT NULL DEFAULT '1',
  `emailsic` varchar(100) DEFAULT NULL COMMENT 'Email do SIC do orgao (ou alias do grupo que faz parte do SIC do orgao)',
  `siccentral` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'indica se o SIC (lei de acesso) é unidade centralizadora (recebe as primeiras solicitações)',
  `idusuarioinclusao` int(10) DEFAULT NULL,
  `idusuarioalteracao` int(10) DEFAULT NULL,
  `datainclusao` datetime DEFAULT NULL,
  `dataalteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`idsecretaria`),
  KEY `idusuarioinclusao` (`idusuarioinclusao`),
  KEY `idusuarioalteracao` (`idusuarioalteracao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `sis_secretaria` ---Necessario confirmar os dados da tabela sis_secretaria para o recebimento das solicitacoes dos usuarios---------------- 
--

INSERT INTO `sis_secretaria` (`idsecretaria`, `nome`, `sigla`, `responsavel`, `telefonecontato`, `ativado`, `emailsic`, `siccentral`, `idusuarioinclusao`, `idusuarioalteracao`, `datainclusao`, `dataalteracao`) VALUES(1, 'Nome da secretaria', 'SEMPLA', 'Nome usuario secretario', '32324900', 1, 'usuario@email.com', 1, NULL, NULL, NULL, NULL);
INSERT INTO `sis_secretaria` (`idsecretaria`, `nome`, `sigla`, `responsavel`, `telefonecontato`, `ativado`, `emailsic`, `siccentral`, `idusuarioinclusao`, `idusuarioalteracao`, `datainclusao`, `dataalteracao`) VALUES(2, 'Secretaria exemplo ', 'secretaria', 'Nome responsavel ', '32329121', 1, NULL, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sis_tela`------------ Responsavel pela definicao do diretorio onde os arquviso estao alocados ---- Organizados a partir dos dados da tabelas  sis_usuario, sis_secretaria , lda_configuracao , lda_solicitacao, lda_consulta e lda_tiposolicitacao -------------------------
--

CREATE TABLE IF NOT EXISTS `sis_tela` (
  `idtela` int(5) NOT NULL AUTO_INCREMENT,
  `idmenu` int(5) NOT NULL,
  `pasta` varchar(30) NOT NULL COMMENT 'pasta onde estao os arquivos da tela',
  `nome` varchar(30) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-ativo; 0-inativo',
  `ordem` int(3) NOT NULL DEFAULT '0' COMMENT 'ordem de aparição no menu',
  PRIMARY KEY (`idtela`),
  KEY `idmenu_fk` (`idmenu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=130 ;

--
-- Extraindo dados da tabela `sis_tela`
--

INSERT INTO `sis_tela` (`idtela`, `idmenu`, `pasta`, `nome`, `ativo`, `ordem`) VALUES
(3, 7, 'sis_usuario', 'Usuario', 1, 0),
(16, 7, 'sis_secretaria', 'Cadastro de SIC', 1, 0),
(18, 7, 'sis_grupo', 'Perfil', 1, 0),
(50, 7, 'lda_configuracao', 'Configuração do Sistema', 1, 0),
(126, 45, 'lda_solicitacao', 'Solicitações', 1, 1),
(128, 45, 'lda_consulta', 'Consulta', 1, 2),
(129, 7, 'lda_tiposolicitacao', 'Instâncias', 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sis_usuario` ------ Tabela alocado aos dados dos usuarios apos cadastro -----------------
--

CREATE TABLE IF NOT EXISTS `sis_usuario` (
  `idusuario` int(10) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `matricula` varchar(8) NOT NULL,
  `cpfusuario` varchar(11) NOT NULL,
  `chave` varchar(50) NOT NULL,
  `idsecretaria` int(11) DEFAULT NULL COMMENT 'Identificador da secretaria padrão a que o usuário pertence',
  `idusuarioinclusao` int(10) DEFAULT NULL,
  `idusuarioalteracao` int(10) DEFAULT NULL,
  `datainclusao` datetime DEFAULT NULL,
  `dataalteracao` datetime DEFAULT NULL,
  PRIMARY KEY (`idusuario`),
  KEY `idsecretaria` (`idsecretaria`),
  KEY `idusuarioinclusao` (`idusuarioinclusao`),
  KEY `idusuarioalteracao` (`idusuarioalteracao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 PACK_KEYS=0 AUTO_INCREMENT=17 ;

--
-- Extraindo dados da tabela `sis_usuario`
--

INSERT INTO `sis_usuario` (`idusuario`, `nome`, `login`, `status`, `matricula`, `cpfusuario`, `chave`, `idsecretaria`, `idusuarioinclusao`, `idusuarioalteracao`, `datainclusao`, `dataalteracao`) VALUES
(15, 'Responsável por Responder Solicitações', 'usuario', 'A', '123456', '11111111111', '202cb962ac59075b964b07152d234b70', 1, NULL, 16, NULL, '2014-02-25 16:22:05'),
(16, 'Administrador Geral', 'admin', 'A', '654321', '22222222222', '21232f297a57a5a743894a0e4a801fc3', 1, 15, NULL, '2014-08-05 18:25:04', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sis_usuariosecretaria` ---------------------------Estrutura da tabela sis_usuariosecretariasecretaria -------Aloca os dados do usuario a partir da secretaria ---- Tabela relacionado a sis_secretaria e sis_usuario --------------------------
--

CREATE TABLE IF NOT EXISTS `sis_usuariosecretaria` (
  `idusuario` int(10) NOT NULL,
  `idsecretaria` int(10) NOT NULL,
  KEY `idusuario` (`idusuario`),
  KEY `idsecretaria` (`idsecretaria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `sis_usuariosecretaria`
--

INSERT INTO `sis_usuariosecretaria` (`idusuario`, `idsecretaria`) VALUES(16, 2);
INSERT INTO `sis_usuariosecretaria` (`idusuario`, `idsecretaria`) VALUES(16, 1);

-- --------------------------------------------------------

--
-- Estrutura stand-in para visualizar `lda_enquete`
--
CREATE TABLE IF NOT EXISTS `lda_enquete` (
  `idenquete` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador do registro',
  `resposta` varchar(1) NOT NULL COMMENT 'Reposta da enquete: [R]egular - r[U]im - [B]om - [O]timo',
  `dataresposta` datetime NOT NULL COMMENT 'data da resposta',
  `idsolicitante` int(11) NOT NULL COMMENT 'codigo identificador do solicitante',
  `comentario` varchar(2000) DEFAULT NULL COMMENT 'comentarios do solicitante',
  PRIMARY KEY (`idenquete`),
  KEY `idsolicitante` (`idsolicitante`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Enquete do feedback do solicitante sobre o sistema' AUTO_INCREMENT=1 ;
-- ----------------------------------



--
-- Estrutura para visualizar `vw_secretariausuario`
--

CREATE VIEW `vw_secretariausuario` AS select `usu`.`idusuario` AS `idusuario`,`usu`.`idsecretaria` AS `idsecretaria`,`sec`.`sigla` AS `siglasecretaria`,`sec`.`nome` AS `nomesecretaria`,`usr`.`login` AS `login`,`usr`.`nome` AS `nome`,`usr`.`matricula` AS `matricula`,`usr`.`cpfusuario` AS `cpf` from ((`sis_usuariosecretaria` `usu` join `sis_secretaria` `sec` on((`sec`.`idsecretaria` = `usu`.`idsecretaria`))) join `sis_usuario` `usr` on((`usr`.`idusuario` = `usu`.`idusuario`))) union select `usr`.`idusuario` AS `idusuario`,`usr`.`idsecretaria` AS `idsecretaria`,`sec`.`sigla` AS `siglasecretaria`,`sec`.`nome` AS `nomesecretaria`,`usr`.`login` AS `login`,`usr`.`nome` AS `nome`,`usr`.`matricula` AS `matricula`,`usr`.`cpfusuario` AS `cpf` from (`sis_usuario` `usr` join `sis_secretaria` `sec` on((`sec`.`idsecretaria` = `usr`.`idsecretaria`)));

--
-- Restrições para as tabelas dumpadas ---- Mantendo modelo original 
--

--
-- Restrições para a tabela `lda_anexo`
--
ALTER TABLE `lda_anexo`
  ADD CONSTRAINT `lda_anexo_ibfk_1` FOREIGN KEY (`idsolicitacao`) REFERENCES `lda_solicitacao` (`idsolicitacao`),
  ADD CONSTRAINT `lda_anexo_ibfk_2` FOREIGN KEY (`idusuarioinclusao`) REFERENCES `sis_usuario` (`idusuario`);

--
-- Restrições para a tabela `lda_movimentacao`
--
ALTER TABLE `lda_movimentacao`
  ADD CONSTRAINT `lda_movimentacao_ibfk_1` FOREIGN KEY (`idsecretariaorigem`) REFERENCES `sis_secretaria` (`idsecretaria`),
  ADD CONSTRAINT `lda_movimentacao_ibfk_2` FOREIGN KEY (`idusuarioenvio`) REFERENCES `sis_usuario` (`idusuario`),
  ADD CONSTRAINT `lda_movimentacao_ibfk_3` FOREIGN KEY (`idsecretariadestino`) REFERENCES `sis_secretaria` (`idsecretaria`),
  ADD CONSTRAINT `lda_movimentacao_ibfk_4` FOREIGN KEY (`idusuariorecebimento`) REFERENCES `sis_usuario` (`idusuario`),
  ADD CONSTRAINT `lda_movimentacao_ibfk_5` FOREIGN KEY (`idsolicitacao`) REFERENCES `lda_solicitacao` (`idsolicitacao`);

--
-- Restrições para a tabela `lda_solicitacao`
--
ALTER TABLE `lda_solicitacao`
  ADD CONSTRAINT `lda_solicitacao_ibfk_8` FOREIGN KEY (`idsecretariaresposta`) REFERENCES `sis_secretaria` (`idsecretaria`),
  ADD CONSTRAINT `lda_solicitacao_ibfk_1` FOREIGN KEY (`idsolicitante`) REFERENCES `lda_solicitante` (`idsolicitante`),
  ADD CONSTRAINT `lda_solicitacao_ibfk_2` FOREIGN KEY (`idtiposolicitacao`) REFERENCES `lda_tiposolicitacao` (`idtiposolicitacao`),
  ADD CONSTRAINT `lda_solicitacao_ibfk_3` FOREIGN KEY (`idsolicitacaoorigem`) REFERENCES `lda_solicitacao` (`idsolicitacao`),
  ADD CONSTRAINT `lda_solicitacao_ibfk_4` FOREIGN KEY (`idusuariorecebimento`) REFERENCES `sis_usuario` (`idusuario`),
  ADD CONSTRAINT `lda_solicitacao_ibfk_5` FOREIGN KEY (`idusuarioprorrogacao`) REFERENCES `sis_usuario` (`idusuario`),
  ADD CONSTRAINT `lda_solicitacao_ibfk_6` FOREIGN KEY (`idusuarioresposta`) REFERENCES `sis_usuario` (`idusuario`),
  ADD CONSTRAINT `lda_solicitacao_ibfk_7` FOREIGN KEY (`idsecretariaselecionada`) REFERENCES `sis_secretaria` (`idsecretaria`);

--
-- Restrições para a tabela `lda_solicitante`
--
ALTER TABLE `lda_solicitante`
  ADD CONSTRAINT `lda_solicitante_ibfk_1` FOREIGN KEY (`idtipotelefone`) REFERENCES `lda_tipotelefone` (`idtipotelefone`),
  ADD CONSTRAINT `lda_solicitante_ibfk_2` FOREIGN KEY (`idescolaridade`) REFERENCES `lda_escolaridade` (`idescolaridade`),
  ADD CONSTRAINT `lda_solicitante_ibfk_3` FOREIGN KEY (`idfaixaetaria`) REFERENCES `lda_faixaetaria` (`idfaixaetaria`);

--
-- Restrições para a tabela `lda_tiposolicitacao`
--
ALTER TABLE `lda_tiposolicitacao`
  ADD CONSTRAINT `lda_tiposolicitacao_ibfk_1` FOREIGN KEY (`idtiposolicitacao_seguinte`) REFERENCES `lda_tiposolicitacao` (`idtiposolicitacao`);

--
-- Restrições para a tabela `sis_acao`
--
ALTER TABLE `sis_acao`
  ADD CONSTRAINT `sis_acao_ibfk_1` FOREIGN KEY (`idtela`) REFERENCES `sis_tela` (`idtela`);

--
-- Restrições para a tabela `sis_grupo`
--
ALTER TABLE `sis_grupo`
  ADD CONSTRAINT `sis_grupo_ibfk_1` FOREIGN KEY (`idusuarioinclusao`) REFERENCES `sis_usuario` (`idusuario`),
  ADD CONSTRAINT `sis_grupo_ibfk_2` FOREIGN KEY (`idusuarioalteracao`) REFERENCES `sis_usuario` (`idusuario`);

--
-- Restrições para a tabela `sis_grupousuario`
--
ALTER TABLE `sis_grupousuario`
  ADD CONSTRAINT `sis_grupousuario_ibfk_1` FOREIGN KEY (`idgrupo`) REFERENCES `sis_grupo` (`idgrupo`),
  ADD CONSTRAINT `sis_grupousuario_ibfk_2` FOREIGN KEY (`idusuario`) REFERENCES `sis_usuario` (`idusuario`);

--
-- Restrições para a tabela `sis_permissao`
--
ALTER TABLE `sis_permissao`
  ADD CONSTRAINT `sis_permissao_ibfk_1` FOREIGN KEY (`idacao`) REFERENCES `sis_acao` (`idacao`),
  ADD CONSTRAINT `sis_permissao_ibfk_2` FOREIGN KEY (`idgrupo`) REFERENCES `sis_grupo` (`idgrupo`);

--
-- Restrições para a tabela `sis_secretaria`
--
ALTER TABLE `sis_secretaria`
  ADD CONSTRAINT `sis_secretaria_ibfk_1` FOREIGN KEY (`idusuarioinclusao`) REFERENCES `sis_usuario` (`idusuario`),
  ADD CONSTRAINT `sis_secretaria_ibfk_2` FOREIGN KEY (`idusuarioalteracao`) REFERENCES `sis_usuario` (`idusuario`);

--
-- Restrições para a tabela `sis_tela`
--
ALTER TABLE `sis_tela`
  ADD CONSTRAINT `sis_tela_ibfk_1` FOREIGN KEY (`idmenu`) REFERENCES `sis_menu` (`idmenu`);

--
-- Restrições para a tabela `sis_usuario`
--
ALTER TABLE `sis_usuario`
  ADD CONSTRAINT `sis_usuario_ibfk_1` FOREIGN KEY (`idsecretaria`) REFERENCES `sis_secretaria` (`idsecretaria`),
  ADD CONSTRAINT `sis_usuario_ibfk_2` FOREIGN KEY (`idusuarioinclusao`) REFERENCES `sis_usuario` (`idusuario`),
  ADD CONSTRAINT `sis_usuario_ibfk_3` FOREIGN KEY (`idusuarioalteracao`) REFERENCES `sis_usuario` (`idusuario`);

--
-- Restrições para a tabela `sis_usuariosecretaria`
--
ALTER TABLE `sis_usuariosecretaria`
  ADD CONSTRAINT `sis_usuariosecretaria_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `sis_usuario` (`idusuario`),
  ADD CONSTRAINT `sis_usuariosecretaria_ibfk_2` FOREIGN KEY (`idsecretaria`) REFERENCES `sis_secretaria` (`idsecretaria`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
