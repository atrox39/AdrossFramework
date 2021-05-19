<?php
namespace Adross;
use Adross\Router;
use Adross\Route;
class App
{
    private $active_routes = [];

    public function use()
    {
        $args = func_get_args();
        if(count($args)>0)
        {
            foreach($args[0] as $route)
            {
                $this->active_routes[] = [
                    "route"=> $route->route,
                    "data"=>$route->res->content,
                    "type"=>$route->res->type
                ];
            }
        }
    }

    public function listenRoutes()
    {
        $temp = false;
        $type = "";
        $content = null;
        if(count($this->active_routes)>0){
            foreach($this->active_routes as $route){
                if($_SERVER['REQUEST_URI']==$route["route"]){
                    $content = $route["data"];
                    $type = $route["type"];
                    $temp = true;
                }
            }
        }
        if($temp)
        {
            switch ($type) {
                case "view":
                    header('Content-Type:text/html');
                    break;
                case "json":
                    header('Content-Type:application/json');
                    break;
                case "text":
                    header('Content-Type:text/plain');
                    break;
            }
            echo $content;
        }
        else
        {
            $route = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            include_once("./lib/Adross/404_error.php");
        }
    }
}