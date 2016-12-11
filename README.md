# lenspector

Web application allowing to manage products such as intraocular lenses. This web app is a fork from a previous project which was not using a PHP famework.

![Master branch StyleCI status](https://styleci.io/repos/69327879/shield?style=flat&branch=master)

## Installation

From this point, we assume you have a working Web server with PHP and a http server (nginx, apache, etc.) installed and configured.

### Windows

* Run `git clone <project_url>`
* Run `composer install` at the project root
* Copy the `.env.example` file to `.env`
* Run `php artisan key:generate`

### GNU/Linux

* Run `git clone <project_url>`
* Run `composer install` at the project root
* Copy the `.env.example` file to `.env`
* Run `php artisan key:generate`

Do not forget to give access to the project to the http user so that it can access project `bootstrap/cache` and `storage` directories. You can use `setfacl` to achieve this task:

```bash
$ setfacl -Rdm u:http:wrx storage
$ setfacl -Rdm u:http:wrx bootstrap/cache
```

The http server user might not be called `http` depending on your distribution. Use process monitoring tools like `top` or `ps aux | grep 'nginx\|php\|apache'` to find what is its name.

### General

After installing and generating your key with `artisan`, it is time to create the database:

1. Modify the following lines according to your database server configuration in your `.env` file:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1       
    DB_PORT=3306
    DB_DATABASE=your_db_name
    DB_USERNAME=your_db_username
    DB_PASSWORD=your_db_password
    ```
2. Connect to your database server and create a database with a command like `CREATE DATABASE my_database;`
3. Create the database's tables with `php artisan migrate`.

You can run `php artisan migrate:rollback` if you want to drop the tables for some reason. *As for the database is concerned, you have to drop the schema manually.*

If you want to rollback the database and fill it with fake datas for development, just run `php artisan migrate:refresh --seed`. Then you are ready to test and develop features on the application.
