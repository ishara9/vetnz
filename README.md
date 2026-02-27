# VetNZ

 Vet project for NZ animals

## Run project using

    php -S localhost:8000 -t public

## Run Test using

    .\vendor\bin\phpunit tests

## Architecture

    Controller -> Service -> Repository -> Database


## Dependencies
- Production ready style dependency included
- Used Slim for proper routing and middleware
- Added dependency injection with

## Dependencies install with following

    composer require slim/slim

    composer require slim/psr7

    composer require php-di/php-di

## Debugging guide

- Install PHP Debug extention in VSCode
- configure .vscode/launch.json with Xdebug
- install Xdebug from https://xdebug.org/wizard

### Add `php.ini` following config under [opcache]
    
    zend_extension="C:\path\to\xdebug.dll"
    xdebug.mode=debug
    xdebug.start_with_request=yes
    xdebug.client_port=9003 

- Now run vscode debug mode with `Run-> Start Debugging (F5)`
- Start Server normally `php -S localhost:8000 -t public`
- Add breakpoints and debug
