<?php
require('../vendor/autoload.php');

use \App\System\App;
use \App\System\Router\Router;
use \App\System\Settings;

session_start();

$app    = new App();
$router = new Router($_GET);


$router->get('/', function() {
    echo 'coucou';
});

$router->error(function() {
    App::error();
});

$router->run();
