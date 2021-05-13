<?php
namespace Adross;

use Adross\Template;

class Route
{
    public function render($view, $context=[])
    {
        $path = "views/".$view.".html";
        echo new Template($path, $context);
    }

    public function send($text)
    {
        header('Content-Type:text/plain');
        echo $text;
    }

    public function json($json)
    {
        header('Content-Type:application/json');
        echo json_encode($json);
    }
}