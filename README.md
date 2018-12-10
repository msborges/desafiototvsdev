# Desafio Fullstack TOTVS

Projeto do desafio TOTVS Fullstack - https://gist.github.com/filipenonato/d164521dba961bc800acc4b2ad0bf944

Para desenvolvimento da API REST foi utilizado o PHP7.1 e o framework Slim na versão 3.11.0, isso sendo gerenciado pelo gerenciador de dependências do PHP, o Composer.
Montamos todas as rotas REST necessárias para o sistema de leilões, com as tratativas da regra de negócio diretamente na API. Para armazenamento dos dados foi modelado um banco de dados em MySQL 8.0.12.
A aplicação alimentada pela API REST foi criada utilizando Angular.js, Bootstrap, TypeScript e Node.js.

## Pré-Requisitos:

São necessários os seguintes requisitos para a aplicação rodar em um servidor:

- API REST:    
    - Apache
    - PHP7 ou superior
    - [Composer](https://getcomposer.org/)
        - Slim Framework (depende do Composer - já está pré configurado no composer.json da pasta do projeto)
    - [MySQL 8.0 ou superior](https://dev.mysql.com/downloads/mysql/)
        - Para facilitar a visualização e aplicação da base de dados do projeto no MySQL pode-se utilizar o
        [MySQL Workbench](https://dev.mysql.com/downloads/workbench/)
    - [POSTMAN](https://www.getpostman.com/apps) ou qualquer outro programa para executar as URL's.

    - Obrigatório:
        - Necessário instalar o Composer e executar os comandos de [install](https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies) e [update](https://getcomposer.org/doc/01-basic-usage.md#updating-dependencies-to-their-latest-versions) presentes na documentação do mesmo na raiz do projeto, onde se encontra o arquivo composer.json e o arquivo composer.lock
        - Para não ter necessidade de alterações no projeto, ao instalar o MySQL pode-se criar um usuário [msborges] com a senha [root].
        - O arquivo de importação de rotas do Postman encontra-se na raiz do projeto.


- Aplicação FrontEnd:   
    - [Node.js](https://nodejs.org/en/download/)
    - [Angular.js](https://angular.io/)
    - [Bootstrap](https://getbootstrap.com/docs/4.0/getting-started/download/)

## Rotas da API REST:

Foram criadas quatorze rotas REST para o projeto, são elas:

- Métodos GET de Usuários:
    - [Listagem de todos os usuários](http://localhost/desafiototvs/usuarios) Não espera nenhum parâmetro.
    - [Listagem de um usuário por ID](http://localhost/desafiototvs/usuario/{id}) Espera como parâmetro o id do usuário no lugar do {id}.
- Métodos POST de Usuários:
    - [Cadastro de um novo usuário](http://localhost/desafiototvs/usuarios/novo) Espera como parâmetros um JSON com os dados do usuário.
    Realiza a validação do campo e-mail e campo CPF do usuário, em caso de um dos dois ser inválidos retorna uma mensagem na API.
        ```json
        - {
              "nome": "Maicon da Silva Borges",
              "email": "ms.borges@icloud.com",
              "cpf": "06687446932",
              "usuario": "msborges",
              "senha": "123456"
          }
        ```
- Métodos PUT de Usuários:
    - [Alteração de um Usuário por ID](http://localhost/desafiototvs/usuarios/{id}) Espera como parâmetro o id do usuário no lugar do {id} e um JSON com os dados a serem alterados.
    Realiza a validação do campo e-mail, o campo CPF do usuário e se o usuário não está desativado, em caso de um dos três serem inválidos retorna uma mensagem na API.
        ```json
        - {
              "nome": "Maicon Borges",
              "senha": "12345678910"
          }
        ```
    - [Desativação de um usuário por ID](http://localhost/desafiototvs/usuarios/remover/{id}) Espera como parâmetro o id do usuário no lugar do {id}.

- Métodos GET de Leilões:
    - [Listagem de todos os leilões](http://localhost/desafiototvs/leiloes) Não espera nenhum parâmetro.
    - [Listagem de um leilão por ID](http://localhost/desafiototvs/leilao/{id}) Espera como parâmetro o id do leilão no lugar do {id}.
- Métodos POST de Leilões:
    - [Cadastro de um novo leilão](http://localhost/desafiototvs/usuarios/novo) Espera como parâmetros um JSON com os dados do leilão.
    Realiza a validação se o usuário que está criando é administrador, para evitar Injection de dados via URL, em caso de não ser, retorna uma mensagem na API.
        ```json
        - {
              "tbl_usuario_id": 1,
              "tbl_situacao_id": 1,
              "descricao": "Casa Top",
              "valorinicial": "120890.00",
              "dtabertura": "2018-12-20 00:00:00",
              "dtfinalizacao": "2019-01-01 00:00:00",
              "leilativo":1
          }
        ```
- Métodos PUT de Leilões:
    - [Alteração de um leilão por ID](http://localhost/desafiototvs/leiloes/{id}) Espera como parâmetro o id do leilão no lugar do {id} e um JSON com os dados a serem alterados.
    Realiza a validação se o usuário que está criando é administrador e se o leilão não está desativado, em caso de um dos dois ser inválidos retorna uma mensagem na API.
        ```json
        - {
              "tbl_usuario_id": 2,
              "descricao": "Casa Top D+++"
          }
        ```
    - [Desativação de um leilão por ID](http://localhost/desafiototvs/leiloes/remover/{id}) Espera como parâmetro o id do leilão no lugar do {id}.

- Métodos GET de Lances:
    - [Listagem de lances de um leilão por ID](http://localhost/desafiototvs/leilao/lances/{id}) Espera como parâmetro o id do leilão no lugar do {id}. Retorna todos os lances relacionados ao leilão classificados do maior valor para o menor.
- Métodos POST de Lances:
    - [Cadastro de um novo lance por ID do leilão](http://localhost/desafiototvs/leiloes/lances/novo) Espera como parâmetros um JSON com os dados do lance.
    Realiza a validação se o valor do lance é maior que o anterior, se o leilão relacionado não está desativado ou com a data de finalização vencida, caso um dos três for verdadeiro retorna uma mensagem na API.
        ```json
        - {
              "tbl_usuario_id": 1,
              "tbl_leilao_id": 1,
              "valorlance": 205.12
          }
        ```
## Informações Aplicação Angular.js:

- Ainda não aplicada.

## Informações TDD:

- Ainda não aplicada.
