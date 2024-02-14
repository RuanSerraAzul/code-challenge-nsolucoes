<h1 align="left">Code-challenge N Soluções </h1>

<p align="left">Este projeto é um CRUD, que usa Laravel e MySQL, para realizar operações com dados de usuarios, onde o operador usúario autenticado, que realiza os processos de criar, editar, Usuarios.</p>

<!--ts-->

-   [Sobre](#Sobre)
-   [Instalação](#instalacao)
-   [Como usar](#como-usar)

## Sobre

Este projeto é um code challenge para a vaga de emprego de Desenvolvedor PHP Pleno na empresa N Soluções.<br>
Optei por usar o Laravel, pela sua forte documentação, o que facilita na sua resolução de problemas, além de gostar bastante da sua organização, do padrão de arquitetura MVC, das suas várias ferramentas que facilitam bastante a escrita do código, e também na descrição da vaga pede conhecimento em alguns frameworks, e Laravel é o principal desses.<br>
Como banco de dados usei o MySQL, pois era uma das exigências do code challenge. O que tornou o desenvolvimento mais fácil, pois já possuo conhecimento em MySQL<br>

## Instalação

### Requisitos

-PHP 8.1 ou superior

-MySQL

-Composer

-(Uma build pré-configurada como o XAMPP pode facilitar muito o trabalho, podendo ser instalado apenas o XAMPP e o Composer)

-NPM

### Como instalar

Baixe este projeto e o descompacte.<br>

Navegue até o diretório do projeto e use<br>
**composer install**

Copiamos o .env.example como nosso .env principal<br>
**cp .env.example .env**

Não podemos esquecer de colocar a senha do nosso servidor no nosso arquivo .env<br>

Agora dentro do nosso MySQL rodaremos o comando para criar o BD (é importante estar logado como root)<br>
**mysql:>CREATE DATABASE nsolucoes;**

Rodaremos as nossas migrations para criar as tabelas do nosso banco de dados (foi incluída uma base de dados com 100 usuarios para testes).<br>
**php artisan migrate --seed**

Agora podemos rodar o nosso servidor com nossa REST API usando: <br>
**php artisan serve**

Instalaremos os node_modules usando: <br>
**npm install && npm run build**

Acessaremos a aplicação na rota localhost:8000 e colocaremos as seguintes credenciais:<br>
**Email: admin@admin.com.br**
**Senha: admin**

