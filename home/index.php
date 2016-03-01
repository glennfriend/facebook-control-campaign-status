<?php
$basePath = dirname(__DIR__);
require_once $basePath . '/app/bootstrap.php';
initialize($basePath, 'home');

//$controller = new AppModule\Home();
//$controller->defaultPage();

$app = new Slim\App(getDefaultSlimConfig());
$app->get('/',              'AppModule\Home:defaultPage');
$app->get('/pause',         'AppModule\Home:pause');
$app->get('/login',         'AppModule\Auth:login');
$app->get('/fb-callback',   'AppModule\Auth:facebookCallback');

$app->run();
