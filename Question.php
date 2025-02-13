<?php
require_once 'Database.php';

class Question {
    private $db;

    public function __construct($db) {
        $this->db = $db->getConnection();
    }

    public function addQuestion($theme, $data) {
        $stmt = $this->db->prepare("INSERT INTO $theme (question, reponse1, reponse2, reponse3, reponse4, bonne_reponse) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $data['question'], $data['reponse1'], $data['reponse2'], $data['reponse3'], $data['reponse4'], $data['bonne_reponse']);
        $stmt->execute();
    }

    public function editQuestion($theme, $data) {
        $stmt = $this->db->prepare("UPDATE $theme SET question = ?, reponse1 = ?, reponse2 = ?, reponse3 = ?, reponse4 = ?, bonne_reponse = ? WHERE id = ?");
        $stmt->bind_param("sssssii", $data['question'], $data['reponse1'], $data['reponse2'], $data['reponse3'], $data['reponse4'], $data['bonne_reponse'], $data['id']);
        $stmt->execute();
    }

    public function deleteQuestion($theme, $id) {
        $stmt = $this->db->prepare("DELETE FROM $theme WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    public function getThemes() {
        $result = $this->db->query("SHOW TABLES");
        $themes = [];
        while ($row = $result->fetch_row()) {
            $themes[] = $row[0];
        }
        return $themes;
    }

    // Ajout de la méthode getQuestions()
    public function getQuestions($theme) {
        $result = $this->db->query("SELECT * FROM $theme");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}