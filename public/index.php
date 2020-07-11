<?php

ini_set('display_errors', 1);
ini_set('display_starup_error', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

password_hash('superSecurePaswd', PASSWORD_DEFAULT);

use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;


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

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();
$map->get('index', '/cursophp2/', [
    'controller' => 'App\Controllers\IndexController',
    'action' => 'indexAction'
]);
$map->get('addJobs', '/cursophp2/jobs/add',[
    'controller' => 'App\Controllers\JobsController',
    'action' => 'getAddJobAction'
] );
$map->post('saveJobs', '/cursophp2/jobs/add',[
    'controller' => 'App\Controllers\JobsController',
    'action' => 'getAddJobAction'
] );

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);
     
function printElement($job){
    // if($job->visible == false) {
    //     return;             
    // }
      
        echo '<li class="work-position">';
        echo '<h5>' .  $job->title . '</h5>';
        echo '<p>' .  $job->description . '</p>';
        echo '<p>' .  $job ->getDurationAsString() . '</p>';
        echo '<strong>Achievements:</strong>';
        echo '<ul>';
        echo '<li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
        echo ' <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
        echo '  <li>Lorem ipsum dolor sit amet, 80% consectetuer adipiscing elit.</li>';
        echo '</ul>';
        echo '</li>';
      }

if (!$route){
    echo 'No route';
} else {
    // var_dump($route->handler);
    $handlerData = $route->handler;
    $controllerName = $handlerData['controller'];
    $actionName = $handlerData['action'];

    $controller = new $controllerName;
    $response = $controller->$actionName($request);

    echo $response->getBody();
}




