# mikro-php

## Installation
The easiest way to use Mikro-PHP is by just cloning/forking this repo

It's also available through [Composer](https://getcomposer.org/).

You can edit your composer.json file or just hit this command in your terminal
```
composer require emilianozublena/mikro-php
```
Keep in mind that installing it via composer is for production use, and not for testing. Read the introduction to have more details about this.

## Introduction
Mikro works as a Micro Framework, it uses but its not limited to the following packages:

Eloquent ORM ("illuminate/database": "^5.4")

Symfony's Http Foundation ("symfony/http-foundation": "~3.2")

Zend Framework's Service Manager ("zendframework/zend-servicemanager")

Nikic Fast Route ("nikic/fast-route": "^1.2")

It features a Kernel object that, altogether with the IoC implementation in Service Manager, handles the use of every library/service this micro framework has.

This framework is meant to work under MVC architecture pattern.

If you'd like to use in a different path (or installing it via composer instead of cloning/forking this repo), you should pay attention to the .htaccess file in the root.
This .htaccess redirects ALL traffic to /src where the framework actually is. From there, the .htaccess will use the index.php as the single entry point

## Basic Config
The main and basic configuration for your app is under config/app.php. Here you need to define the access to your database and also the desired baseUrl. This is importante since its used to populate url's inside views.
```
return [
    'baseUrl' => 'http://localhost/mikro',
    'databases' => [
        'config' => [
            'mysql' => [
                'driver'      => 'mysql',
                'host'        => '127.0.0.1',
                'port'        => '3306',
                'database'    => 'mikro',
                'username'    => 'root',
                'password'    => 'root',
                'unix_socket' => '',
                'charset'     => 'utf8',
                'collation'   => 'utf8_unicode_ci',
                'prefix'      => '',
                'strict'      => true,
                'engine'      => null,
            ],
        ]
    ]
];
```

## Service Manager / Container / IoC implementation
This fw works with Zend's Service Manager.
If you need to register a new service/library you can do that in config/services.php
For further use, refer to Zend's Service Manager documentation

## Kernel
This framework gets initialized through its Kernel object. This object handles every request and delivers it to whom it corresponds (may it be a controller, or a closure)
It also is responsible for processing routes, asking the container for the core libraries.
```
$container = (require 'config/services.php');
$kernel = $container->get('kernel');
$kernel->initCore();

require 'config/routes.php';

$kernel->processRoutes();

$kernel->run();
```
The run() method should always be the last thing you call.

## Response
All of the Request's and Response's are handled through HttpFoundation.
This fw comes with a small factory for creating specific responses (html, json, empty, etc)
Comes very handy when you need different responses inside one controller (ie ajax calls and traditional requests)
If you need it, ask for it to the container and then you only have a create() method that returns the desired Response
```
$container = (require 'config/services.php');
$container->get('response');
$exampleResponse = $esponse->create(
    JsonResponse::class,
    ['message' => 'OK!'],
    Response::HTTP_OK
);
```

## Routing
Routes are defined within /config/routes.php. Every route is defined through the Kernel object (previously instantiated by the container inside our entry point)
Methods for defining routes are self explanatory and each one correspond to the main Http Methods.
Router class just handles the adding of routes to a priv property. After that, the kernel may use this router altogether with FastRoute to proper implement the routes
```
$kernel->post('books', [
    '\Mikro\Http\Controllers\Books',
    'store'
]);
$kernel->get('books/{id:\d+}/update', [
    '\Mikro\Http\Controllers\Books',
    'update'
]);
$kernel->put('books/{id:\d+}', [
    '\Mikro\Http\Controllers\Books',
    'put'
]);
$kernel->patch('books/{id:\d+}', [
    '\Mikro\Http\Controllers\Books',
    'patch'
]);
$kernel->match(['PUT', 'PATCH'], 'books/{id:\d+}', [
    '\Mikro\Http\Controllers\Books',
    'patch'
]);
```

