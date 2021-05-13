<?php
namespace Adross;
// libs

use Exception;
use mysqli;
use Adross\Config;

class Database
{
    public $instance;
    private $config;
    
    public function __construct()
    {
        $this->config = Config::Database();
        $temp = new mysqli($this->config->host, $this->config->user, $this->config->password);
        $temp->query('CREATE DATABASE IF NOT EXISTS '.$this->config->database);
        $this->instance = new mysqli($this->config->host, $this->config->user, $this->config->password, $this->config->database);
    }

    public function NonQuery($text)
    {
        try
        {
            $this->instance->query($text);
            return $this->instance->affected_rows != -1 ? true : false;
        }
        catch(Exception $err)
        {
            echo $err;
        }
    }

    public function Query($text)
    {
        try
        {
            $fetch = [];
            $temp = $this->instance->query($text);
            while($res = $temp->fetch_assoc())
            {
                $fetch[] = $res;
            }
            return $fetch;
        }
        catch(Exception $err)
        {
            
        }
    }
}