<?php

ini_set('display_errors', 1);
ini_set('display_starup_error', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
// use Aura\Router\RouterContainer;


$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'cursophp2',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);
// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();
// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

var_dump($request->getUri()->getPath());


// $routerContainer = new RouterContainer();
// $map = $routerContainer->getMap();
// $map->get('index', '/', '../index.php');
// $map->get('addJobs', 'jobs/add', '../addJob.php');

// $matcher = $routerContainer->getMatcher();
// $route = $matcher->match($request);
// if (!$route){
//     echo 'No route';
// }else{
//     require $route->handler;
// }

//var_dump($route->handler);


