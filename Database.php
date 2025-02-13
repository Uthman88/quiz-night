<?php
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function __construct($db_name = 'quiz_db') {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $db_name);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}