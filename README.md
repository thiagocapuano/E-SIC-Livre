# e-SIC Livre 2.0

Original disponivel em https://softwarepublico.gov.br/gitlab/e-sic-livre/e-sic-livre/commits/master
Informações do software original disponivel em https://softwarepublico.gov.br/social/e-sic-livre

# Diferenciais 
No momento trata-se de uma versão de adaptação e compatibilidade com versões do PHP >= 7
Não houveram alterações incrementais

# Instalação
Após depositar todo o conteúdo no servidor, acesse pela barra de endereço do navegador de sua preferência a pasta instalar (ex. www.seudominio.com.br/instalar) e preencha o formulário de acordo com as indicações de sua hospedagem ou as configurações definidas para os serviços de banco de dados e email.

# OBS 1

O banco de dados utilizam de recursos onde requer a liberação de IP externo, para testes iniciais de utilização convém efetuar a a configuração de acesso de qualquer IP ao banco de dados (%), e quando os testes forem concluidos, configurar exclusivamente o IP externo que fará as execuções. Isso se deve que o banco de dados e o site venham a possuir diferentes endereçamentos, permitindo assim que determinado código execute um comando e outro não por estarem em diferentes redes.


# OBS 2

Em alguns casos, onde a hospedagem exigir, será necessário alterar nos arquivos security.php nas linha que se encontra o senguinte código:
mail($to, $subject, $html, $headers, $from)
para:
mail($to, $subject, $html, $headers, "-r" . $from)

