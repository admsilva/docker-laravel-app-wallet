# Docker Laravel para uma micro aplicação de carteira

## Componentes

- NGINX (latest)
- MYSQL (latest)
- PHP8.4-FPM-ALPINE (latest)
- COMPOSER (lastest)

## Instalação

1. Obtenha o projeto

```
git clone https://github.com/admsilva/docker-laravel-app-wallet.git
cd docker-laravel-app-wallet
cp .env-example .env
cp ./src/.env.example ./src/.env
docker-compose up -d --build
```

2. Se quiser você pode alterar as variáveis de ambiente no arquivo .env:

```
UID=1000
USER=admsilva
GID=1000
GROUP=admsilva

NGINX_PORT=80
MYSQL_PORT=3306
NPM_PORT=3000

APP_FOLDER=./src
DATABASE_FOLDER=./data
CONFIG_FOLDER=./etc
DOCKER_FILE_FOLDER=./docker

MYSQL_ROOT_PASSWORD=secret
MYSQL_DATABASE=homestead
MYSQL_USER=homestead
MYSQL_PASSWORD=secret
SERVICE_TAGS=dev
SERVICE_NAME=mysql
```

## COMANDOS

* Rodar composer install no projeto
```
docker-compose run --rm composer install
```

* Rodar composer update no projeto
```
docker-compose run --rm composer update
```

* Gerar chave da aplicação
```
docker-compose run --rm artisan key:generate
```

* Para gerar as migrations
```sh
docker-compose run --rm artisan migrate
```

* Para gerar os seeds do banco de dados
```sh
docker-compose run --rm artisan db:seed
```

* Para atualizar a documentação da API
```sh
docker-compose run --rm artisan l5-swagger:generate
```

* Para executar testes da aplicação
```sh
docker-compose run --rm artisan test
```

* Para fazer o reset do banco de dados
```sh
docker-compose run --rm artisan migrate:reset
```

### Acesso 

* A aplicação
```
http://localhost
```

* A Documentação da API
```
http://localhost/api/v1/documentation
```

### MySQL

```
Host: locahost
Port: 3306
User: homestead
Password: secret
```

#### Estrutura de diretórios

```
./
├──┐
│  │ 
│  ├─ data
│  │  │
│  │  └─ database
│  │ 
│  ├─ docker
│  │  │
│  │  └─ composer
|  |  |  |
|  |  |  └─ Dockerfile
|  |  |
│  │  └─ mysql
|  |  |  |
|  |  |  └─ Dockerfile
|  |  |
│  │  └─ nginx
|  |  |  |
|  |  |  └─ Dockerfile
|  |  |
│  │  └─ php
|  |  |  |
|  |  |  └─ Dockerfile
|  |  |
│  ├─ etc
│  │  │
│  │  |─ nginx
|  |  |  |
|  |  |  └─ default.conf
|  |  |  |
|  |  |  └─ nginx.conf
│  │  │
│  │  └─ php-fpm
|  |     |
|  |     └─ www.conf
│  │ 
│  ├─ log
│  │  │
│  │  └─ access & error log
│  │  
│  ├─ src
│  │  │
│  │  └─ Laravel app folder
│  │  
```

#### DOCKER DICAS

* Parar todos os containers
```sh
docker kill $(docker ps -q)
```
* Remover todos os containers
```sh
docker rm $(docker ps -a -q)
```
* Remover todas as imagens
```sh
docker rmi $(docker images -q)
```
* CLI de acesso ao container
```sh
docker-compose exec <name|id> /bin/bash
```