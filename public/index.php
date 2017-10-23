<?php

/*
 * Front controller
 * PHP v7.1.8
*/

/*
 * Composer autoload
*/
require_once dirname(__DIR__) . '/vendor/autoload.php';

/*
 * Error and exception handling
*/
error_reporting(E_ALL);
set_error_handler('Core\Error::error_handler');
set_exception_handler('Core\Error::exception_handler');

$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

// Dispatch controller action based on current route
$router->dispatch($_SERVER['QUERY_STRING']);
