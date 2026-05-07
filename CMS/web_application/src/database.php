<?php

//database class which creates a single database connection

class Database {
    private $db;

    public function __construct() {

        $this->db = new SQLite3("C:\\xampp\\database\\cms.db");
    }

    public function getConnection() {

        return $this->db;
    }
}

?>