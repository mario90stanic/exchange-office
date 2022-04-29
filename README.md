# Exchange office test project
**Version 1.0.0**
---

## Technologies on this project:
- [PHP](https://www.php.net/) 8.0.10
- [Lando](https://lando.dev/) 3.0.26 for server 
- [Laravel](https://laravel.com) 9.9.0 server side backend
- [MySQL](https://www.mysql.com/) 14.14 for database
- [Vue.js](https://vuejs.org/) 3.2.33 client side

## Using Lando
- Lando (and docker) needs to be installed on a local machine
- Open terminal in the root folder of the project and type `lando start` 
- When finish in the terminal you will see links to the app

## Starting the project
- When you boot up the server, you need to trigger migrations and seeding of the database with command `lando artisan db:migrate --seed`
- This will create database 

## Triggering tests
- Project contains feature tests
- You can trigger test with typing a command in the terminal `lando artisan tests` 

---
## Contributors
- Mario Stanic <mario90stanic@gmail.com>
