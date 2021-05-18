<?php
namespace Adross;
use Adross\Route;
class Router
{

    public $req = ["body"=>[],"URL"=>"/", "METHOD"=>"GET", "params"=>[]];
    private $route;
    public $url;
    public $params;
    public $user_route;

    public function __construct()
    {
        $this->route = new Route();
        $uri = $_SERVER['REQUEST_URI'];
        $this->url = $uri;
        $this->params = explode("/", $uri);
    }

    private function readParams($route)
    {
        if(isset($route)){
            $params_route = explode('/', $route);
            $params_uri = explode('/', $_SERVER['REQUEST_URI']);
            array_shift($params_route);
            array_shift($params_uri);
            if(count($params_route)==count($params_uri))
            {
                $pos = 0;
                foreach($params_route as $param)
                {
                    if(strlen($param) > 0){
                        if($param[0]==":"){
                            $temp = str_split($param);
                            array_shift($temp);
                            $temp = implode($temp);
                            $this->req['params'] += array($temp=>$params_uri[$pos]);
                        }
                    }
                    $pos += 1;
                }
                if(count($this->req['params'])>0) $this->user_route = $_SERVER['REQUEST_URI'];
            }
        }
    }

    public function get()
    {
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            $this->base(func_get_args());
            return true;
        }
        return false;
    }

    public function post()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $this->base(func_get_args());
            return true;
        }
        return false;
    }

    private function base()
    {
        $params = func_get_args()[0];
        $this->user_route = $params[0];
        $this->readParams($this->user_route);
        if($this->url==$this->user_route)
        {
            $fn = null;
            $middleware = null;
            if(count($params)==2)
            {
                $fn = $params[1];
            }
            else if(count($params)==3)
            {
                $middleware = $params[1];
                $fn = $params[2];
                $middleware();
            }
            $this->setParams();
            $fn($this->req, $this->route);
        }
        else
        {
            return;
        }
    }

    private function setParams()
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
        $this->req["METHOD"] = $_SERVER['REQUEST_METHOD'];
        $this->req["URL"] = $_SERVER['REQUEST_URI'];
    }

    public function redirect($route)
    {
        echo '<script>window.location.href="'.$route.'"</script>';
    }
}
?>