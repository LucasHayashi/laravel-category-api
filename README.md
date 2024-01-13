# Laravel Category API

Este é um projeto simples em Laravel que fornece uma API para o cadastro de categorias. A API é protegida pelo Sanctum para garantir a autenticação e autorização adequadas.

## Recursos

- Listagem, criação, atualização e exclusão de categorias.
- Autenticação via token utilizando Sanctum.
- Proteção de rotas com base nas habilidades do token.
- Rota para obter informações do usuário logado.
- Rota para login e registro de usuários.

## Rotas Disponíveis

### Categorias

- **GET** `/api/categories`: Lista todas as categorias.
- **POST** `/api/categories`: Cria uma nova categoria.
- **PUT** `/api/categories/{id}`: Atualiza uma categoria existente.
- **DELETE** `/api/categories/{id}`: Exclui uma categoria (requer habilidade 'delete' no token).

### Usuário

- **GET** `/api/user`: Obtém informações do usuário logado.

### Autenticação

- **GET** `/api/login`: Obtém um token de acesso.
- **POST** `/api/register`: Registra um novo usuário.

## Instalação

1. Clone o repositório.
2. Execute `composer install` para instalar as dependências.
3. Configure o arquivo `.env` com as informações do banco de dados e outras configurações.
4. Execute `php artisan migrate` para criar as tabelas do banco de dados.
5. Execute `php artisan serve` para iniciar o servidor de desenvolvimento.

## Como Usar

1. Registre um novo usuário usando a rota `/api/register`.
2. Faça login usando a rota `/api/login` para obter um token.
3. Use o token para autenticar as requisições para as rotas protegidas.