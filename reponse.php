<?php
require_once 'db.php';

class Reponse {
    private $pdo;

    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnexion();
    }

    private function securityInput($nameInput) {
        return trim(htmlspecialchars($nameInput));
    }

    public function create($id_question_quiz, $reponse, $isTrue) {
        $data = $this->pdo->prepare(
            'INSERT INTO reponses_quiz (id_question_quiz, reponse, isTrue) 
            VALUES (:id_question_quiz, :reponse, :isTrue)'
        );
        $data->bindValue(':id_question_quiz', $id_question_quiz, PDO::PARAM_INT);
        $data->bindValue(':reponse', $this->securityInput($reponse),PDO::PARAM_STR);
        $data->bindValue(':isTrue',$isTrue,PDO::PARAM_INT);
        return $data->execute();
    }
    public function getAll() {
        $data = $this->pdo->prepare('SELECT * FROM  reponses_quiz');
        $data->execute();
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }
  
    public function getQuestionId($id_question_quiz) {
        $data = $this->pdo->prepare('SELECT * FROM reponses_quiz WHERE id_question_quiz = :id_question_quiz');
        $data->bindValue(':id_question_quiz', $id_question_quiz, PDO::PARAM_INT);
        $data->execute();
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }
    public function update($id, $reponse, $reponseTrue) {
        $data = $this->pdo->prepare(
            'UPDATE reponses_quiz SET reponse = :reponse, reponseTrue = :reponseTrue WHERE id = :id'
        );
        $data->bindValue(':reponse',$this->securityInput($reponse), PDO::PARAM_STR);
        $data->bindValue(':reponseTrue', $reponseTrue,PDO::PARAM_INT);
        $data->bindValue(':id',$id, PDO::PARAM_INT);
        return $data->execute();
    }

    public function delete($id) {
        $data = $this->pdo->prepare('DELETE FROM reposequiz WHERE id = :id');
        $data->bindValue(':id', $id, PDO::PARAM_INT);
        return $data->execute();
    }
}
?>