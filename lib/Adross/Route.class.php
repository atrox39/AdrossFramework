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
}