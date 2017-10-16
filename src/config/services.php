<?php
/**
 * This file inits the Service Manager and therefore makes the container available for the whole app
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

$config = (require 'app.php');

use Zend\ServiceManager\ServiceManager;

$container = new ServiceManager();

$container->setFactory(
    'kernel',
    \Mikro\Utils\Factories\KernelFactory::class
);
$container->setInvokableClass(
    'capsule',
    \Illuminate\Database\Capsule\Manager::class
);
$container->setFactory(
    'database',
    \Mikro\Utils\Factories\EloquentDatabaseFactory::class
);
$container->setInvokableClass(
    'router',
    \Mikro\Core\Router::class
);
$container->setFactory(
    'request',
    \Mikro\Utils\Factories\ServerRequestFactory::class
);
$container->setInvokableClass(
    'response',
    \Mikro\Http\Response::class
);
$container->addAbstractFactory(\Mikro\Utils\Factories\ControllersAbstractFactory::class);
$container->addAbstractFactory(\Mikro\Utils\Factories\ModelsAbstractFactory::class);
$container->setFactory(
    'view',
    \Mikro\Utils\Factories\ViewFactory::class
);
$container->setFactory(
    'url',
    \Mikro\Utils\Factories\UrlFactory::class
);

return $container;