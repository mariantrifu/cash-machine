## Install packages

`composer install`

## Start DB

`docker-compose up -d`

## Copy env for DB setup

`copy .env.example .env`

## Migrate DB

`php artisan migrate`

## Start App

`php artisan serve`

## Run PHP QA tools: phpcs, phpmd, phpstan

`composer phpcs` <br>
`composer phpmd` <br>
`composer phpstan`

## Run unit tests with coverage

`php artisan test --coverage`

## Or unit tests with coverage html report

`./vendor/bin/phpunit --coverage-html reports/ `
