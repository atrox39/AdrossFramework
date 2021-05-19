<?php
use Adross\Route;
$home = [
    Route::get('/', function($req, $res){
        $res->json(["message"=>"hola"]);
    }),
    Route::get('/home', function($req, $res){
        $res->render("index", ["title"=>"Welcome"]);
    }),
    Route::get('/home/:id/:user/:pass', function($req, $res){
        $res->json($req->params);
    }),
];