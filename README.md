## Install packages

`composer install`

## Start DB

`docker-compose up -d`

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
