<?php

namespace Classes;

use PDO;

class DataBase {
    protected $pdo;

    /**
     * Database connection
     * @return PDO
     */
    public function connect(){
        $this->pdo = new PDO("mysql:host=localhost;dbname=test;charset=utf8",
            "mysql", "mysql");
        if(!$this->pdo) {
            exit("Database not connected!");
        }
        return $this->pdo;
    }

}

?>