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

$router->get('/picture-of-the-day/:id', function($id) {
    $controller = new \App\Controllers\PostsController();
    $controller->single($id);
});

$router->post('/picture-of-the-day/:id', function($id) {
    $controller = new \App\Controllers\PostsController();
    $controller->single($id);
});

$router->get('/settings/account/', function() {
    App::secured();
    $controller = new \App\Controllers\UsersController();
    $controller->settingsAccount();
});

$router->post('/settings/account/', function() {
    App::secured();
    $controller = new \App\Controllers\UsersController();
    $controller->settingsAccount();
});

$router->get('/settings/security/', function() {
    App::secured();
    $controller = new \App\Controllers\UsersController();
    $controller->settingsSecurity();
});

$router->post('/settings/security/', function() {
    App::secured();
    $controller = new \App\Controllers\UsersController();
    $controller->settingsSecurity();
});

$router->get('/settings/picture/', function() {
    App::secured();
    $controller = new \App\Controllers\UsersController();
    $controller->settingsPicture();
});

$router->post('/settings/picture/', function() {
    App::secured();
    $controller = new \App\Controllers\UsersController();
    $controller->settingsPicture();
});

$router->get('/api/upvote/comments/:id', function($id) {
    $controller = new \App\Controllers\CommentsController();
    $controller->upvote($id);
});

$router->error(function() {
    App::error();
});

$router->run();
