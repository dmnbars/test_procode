<?php
namespace App;

require_once 'vendor/autoload.php';

$app = new Application();
$db = new DataBase('localhost', 'test_procode', 'root', '');
$app->register('db', $db);

$app->get('/', function ($meta, $params, $attributes, $cookies, $session, $app) {
    return new Response(Template::render('index'));
});

$app->run();
