<?php
namespace core;

use \core\Database;

class Model {

    //protected static $_h;
    protected $connection;
    
    public function __construct() {
        $this->checkH();
    }

    public function checkH() {
        if($this->connection == null) {
            $data = new Database();
            $this->connection = $data->getInstance();
        }
        
    }
} 