# lenspector

Web application allowing to manage products such as intraocular lenses. This web app is a fork from a previous project which was not using a PHP famework.

## Main targets

* Create model for protucts and products type from the database
* Show models' content
* user login
* Show different inventories from models (on hands, remote and sold)
* Update products status:
    * Moving newly created products into the on hands inventory
    * Moving products to remote/sold inventory
* Create a new order

More functionnalities will be added depending on how much time left we have.

## Technologies that might be used

* Laravel/Lumen (lesson constraint)
* Angular2 (if needed for the frontend)

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

Do not forget to give access to the project to the http user so that it can access project `bootstrap/cache` and `storage` directories. You can use `setfacl` to achieve this task.
