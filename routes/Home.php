<?php
use Adross\Route;
$home = [
    Route::get('/', function($req, $res){
        $res->send('ok');
    }),
    Route::post('/', function($req, $res){
        $res->send('ok');
    })
];