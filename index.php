<?php
include_once('autoload.class.php');
use Adross\App;

$app = new App();

$app->router->get('/', function($req, $res){
    $res->render('index');
});

$app->Check();
?>