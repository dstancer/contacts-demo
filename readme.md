# What is this?

This is an example *Contacts* app for demonstration purposes.

It uses [Laravel](http://www.laravel.com/) 5.7 PHP framework.

## Installation

* Clone the repo
* Run `composer install` to install the app and packages
* Run `composer run-script post-install-init` to setup required files, migrate the database and seed the database
* Optionally you can run the API test `composer run-script test`
* Finally *serve* the app with `php artisan serve --port=8888` (or any other port if you customized `.env` and `.env.testing` files)
* Again optionally, you can run some browser tests `php artisan dusk` 

## Using It

Go to [http://localhost:8888/](http://localhost:8888/) (or your customized port)
 