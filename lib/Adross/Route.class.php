<?php
namespace Adross;

use Adross\Template;
class Route
{
    public static function get($route, $fn)
    {
        if($_SERVER['REQUEST_METHOD'] == "GET")
            return Route::__base($route, $fn);
        else
            return null;
    }
    public static function post($route, $fn)
    {
        if($_SERVER['REQUEST_METHOD'] == "POST")
            return Route::__base($route, $fn);
        else
            return null;
    }

    private static function __base($route, $fn)
    {
        $response = new class{
            public $route;
            public $method; 
            public $req;
            public $res;
            public $fn;
            public function __construct()
            {
                $this->method = $_SERVER['REQUEST_METHOD'];
                $this->req = new class{
                    public $body;
                    public $params;
                    public function __construct(){
                        $this->body =  $_SERVER['REQUEST_METHOD'] == "POST" ? $_POST : $_GET;
                    }
                };
                $this->res = new class{
                    public $type;
                    public $content;
                    public function render($view, $context){
                        $path = "views/".$view.".html";
                        $this->type = "view";
                        $this->content = new Template($path, $context);
                    }
                    public function json($array){
                        $this->type = "json";
                        $this->content = json_encode($array);
                    }
                    public function send($text){
                        $this->type = "text";
                        $this->content = $text;
                    }
                };
            }
        };
        $response->req->params = Route::getParams($route);
        if(count($response->req->params)>0) $response->route = $_SERVER['REQUEST_URI'];
        else $response->route = $route;
        $fn($response->req, $response->res);
        $response->fn = $fn;
        return $response;
    }

    public static function getParams($route)
    {
        $params = [];
        $params_route = explode('/', $route);
        $params_uri = explode('/', $_SERVER['REQUEST_URI']);
        if(isset($route)){
            
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
                            $params += array($temp=>$params_uri[$pos]);
                        }
                    }
                    $pos += 1;
                }
                if(count($params)>0) return $params;
            }
        }
        return [];
    }
}