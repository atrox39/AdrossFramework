<?php
namespace Adross;

class Config
{
    public static function Database()
    {
        $database = null;
        $json = json_decode(file_get_contents('config.json'));
        if($json->debug)
        {
            $database = $json->database_dev;
        }
        else
        {
            $database = $json->database_deploy;
        }
        return $database;
    }

    public static function Template()
    {
        $template = null;
        $json = json_decode(file_get_contents('config.json'));
        return $json->main_template;
    }
}