## Task Manager APi

A REST API for task management apps.

uses:

* JWT-Auth - [tymondesigns/jwt-auth](https://github.com/tymondesigns/jwt-auth)
* Dingo API - [dingo/api](https://github.com/dingo/api)
* Laravel-CORS [barryvdh/laravel-cors](http://github.com/barryvdh/laravel-cors)
* Codeception [codeception](http://codeception.com/)

## Installation

```bash
$ composer install
$ php artisan key:generate
$ cp .env.example .env
```

Fill in .env file

## Dev

```bash
$ php artisan serve
```

## Testing setup

```bash
$ cp .env.testing.example .env.testing
$ cp tests/api.suite.yml.example tests/api.suite.yml
$ vendor/codeception/codeception/codecept build
```
Fill in .env.testing file

## Running tests

```bash
$ vendor/codeception/codeception/codecept run
```

## Laravel5Extension

This extension does the following: 
 - automatically creates sqlite db if required before the tests run
 - migrates / remigrates the database
 - seeds the database (seeds are environment specific)

Make this extension is enabled in codeception.yml
and that:
 - db_connection matches DB_CONNECTION in .env.testing
 - db_sqlite_database matches DB_SQLITE_DATABASE in .env.testing