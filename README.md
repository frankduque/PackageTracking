# PackageTracking

Esta é uma aplicação web para rastreamento e acompanhamento de pacotes. Com ela, você pode facilmente acompanhar o status de seus pacotes e as informações relacionadas a eles. Além disso, a aplicação oferece uma API para integração com outros sistemas e automatização de tarefas de rastreamento. Mantendo-se informado sobre o status de seus pacotes de forma rápida e eficiente.

## Conteúdo

1. [Funcionalidades](#funcionalidades)
2. [Instalação](#instalação)
3. [Documentação da API](#documentação-da-api)
4. [Comandos](#comandos)
5. [Autores](#autores)

## Funcionalidades

-  Autenticação de usuários
-  Listagem de pacotes
-  Adição de pacotes
-  Exclusão de pacotes
-  Integração com API externa para rastreamento de pacotes
-  Agendamento de tarefas para atualização automática de pacotes
-  Agendamento de tarefas para exclusão automática de pacotes
-  API REST para gerenciamento de pacotes:
   -  Adicionar pacotes
   -  Listar pacotes
   -  Solicitar atualização única de pacotes

## Instalação

### Requisitos

Para executar este projeto, você precisará das seguintes ferramentas instaladas em seu ambiente de desenvolvimento:

-   **PHP:** Versão 8.2 ou superior.
-   **Composer:** Para gerenciar as dependências PHP do projeto.
-   **Node.js e npm:** Para gerenciar as dependências JavaScript e construir os ativos front-end.
-   **Laravel:** Este projeto foi desenvolvido com Laravel, um framework PHP moderno e poderoso. Certifique-se de verificar os [requisitos de instalação do Laravel](https://laravel.com/docs/installation#server-requirements) para obter mais detalhes.
-   **Banco de dados:** Um banco de dados MySQL, PostgreSQL ou SQLite é necessário para armazenar os dados do aplicativo.

Certifique-se de que todas essas dependências estejam instaladas e configuradas corretamente antes de prosseguir com a instalação do projeto. Para mais detalhes sobre como instalar e configurar o Laravel, consulte a [documentação oficial do Laravel](https://laravel.com/docs).

### Passos de Instalação

1. Clone este repositório:

    ```bash
    git clone https://github.com/frankduque/PackageTracking.git
    ```

2. Navegue até o diretório do projeto:

    ```bash
    cd PackageTracking
    ```

3. Instale as dependências com npm:

    ```bash
    npm install --omit=dev
    ```

4. Instale as dependências do Composer:

    ```bash
    composer install --optimize-autoloader --no-dev
    ```

5. Copie o arquivo `.env.example` para `.env`:

    ```bash
    cp .env.example .env
    ```

6. Configure o arquivo `.env` conforme necessário.

Antes de iniciar o projeto, é necessário configurar o arquivo `.env`. Este arquivo é utilizado para definir as variáveis de ambiente necessárias para a execução do aplicativo.

Aqui estão algumas variáveis de ambiente que você precisa configurar no arquivo `.env`:

-   **Login e senha do usuário padrão:** Defina o login e a senha padrão para o usuário de acesso ao sistema. Essas credenciais podem ser utilizadas para acessar o sistema após a instalação inicial. Esses dados serão usados apenas no primeiro seed de informações no banco de dados, na criação do usuário.
-   **Credenciais da API dos correios:** Aqui é o local apropriado para definir as credenciais de acesso à API.
-   **Detalhes do banco de dados:** Encontre o conjunto de variáveis com o prefixo DB\_ e defina dos dados de acordo com sua instalação do banco de dados.
-   **DAYS_WITHOUT_UPDATE:** Esta variável define a quantidade de dias sem atualização do pacote entregue para exclusão automática do sistema. Certifique-se de ajustar este valor de acordo com os requisitos do seu aplicativo.

Certifique-se de preencher essas informações de acordo com as necessidades do seu projeto antes de iniciar a aplicação.

7. Gere a chave de aplicativo:

    ```bash
    php artisan key:generate
    ```

8. Execute as migrações do banco de dados:

    ```bash
    php artisan migrate
    ```

9. Execute os seeds (criação do usuário):

    ```bash
    php artisan db:seed
    ```

10. Compile os assets do frontend:

    ```bash
    npm run prod
    ```

11. Configure seu servidor web para servir o diretório `public` do aplicativo.

## Documentação da API

Encontre a documentação completa da API [clicando aqui](/API.md)

## Comandos

Para automatizar a execução dos processos de atulização e remoção dos processos foram criados comandos personalizados do Laravel, você pode configurar agendamentos no Crontab do seu servidor. O Crontab é uma ferramenta utilizada no Linux para agendar a execução de tarefas em horários específicos.

### Atualização de Pacotes

Este comando é responsável por atualizar os status de todos os pacotes no sistema.

`php artisan app:update-packages`

Exemplo de utilização:

`0 6 * * * cd /caminho/para/seu/projeto && php artisan app:update-packages `

### Exclusão de Pacotes

Este comando é responsável por excluir os pacotes do sistema que estão a mais de N dias com o status entregue ao cliente (configurável via .env).

`php artisan app:delete-old-delivered-packages`

Exemplo de utilização:

`0 6 * * * cd /caminho/para/seu/projeto && php artisan app:delete-old-delivered-packages `

## Autores

-   [@frankduque](https://github.com/frankduque)
