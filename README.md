# Transação API

Um sistema simples para gerenciamento de transações e usuários. Este projeto permite a criação de usuários, autenticação de login e o registro de transações financeiras. Ideal para quem precisa de uma solução leve para controlar suas movimentações financeiras de forma prática e eficiente.


## Índice

- [Características](#características)
- [Tecnologias Utilizadas](#tecnologias-utilizadas)
- [Instalação](#instalação)
- [Como Testar](#como-testar)
- [Documentação](#documentação-api)
  - [Autenticação](#autenticação)
  - [Login](#login)
  - [Criação de usuários](#criação-do-usuário)
  - [Criação de transações](#criação-de-transação)
- [Autores](#autores)

## Características

lista das principais funcionalidades do projeto.
- Criação de usuários
- Login de usuários
- Criação de transações
- Envio de email de notificação ao realizar uma transação

## Tecnologias Utilizadas

- Symfony 7
- Docker
- Postgres
- RabbitMQ
- Nginx

## Instalação

Instruções passo a passo para configurar o projeto localmente.

```bash
# Clone o repositório
git clone https://github.com/lucas-dantas10/pdi-api.git

# Acesse o diretório do projeto
cd nome-do-projeto

# Configure o arquivo .env
cp .env.example .env

# Suba os containers Docker
sudo docker compose up -d

# Instale as dependências
sudo docker compose exec app composer install
```

## Como Testar

Para testar o projeto, basta utilizar o comando abaixo:

```bash
sudo docker compose exec app php bin/phpunit
```

Caso queira testar um teste específico, basta utilizar o comando abaixo:

```bash
sudo docker compose exec app php bin/phpunit --group <nome-do-grupo>
```

O nome do grupo fica em cima da classe de teste, vai ter algo desse tipo:

```php
  /**
   * @group test
   */
  class CreateSomethingTest extends TestCase
  {
  }
```

## Documentação API

Para informações mais detalhadas sobre os endpoints o projeto possui uma docmentação com swagger, para ser acessada é só adicionar na url:
```plaintext
http://localhost:8000/doc/swagger
```

### Autenticação

A autenticação é feita via token. Após o login, um token JWT será retornado e deve ser incluído no cabeçalho de todas as requisições subsequentes.

```plaintext
Authorization: Bearer <token>
```

### Login
O login é feito passando as credenciais do usuário e retornando um token.

#### endpoint: POST /api/v1/login

```json
{
  "username": "lucas@example.com",
  "password": "123"
}
```

### Criação do usuário
A criação do usuário é feita passando as credenciais do novo usuário e inserindo no banco de dados.

#### endpoint: POST /api/v1/create/user

```json
{
  "full_name": "teste full",
  "email": "teste.full@example.com",
  "password": "12345",
  "cpf": "09567489302",
  "user_type": 1 // 1 = comum, 2 = lojista
}
```

### Criação de transação
A criação de uma transação é feita passando as informações do valor a ser enviado, o pagador e o recebedor.

#### endpoint: POST /api/v1/create/transaction

```json
{
  "value": 10,
  "payer": 1 // identificador do pagador,
  "payee": 2 // identificador do recebedor
}
```

## Autores

- Lucas Dantas - [GitHub](https://github.com/lucas-dantas10)

