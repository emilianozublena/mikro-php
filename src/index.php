<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';
$container = (require 'config/services.php');
$kernel = $container->get('kernel');
$kernel->initCore();

require 'config/routes.php';

$kernel->processRoutes();

$kernel->run();
