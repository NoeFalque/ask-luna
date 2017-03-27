<?php
require('../vendor/autoload.php');

use \App\System\App;
use \App\System\Router\Router;
use \App\System\Settings;

session_start();

$app    = new App();
$router = new Router($_GET);


$router->get('/', function() {
    $controller = new \App\Controllers\PostsController();
    $controller->all();
});

$router->get('/login/', function() {
    $controller = new \App\Controllers\UsersController();
    $controller->login();
});

$router->post('/login/', function() {
    $controller = new \App\Controllers\UsersController();
    $controller->login();
});

$router->get('/logout/', function() {
    $controller = new \App\Controllers\UsersController();
    $controller->logout();
});

$router->get('/signup/', function() {
    $controller = new \App\Controllers\UsersController();
    $controller->signup();
});
$router->post('/signup/', function() {
    $controller = new \App\Controllers\UsersController();
    $controller->signup();
});

$router->get('/settings/', function() {
    App::secured();
    $controller = new \App\Controllers\UsersController();
    $controller->settings();
});

$router->post('/settings/', function() {
    App::secured();
    $controller = new \App\Controllers\UsersController();
    $controller->settings();
});

$router->error(function() {
    App::error();
});

$router->run();
