# API Cidadão

API para gestão de cadastro de cidadãos

[Documentação](https://documenter.getpostman.com/view/3825871/UVsSNPef)

## Instalação

Instalação:\
`
$ composer install
`

Copiar o arquivo .env e editar com os dados de conexão com o banco:\
`
$ cp .env.example .env
`

Criação das tabelas no banco de dados:\
`
$ php artisan migrate
`

## Execução

Iniciar o servidor:\
`
$ php artisan serve
`

#### Cadastrar cidadão por comando

Cadastro de cidadão por linha de comando do laravel:\
`
$ php artisan create:cidadao [nome] [sobrenome] [cpf] [email] [telefone] [cep]
`

Exemplo:\
`
$ php artisan create:cidadao joao silva 11122233311 email@example.com 11999999999 01001000
`

## Testes
Rodar os testes:\
`
$ php artisan test
`

obs: Ao rodar os testes os dados anteriores são apagados
