<?php
namespace Adross;
use Adross\Route;
class Router
{

    public $req = ["body"=>[],"URL"=>"/"];
    private $route;
    public $url;
    public $params;

    public function __construct()
    {
        $this->route = new Route();
        $uri = $_SERVER['REQUEST_URI'];
        $this->url = $uri;
        $this->params = explode("/", $uri);
    }

    public function setBody()
    {
        switch($_SERVER['REQUEST_METHOD'])
        {
            case 'GET':
                $this->req["body"] = $_GET;
                break;
            case 'POST':
                $this->req["body"] = $_POST;
                break;
        }
        $this->req["URL"] = $_SERVER['REQUEST_URI'];
    }

    public function get()
    {
        $route = func_get_args()[0];
        if($this->url==$route && $_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $fn = null;
            $middleware = null;
            if(count(func_get_args())==2)
            {
                $fn = func_get_args()[1];
            }
            else if(count(func_get_args())==3)
            {
                $middleware = func_get_args()[1];
                $fn = func_get_args()[2];
                $middleware();
            }
            $this->setBody();
            $fn($this->req, $this->route);
        }
    }

    public function post()
    {
        $route = func_get_args()[0];
        if($this->url==$route && $_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $fn = null;
            $middleware = null;
            if(count(func_get_args())==2)
            {
                $fn = func_get_args()[1];
            }
            else if(count(func_get_args())==3)
            {
                $middleware = func_get_args()[1];
                $fn = func_get_args()[2];
                $middleware();
            }
            $this->setBody();
            $fn($this->req, $this->route);
        }
    }

    public function redirect($route)
    {
        echo '<script>window.location.href="'.$route.'"</script>';
    }
}
?>