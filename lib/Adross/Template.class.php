<?php
namespace Adross;

use ErrorException;
use Adross\Config;

class Template
{
    private $body;
    
    public function __construct($path, $context=[])
    {
        try
        {
            $body = $this->ChargeTemplate($path, $context);
            extract($context);
            ob_start();
            include("views/".Config::Template());
            $this->body = ob_get_clean();
        }
        catch(ErrorException $err)
        {
            //$this->body = "Error on template charge, verify name and location";
        }     
    }

    public function ChargeTemplate($path, $context)
    {
        try
        {
            extract($context);
            ob_start();
            if(file_exists($path))
                include($path);
            else
                return "<script> document.body.innerHTML = 'Error on template charge, verify name and location of \'$path\''; </script>";
            return ob_get_clean();
        }
        catch(ErrorException $err)
        {
            return $err;
        }
    }

    public function __toString()
    {
        return $this->body;
    }
}