<?php 
require 'db.php';

class Question{
     private $pdo;
   
     public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnexion();
    }
    private function secrityInput($nameInput) {
        return trim(htmlspecialchars($nameInput));
        
    }
   
    public function create($question,$id_quiz){
    
        $insert_data = $this->pdo->prepare('INSERT INTO quiz(question,id_quiz) VALUE(:name,:id_categorie)');
        $insert_data->bindValue(":question", $question, PDO::PARAM_STR);
        $insert_data->bindValue(":id_quiz", $id_quiz, PDO::PARAM_INT);
        $insert_data->execute();
           
    }
}
?>