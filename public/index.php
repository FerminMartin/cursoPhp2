<?php

ini_set('display_errors', 1);
ini_set('display_starup_error', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;


$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => getenv('DB_HOST'),
    'database'  => getenv('DB_NAME'),
    'username'  => getenv('DB_USER'),
    'password'  => getenv('DB_PASS'),
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

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();
$map->get('index', '/cursophp2/', [
    'controller' => 'App\Controllers\IndexController',
    'action' => 'indexAction'
]);
$map->get('indexJobs', '/cursophp2/jobs',[
    'controller' => 'App\Controllers\JobsController',
    'action' => 'indexAction'
] );
$map->get('addJobs', '/cursophp2/jobs/add',[
    'controller' => 'App\Controllers\JobsController',
    'action' => 'getAddJobAction'
] );
$map->get('deleteJobs', '/cursophp2/jobs/delete',[
    'controller' => 'App\Controllers\JobsController',
    'action' => 'deleteAction'
] );
$map->post('saveJobs', '/cursophp2/jobs/add',[
    'controller' => 'App\Controllers\JobsController',
    'action' => 'getAddJobAction'
] );
$map->get('addUser', '/cursophp2/users/add', [
    'controller' => 'App\Controllers\UsersController',
    'action' => 'getAddUser'
]);
$map->post('saveUser', '/cursophp2/users/save', [
    'controller' => 'App\Controllers\UsersController',
    'action' => 'postSaveUser'
]);
$map->get('loginForm', '/cursophp2/login', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'getLogin'
]);
$map->get('logout', '/cursophp2/logout', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'getLogout'
]);
$map->post('auth', '/cursophp2/auth', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'postLogin'
]);
$map->get('admin', '/cursophp2/admin', [
    'controller' => 'App\Controllers\AdminController',
    'action' => 'getIndex',
    'auth' => 'true'
]);

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);


if (!$route){
    echo 'No route';
} else {
    // var_dump($route->handler);
    $handlerData = $route->handler;
    $controllerName = $handlerData['controller'];
    $actionName = $handlerData['action'];
    $needsAuth = $handlerData['auth'] ?? false;

    $sessionUserId = $_SESSION['userId'] ?? null;
    if ($needsAuth && !$sessionUserId){
        echo 'Protected route';
        die;
    }

    if ($controllerName === 'App\Controllers\JobsController'){
        $controller = new $controllerName (new \App\Services\JobService());
    } else {
        $controller = new $controllerName;
    }

    $response = $controller->$actionName($request);

    foreach($response->getHeaders() as $name => $values){
        foreach($values as $value){
            header(sprintf('%s: %s', $name, $value), false);
        }
    }

    http_response_code($response -> getStatusCode());
    echo $response->getBody();
}




