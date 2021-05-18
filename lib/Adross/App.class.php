<?php
namespace Adross;

use Adross\Router;

class App
{
    public $router;
    
    public function __construct()
    {
        $this->router = new Router();
    }
}