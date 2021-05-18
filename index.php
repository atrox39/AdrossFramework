<?php
include_once('autoload.class.php');
use Adross\App;

$app = new App();

$app->router->get('/', function($req, $res){
    $res->render('index');
});

$app->router->get('/get-user-info/:id/:post', function($req, $res){
    $res->json($req['params']);
});
/*
$app->router->post('/check', function($req, $res){
    $res->send('Hola');
});*/
?>