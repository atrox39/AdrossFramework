<?php
namespace Adross;

use Adross\Database;

class Schema
{
    public $schemaname;
    private $database;
    public $columns;
    public $foreigns;
    private $table_prefix;

    public function __construct()
    {
        $this->table_prefix = "tb_";
        $this->database = new Database();
    }

    public function start()
    {
        $this->schemaname = $this->table_prefix.$this->schemaname;
        if(isset(func_get_args()[0])){
            if(func_get_args()[0]){
                echo "\n\t\e[36m- \e[33mTable \e[35m- \e[39m".$this->schemaname."\n";
                $this->database->NonQuery("DROP TABLE IF EXISTS ".$this->schemaname);
                echo "\t\e[36m- \e[33mDROP AND RECREATE FOR\e[35m: \e[39m`".$this->schemaname."`\n";
            }
        }
        $table = "CREATE TABLE IF NOT EXISTS ".$this->schemaname."(_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,";
        foreach($this->columns as $col)
        {
            $attrib = isset($col['attrib']) ? " ".$col['attrib'] : "";
            $extra = $col['type'] == "TIMESTAMP" ? " DEFAULT CURRENT_TIMESTAMP" : "";
            $size = isset($col['size']) ? "(".$col['size'].")" : "";
            $nullable = isset($col['nullable']) ? $col['nullable'] : " NOT NULL";
            $table .= " ".$col['name']." ".$col['type'].$size.$attrib." ".$nullable.$extra.",\n";
        }
        $table .= " PRIMARY KEY (_id));";
        $this->database->NonQuery($table);
        if (isset($this->foreigns)) {
            foreach ($this->foreigns as $foreignkey) {
                foreach ($foreignkey as $keys) {
                    $unsigned = "ALTER TABLE `" . $this->schemaname . "` CHANGE `" . $keys['root'] . "` `" . $keys['root'] . "` INT(11) UNSIGNED NOT NULL;";
                    $addforeign = "ALTER TABLE `" . $this->schemaname . "`";
                    $addforeign .= " ADD CONSTRAINT `" . $keys['relation_name'] . "`";
                    $addforeign .= " FOREIGN KEY (`" . $keys['root'] . "`) REFERENCES `" . $keys['model_schema_name'] . "`(`_id`)";
                    $addforeign .= " ON DELETE " . $keys['on_delete'];
                    $addforeign .= " ON UPDATE " . $keys['on_update'] . ";";
                    if(isset(func_get_args()[0])) if(func_get_args()[0]){
                        echo "\t\e[36m- \e[33mUNSIGNED ADDED TO\e[35m: \e[39m`" . $keys['root'] . "`\n";
                        echo "\t\e[36m- \e[33mFOREIGN KEY\e[35m: \e[39m`" . $keys['relation_name'] . "`\n\n";
                    }
                    $this->database->NonQuery($unsigned);
                    $this->database->NonQuery($addforeign);
                }
            }
        }
    }

    public function index()
    {
        return $this->database->Query("SELECT * FROM ".$this->schemaname);
    }

    public function show($id)
    {
        return $this->database->Query("SELECT * FROM ".$this->schemaname." WHERE _id = ".$id);
    }

    public function create($data)
    {
        $query = "INSERT INTO  `".$this->schemaname."`";
        $count = 0;
        foreach($this->columns as $colum)
        {
            if($count==0)
                $query .= " (`".$colum['name']."`";
            else
                $query .= ", `".$colum['name']."`";
            $count += 1;
        }
        $query .= ") VALUES ";
        $count = 0;
        foreach($this->columns as $colum)
        {
            $value = (is_numeric($data[$count]) && ($colum['type'] == "INTEGER" || $colum['type'] == "FLOAT" || $colum['type'] == "DOUBLE")) ? $data[$count] : "'".$data[$count]."'";
            if($count==0)
                $query .= " ($value";
            else
                $query .= ", $value";
            $count += 1;
        }
        $query .= ");";
        //echo $query;
        $this->database->NonQuery($query);
    }

    public function update($id)
    {

    }

    public function delete($id)
    {

    }
}