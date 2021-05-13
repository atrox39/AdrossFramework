<?php
include_once('./autoload.class.php');
use Adross\App;
use Adross\Config;
if(isset($argv[1]))
{
    switch($argv[1]){
        case "rebuild_all":
            
        break;

        case "models":
            echo "\n";
            $count = 0;
            foreach(scandir('models') as $file)
            {
                if($file!=".." && $file!="." && $file!="Base.model.php")
                {
                    $file = explode(".", $file);
                    echo "\t\e[36m- \e[33mModelname\e[35m: \e[39m".$file[0]."\n\n";
                    $count += 1;
                }
            }
            echo "\t\e[36m- \e[92mTotal models\e[35m: \e[91m$count\e[39m\n\n";
        break;

        case "test":
            print_r(Config::Database());
        break;
    }
}