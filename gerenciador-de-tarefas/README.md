# Gerenciador de tarefas 

## Descrição

O **Gerenciador de tarefas** é uma API REST projetada para facilitar a organização e o acompanhamento de tarefas individuais. Com recursos robustos de autenticação e controle de acesso, a API permite que cada usuário gerencie suas próprias tarefas de forma segura e eficiente


## Funcionalidades

- **Autenticação**: Autenticação por login e senha.
- **CRUD de usuários**: Criação, exibição, atualização e deleção
- **Paginação**: Listagens de todos os usuário ou todas as tasks do usuário logado com paginação de 20 itens por página
- **Gerenciamento de Tarefas**: Criação, edição e remoção de tarefa e funcionalidade de marcar tarefa como concluida.

- **Controle de Acesso a tarefas**: O usuário está relacionado as suas tarefas, não tendo acesso as tarefas de outro usuário.

## Tecnologias Utilizadas

- PHP, Laravel, Jwt auth

## Instalação

1. Clone o repositório:

    ```sh
    gh repo clone DanielAndradeVP/practical-test
    ```

2. Entre no diretório do projeto:

    ```sh
    cd practical-test/gerenciador-de-tarefas 
    ```

3. Instale as dependências do Composer:

    ```sh
    composer install
    ```

4. Configure o arquivo de ambiente:

    ```sh
    cp .env.example .env
    ```
5. Gere a chave da aplicação:

    ```sh
    php artisan key:generate
    ```

6. Configure o banco de dados no arquivo `.env`.


7. Execute as migrações:

    ```sh
    php artisan migrate
    ```



8. Inicie o servidor:

    ```sh
    php artisan serve
    ```

9. Baixe o arquivo de importação para configuração de rotas no endereço: [https://drive.google.com/drive/folders/1VmsiSsRvs1DTElj6f80FYxpCkumr5OLt?hl=pt-br&q=sharedwith:public%20parent:1VmsiSsRvs1DTElj6f80FYxpCkumr5OLt](https://drive.google.com/drive/folders/1VmsiSsRvs1DTElj6f80FYxpCkumr5OLt?hl=pt-br&q=sharedwith:public%20parent:1VmsiSsRvs1DTElj6f80FYxpCkumr5OLt).




#### OBS: Se desejar criar um usuário utilizando a linha de comando execute :

```sh
php artisan app:setup
```

Este comando cria um usuário com as seguintes credenciais
- login: user@email.com
- Password: Dev123@
