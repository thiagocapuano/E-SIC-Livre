# e-SIC Livre 2.0

Original disponivel em https://softwarepublico.gov.br/gitlab/e-sic-livre/e-sic-livre/commits/master
Informações do software original disponivel em https://softwarepublico.gov.br/social/e-sic-livre

# Diferenciais 
No momento trata-se de uma versão de adaptação e compatibilidade com versões do PHP >= 7
Não houveram alterações incrementais

# Instalação
Após depositar todo o conteúdo no servidor, acesse pela barra de endereço do navegador de sua preferência a pasta instalar (ex. www.seudominio.com.br/instalar) e preencha o formulário de acordo com as indicações de sua hospedagem ou as configurações definidas para os serviços de banco de dados e email.

# Configurações Iniciais
Acesse o painel administrativo, no menu lateral esquedo acesse administração > configuração do sistema.
Em "E-mail do remetente para envio de e-mails pelo sistema:" defina o mesmo e-mail utilizado na instalação.

Para "Diretório onde será armazenado os anexos do sistema:" caso não conheça o caminho fisico no servidor, siga o procedimento a seguir:
1- Crie ou acesse diretorio no servidor para repositório de anexos.
2- Crie um arquivo qualquer php (ex. index.php).
3- Digite a seguinte linha <?php echo __DIR__ ;?> e salve o arquivo.
4- Acesse pelo navegador o respectivo arquivo (ex. https://www.seuportal.gov.br/esic/anexos/index.php )
5- Copie e cole no campo o endereço fisico apresentado.
6- Adicione uma barra no final do endereço fisico "/" .
7- Exclua o arquivo criado.

Para "URL de acesso aos anexos do sistema:" utilize o caminho especificado do diretório (ex. https://www.seuportal.gov.br/esic/anexos/)

Inicie os testes criando cadastrando solicitante (verifique se o email de confirmação não entrou na caixa de spam), efetue uma solicitação de informação sem envio de arquivo anexo, e outra com envio de anexo).
Demais configurações são definições organicas variaveis de orgão para orgão.


# OBS 1

O banco de dados utilizam de recursos onde requer a liberação de IP externo, para testes iniciais de utilização convém efetuar a a configuração de acesso de qualquer IP ao banco de dados (%), e quando os testes forem concluidos, configurar exclusivamente o IP externo que fará as execuções. Isso se deve que o banco de dados e o site venham a possuir diferentes endereçamentos, permitindo assim que determinado código execute um comando e outro não por estarem em diferentes redes.


# OBS 2

Em alguns casos, onde a hospedagem exigir, será necessário alterar nos arquivos security.php nas linha que se encontra o senguinte código:
mail($to, $subject, $html, $headers, $from)
para:
mail($to, $subject, $html, $headers, "-r" . $from)

