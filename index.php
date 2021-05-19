<?php
use Adross\App;
include_once('autoload.class.php');
include_once('./routes/Home.php');
$app = new App();
// Route example, home
$app->use($home);
// Listen Routes
$app->listenRoutes();
?>