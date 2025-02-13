<?php
require_once 'Database.php';  // Utilisation de require_once

class QuizManager {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConnection();
    }

    public function getQuestions($theme) {
        $result = $this->db->query("SELECT * FROM $theme");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getThemes() {
        $result = $this->db->query("SHOW TABLES");
        $themes = [];
        while ($row = $result->fetch_row()) {
            $themes[] = $row[0];
        }
        return $themes;
    }
}