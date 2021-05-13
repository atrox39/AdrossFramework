<?php
namespace Adross;

use Adross\Router;

class App
{
    public $router;
    private $route;
    
    public function __construct()
    {
        $this->route = $_SERVER['REQUEST_URI'];
        $this->router = new Router();
    }

    public function Check()
    {
        if($this->router->req["URL"] != $this->route)
            echo "Error page not found ".$this->route;
    }
}