## Controllers
Routes define a pattern to be matched and also a handler. The handler is a callable, meaning it can be a closure or a class
As an MVC fw, Mikro comes with a small implementation of Controllers
If you need to create a new controller, you just need to extend its base Controller
Every controller needs to return ALWAYS a valid HttpFoundation Response object.
Response objects may be accessed through the container or the custom Response factory
```
<?php

namespace Mikro\Http\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Home extends Controller
{
    public function index(){
        $response = $this->container->get('response');

        return $response->create(
           JsonResponse::class,
           [
               'message' => 'Some message'
           ],
           Response::HTTP_OK
       );
    }
}
```

## Views
Controllers may return a Json response (if you're handling requests through ajax or putting together a RESTful API this is quite helpful)
But it also may return plain HTML.
For this, we have the View object, this object allows to set up a plain php file, and gives us the ability to populate it with our custom variables and render it when and if we want
The view also comes with a helpful function "getResponse" that aids to get a valid Response object (HtmlResponse) from the view created
```
<?php

namespace Mikro\Http\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Home extends Controller
{
    public function index(){
        $view = $this->container->get('view');

        return $view->file('book')->render([
            'hola' => 'chau'
        ])->getResponse();
    }
}
```
And views are just plain php files, every view (and the whole presentation layer css/js/html) are inside resources folder
```
<div class="container">
    <header><h1>Mikro Php Books</h1></header>
    <nav>
        <a href="<?php echo $this->url('books/create') ?>">Go to Creation</a><br>
        <a href="<?php echo $this->url('books') ?>">Go to Books</a>
    </nav>
    <div class="row">
        <div class="col-md-4 book">
            <div class="card">
                <div class="card-header"><h3><?php echo $book->name ?></h3></div>
                <div class="card-body">
                    Book is in shelf: <?php echo $book->shelf->name ?>
                    Author: <?php echo $book->author ?>
                </div>
                    <a class="btn btn-primary" href="<?php echo $this->url('books/' . $book->id . '/updat') ?>">Update</a>
                    <button class="deleteBook btn btn-danger" data-book-id="<?php echo $book->id ?>">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
```

## Database
This frameworks comes with a simple implementation of Laravel's Eloquent ORM.
The EloquentDatabase class found in the Core is responsible for initiating the ORM and it's connection
For using the ORM is just like in a normal Laravel app, you define a Model, extend it to Model
```
<?php
namespace Mikro\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['name', 'author', 'shelf_id'];
    protected $with = ['shelf'];
}
```

## Utils
Inside the Utils namespace you can find all of the factories used (mainly by the container) and also a small Url utility.
This Url object is used by the View object, and it helps to populate absolute url's for assets and url's inside views

If you need a url, use it like this:
```
<a class="btn btn-primary" href="<?php echo $this->url('books/' . $book->id . '/updat') ?>">Update</a>
```
And if you need to define an asset:
```
<link href="<?php echo $this->asset('css', 'style.css'); ?>">
```
The Url object gets injected to the View object by default, so there's no need to do anything in order to use it inside the presentation layer

## Migrations
For testing purposes, this fw comes with a small migration file. After installing and making sure you have the database properly configured you can have a small db to play with
```
cd src/
cd migrations
php eloquent_migrations.php
```

## Testing this framework
For rapid test, these are the things that should be done:
1) Clone the repo
2) Do update composer (composer update)
3) Make sure database is properly configured (config/app.php)
4) Make sure baseUrl is defined (config/app.php)
5) Make sure mod_rewrite is enabled in your apache installation
6) Run migrations
7) Access through web browser

## Schematics
schematic.pdf has a small schematic of the design for the different layers and main objects and their responsibilities and dependencies

## Database Schema
The "demo" database structure that comes with the fw is pretty simple.
Its a Book entity related to a Shelf entity. A shelf can have any number of books and a book belongs to only one shelf
inside Models/ you'll find both models (Book & Shelf in singular according to Eloquent needs)
inside Http/Controllers you'll find both controllers (Books & Shelves in plural to maintain a RESTful resource/entity approach)

### Unit Testing with PHPUnit
The tests are prepared to be used with PHPUnit and the test suite is configured via XML, so you'll only need to execute PHPUnit in your forked version of this repo like so:
```shell
./vendor/bin/phpunit
```
Coverage is not high, suites are just an example of how to put together the tests.