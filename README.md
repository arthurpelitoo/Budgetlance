<h1 align="left">Budgetlance</h1>

###

<h3 align="left">Site feito em PHP, para permitir que o usuario(aqui como um freelancer) organize seu serviço, orçamento e clientes.</h3>

###

<h1 align="left">Requisitos:</h1>

###

* PHP:
    * Versão: idealmente PHP 8.0 ou superior
 * Extensões necessárias:
    * pdo_mysql (para conexão com MySQL via PDO).

* MySQL:
    * Versão: 5.7 ou superior.

* Composer:
    * Versão: 2.x

###

<h1 align="left">Depêndencias Externas:</h1>

###

* Pacotes do Composer:

    * vlucas/phpdotenv. (libs de apoio dele: phpoption/phpoption, graham-campbell/result-type, symfony/polyfill-*)

* Font Awesome (ícones no front).

* AJAX no JavaScript (nativo, não precisa de jQuery).

* POO em PHP (arquitetura MVC + Hydrator + DAO + Controllers).

###

<h1 align="left">Estrutura de Pastas:</h1>

###

* Config/ → as rotas, classes de erro personalizado, de rota(para aceitar mais de dois tipos de requisições http) e de sanitização

* Controller/ → lógica de controle.

* Dao/ → acesso a banco.

* Model/ → entidades e regras de negócio.

* Hydrator/ → transformação de dados (DB ↔ objetos).

* View/ → templates renderizados.

* Public/ → arquivos estáticos (css, js, imagens).

* vendor/ → dependências do Composer.

###

<h1 align="left">Instruções de instalação e execução:</h1>

###

* dê um git clone no projeto:

    * (passe esse comando) git clone https://github.com/arthurpelitoo/Budgetlance

* vá na database, copie o dump do arquivo .sql e lance pro seu banco de dados recuperar e trazer.

* vá no .env.example, retire o .example do nome do arquivo e adicione a sua porta do MySql nele.

* rode esse comandinho bacanudo do composer para garantir que tudo dê certo:

    * composer dump-autoload

* agora é só rodar o campeão aí:

    * php -S localhost:8000 -t Public

* só entrar na porta 8000 no localhost do seu navegador preferido e ser feliz.

###

<h1 align="left">Nome dos integrantes da dupla:</h1>
<h3 align="left">Arthur Antonio de Araujo Pelito</h3>
<h3 align="left">Marcos Vinicius da Silva Rosa</h3>

###

<h1 align="left">Link para o DER ou se preferir vá para a pasta Database com as imagens:</h1>

###

<a href="https://drawsql.app/teams/everyday-gear/diagrams/budgetlance">DER no DrawSql</a>
