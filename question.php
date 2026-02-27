<?php
require_once 'db.php';

class Question {
    private $pdo;

    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnexion();
    }

    private function securityInput($nameInput) {
        return trim(htmlspecialchars($nameInput));
    }

    public function create($question, $quiz_id) {
        $data = $this->pdo->prepare(
            'INSERT INTO question_quiz (question, quiz_id) VALUES (:question, :quiz_id)'
        );
        $data->bindValue(':question', $this->securityInput($question), PDO::PARAM_STR);
        $data->bindValue(':quiz_id',  $quiz_id, PDO::PARAM_INT);
        $data->execute();
        return $this->pdo->lastInsertId();
    }

    public function getAll() {
        $data = $this->pdo->prepare('SELECT * FROM   question_quiz');
        $data->execute();
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getQuizId($quiz_id) {
        $data = $this->pdo->prepare('SELECT * FROM question_quiz WHERE quiz_id = :quiz_id');
        $data->bindValue(':quiz_id', $quiz_id, PDO::PARAM_INT);
        $data->execute();
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }


    public function update($id, $question) {
        $data = $this->pdo->prepare(
            'UPDATE question_quiz SET question = :question WHERE id = :id'
        );
        $data->bindValue(':question', $this->securityInput($question), PDO::PARAM_STR);
        $data->bindValue(':id',$id, PDO::PARAM_INT);
        return $data->execute();
    }

    public function delete($id) {
        $data = $this->pdo->prepare('DELETE FROM question_quiz WHERE id = :id');
        $data->bindValue(':id', $id, PDO::PARAM_INT);
        return $data->execute();
    }
}
?>