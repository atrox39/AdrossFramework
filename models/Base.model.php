<?php
namespace Models;
use Adross\Schema;

// Use this model for examples

class Base extends Schema
{
    public function __construct($force=false)
    {
        parent::__construct();
        $this->schemaname = "tb_posts";
        $this->columns =
        [
            [
                "name"=>"title",
                "type"=>"VARCHAR",
                "size"=>30
            ],
            [
                "name"=>"description",
                "type"=>"TEXT",
            ],
            [
                "name"=>"user",
                "type"=>"INTEGER",
                "attrib"=>"UNSIGNED"
            ],
            [
                "name"=>"timestamp",
                "type"=>"TIMESTAMP",
            ],
        ];
        
        /*$this->foreigns = [[
            "foreign"=>[
                "model_schema_name"=> $this->table_prefix.'tablename',
                "relation_name"=>"SAMPLE",
                "root"=>"user",
                "on_delete"=>"CASCADE",
                "on_update"=>"NO ACTION"]
            ]];*/
        $this->start($force);
    }
}