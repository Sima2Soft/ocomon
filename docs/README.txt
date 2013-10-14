#
# OcoMon - vers�o 2.0 Alpha1
# Data: Maio de 2007
# Autor: Fl�vio Ribeiro (flavio@unilasalle.edu.br)
#
# Lince�a: GPL
#

Requisitos:
    * Servidor Web (preferencialmente Apache);
    * Linguagem: PHP vers�o: >= 4.3x, HTML, CSS, Javascript;
    * Banco de dados: MySQL vers�o: >= 4.1x;

Notas importantes:

    * Para o sistema funcionar adequadamente � necess�rio que seu navegador permita que sistema rode fun��es
		javascript e aceite cookies do sistema.
    * Para a visualiza��o dos gr�ficos � necess�rio que o PHP esteja compilado com suporte � biblioteca GD;
    * Para o upload de arquivos � necess�rio que essa propriedade esteja habilitada no arquivo de configura��es do PHP (php.ini);
    * Para que o sistema envie e-mails ser� necess�rio ter um servidor SMTP interno para possibilitar essa funcionalidade;
    * Recomendo fortemente que o sistema seja utilizado com o navegador Firefox, onde o mesmo � largamente testado. H� v�rios problemas conhececidos relacionados ao uso do Ocomon no Internet Explorer.
    * Ap�s instalar o sistema, � recomendado que voc� remova a pasta install.


Instala��o (considerando que voc� ainda n�o tenha o Ocomon instalado)
==========

Copiar o diret�rio 'ocomon' para o seu web server (/usr/local/apache2/htdocs/ usualmente no FreeBSD ou var/www/htdocs, em sistemas Linux com Apache).
As permiss�es dos arquivos podem ser as default do seu servidor, apenas o diret�rio /includes/logs deve ter permiss�o de escrita
para todos os usu�rios, pois � o diret�rio onde s�o gravados os arquivos de log do sistema.


Criar um novo banco de dados no MySQL e nome�-lo: 'ocomon'
Dentro do diret�rio do MYSQL no seu servidor digite:
mysql -u USERNAME -p create database ocomon

Para a cria��o das tabelas, voc� precisa apenas rodar um �nico arquivo SQL para popular a base do sistema:
o arquivo �: DB_OCOMON_2.0_FULL.sql (em ocomon/install/2.0/)

Voc� pode executar o script �cima atrav�s do pr�prio mysql (seguindo o mesmo procedimento citado abaixo) ou atrav�s de qualquer
gerenciador gr�fico como o phpMyAdmin por exemplo.

Voc� tamb�m pode rodar o script citado da seguinte forma:
Dentro do diret�rio do MYSQL no seu servidor digite:
mysql -uUSERNAME -p DATABASENAME < DB_OCOMON_2.0_FULL.sql (considerando que o script est� dentro do diret�rio do mysql)

Onde:
	USERNAME=nome do usu�rio "root" do MySQL
	DATABASENAME=nome do banco de dados criado para receber os dados do Ocomon (se voc� escolher um nome
		     diferente de "ocomon", n�o esque�a de alterar no arquivo includes/config.inc.php
	Voc� dever� digitar a senha de root para iniciar a execu��o dos scripts.


Atualiza��o (considerando que voc� j� tenha a vers�o 1.40 instalada em seu ambiente)
==============

A atualiza��o da vers�o do Ocomon 1.40 para a vers�o 2.0 � bastante simples, bastando sobreescreever todos os scripts do sistema e atualizar a base de dados. Para isso, recomendo que seja feito da seguinte forma:

1 - Crie um backup do seu banco de dados do ocomon, essa � uma medida preventiva e sempre recomendada. Assim, em caso de problemas durante a atualiza��o ser� poss�vel retornar o banco no seu est�gio anterior (funcionando!).

2 - Dentro do pacote 2.0 do Ocomon, h� um script de atualiza��o da base 1.40 para a base 2.0. Acesse esse arquivo em ocomon/install/2.0/UPDATE_FROM_1.40_TO_2.0.SQL (� recomend�vel que voc� importe esse arquivo utilizando o phpMyAdmin, sendo assim, nas op��es de importa��o selecione "latin1" para o conjunto de caracteres do arquivo).

3 - Renomeie (n�o delete) a pasta ocomon (que est� instalado no seu ambiente). Essa � uma medida de seguran�a caso voc� tenha realizado algum tipo de costumiza��o no sistema, assim n�o perder� seus scripts.

4 - Descompacte o pacote do Ocomon no mesmo diret�rio raiz onde voc� tinha a vers�o 1.40 rodando (que voc� renomeou no passo anterior).

5 - Copie o arquivo config.inc.php da pasta antiga do Ocomon e cole no seu novo ocomon (ocomon/includes/).

Cuidados a serem tomados:
- At� a vers�o 1.40 a defini��o do endere�o do seu site interno para acesso ao Ocomon era no arquivo config.inc.php. Na vers�o 2.0 essa defini��o deve ser feita no menu Admin->Configura��es->Configura��es gerais.


Configura��o
============

As credenciais para conex�o com o banco devem ser informadas no arquivo de configura��o do Ocomon: config.inc.php
voc� n�o conseguir� utilizar o OCOMON at� ter configurado esse arquivo. Para isso � necess�rio criar uma c�pia do arquivo
config.inc.php-dist e renome�-lo para config.inc.php. Quanto � sua configura��o, o arquivo � auto-explicativo. :-)

Iniciando o uso do OCOMON (primeira instala��o):

ACESSO
usu�rio: admin
senha: admin (N�o esque�a de alterar esse senha t�o logo tenha acesso ao sistema!!)

Novos usu�rios podem ser criados no menu ADMIN-USU�RIOS


Infelizmente ainda n�o tive tempo de criar uma documenta��o do sistema, espero conseguir realizar essa tarefa com a ajuda da comunidade de usu�rios :-)

Voc� pode obter maiores informa��es atrav�s dos seguintes meios:
- Lista de discuss�o: http://svrmail.lasalle.tche.br/mailman/listinfo/ocomon-l
- F�rum do sistema: http://softwarelivre.unilasalle.edu.br/ocomon_forum

Espero que esse sistema lhe seja �til e lhe ajude no seu gerenciamento de suporte e equipamentos de inform�tica
da mesma forma que nos ajuda aqui no Unilasalle.

Bom uso!! :)

Fl�vio Ribeiro
flavio@unilasalle.edu.br



=======================
Ocomon 2.0 Alpha1 - Know Issues
=======================

Essa vers�o do Ocomon � uma vers�o Alpha e ainda est� em desenvolvimento, portanto ainda h� uma s�rie de detalhes que precisam ser ajustados at� a libera��o da vers�o 2.0 Final.

Descrevo a seguir as principais situa��es que precisam e dever�o ser ajustadas at� a vers�o 2.0 Final:

- Suporte a m�ltiplos idiomas: essa caracter�stica ainda n�o est� 100% pois ainda existem alguns scripts que n�o est�o com esse suporte.

- Compatibilidade com o Internet Explorer: ainda � necess�rio uma s�rie de ajustes para possibilitar o correto funcionamento nesse navegador. Recomendo fortemente que seja utilizado o navegador Firefox.

- No cadastro de feriados, a op��o "permanente" ainda n�o est� sendo considerada para o c�lculo de horas v�lidas.

- H� tamb�m uma s�rie de detalhes menores que dever�o ser ajustados at� o fechamento da release 2.0.



