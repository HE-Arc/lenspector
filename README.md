# lenspector

Web application allowing to manage products such as intraocular lenses. This web app is a fork from a previous project which was not using a PHP famework.

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
