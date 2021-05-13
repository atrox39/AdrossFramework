<?php
session_start();
function autoload($classname)
{
    $classname = str_replace('\\', '/', $classname);
    $route = explode('/', $classname);
    if(strtolower($route[0])=="models")
        include_once('models/'.$route[1].'.model.php');
    else
        include_once('lib/'.$classname.'.class.php');
}
spl_autoload_register('autoload');