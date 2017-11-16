<?php
session_start();
date_default_timezone_set('Europe/Paris');
require_once __DIR__.'/../vendor/autoload.php';


$app = new Silex\Application();

// enable the debug mode
$app['debug'] = true;
require __DIR__.'/../app/routes.php';
require_once __DIR__.'/../app/app.php';
$app->boot();
$app->run();

?>
