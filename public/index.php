<?php
require('../vendor/autoload.php');

use \App\System\App;
use \App\System\Router\Router;
use \App\System\Settings;

session_start();

$app    = new App();
$router = new Router($_GET);

require('../App/System/Listeners.php');

$router->get('/', function() {
    $controller = new \App\Controllers\PostsController();
    $controller->index();
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

$router->get('/pictures-of-the-day', function() {
    $controller = new \App\Controllers\PostsController();
    $controller->all();
});

$router->get('/picture-of-the-day/:id', function($id) {
    $controller = new \App\Controllers\PostsController();
    $controller->single($id);
});

$router->post('/picture-of-the-day/:id', function($id) {
    $controller = new \App\Controllers\PostsController();
    $controller->single($id);
});

$router->get('/answer', function() {
    App::secured();
    $controller = new \App\Controllers\CommentsController();
    $controller->answer();
});

$router->get('/:username', function($username) {
    $controller = new \App\Controllers\UsersController();
    $controller->single($username);
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

$router->get('/api/downvote/comments/:id', function($id) {
    $controller = new \App\Controllers\CommentsController();
    $controller->downvote($id);
});

$router->get('/api/notifications', function() {
    $controller = new \App\Controllers\NotificationsController();
    $controller->mark();
});

$router->get('/api/search/:query', function($query) {
    $controller = new \App\Controllers\PostsController();
    $controller->search($query);
});

$router->error(function() {
    App::error();
});

$router->run();
