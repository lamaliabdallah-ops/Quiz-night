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
   
    public function create($question,$categorie,$reponseTrue,$reponse1,$reponse2 ){
        $question =  secrityInput($_POST['question']);
        $categorie =  secrityInput($_POST['categorie']);
        $reponse1 =  secrityInput($_POST['reponse1']);
        $reponse2 =  secrityInput($_POST['reponse2']);
        $reponseTrue =  secrityInput($_POST['reponseTrue']);

        $insert_data = $this->pdo->prepare('INSERT INTO quiz(question,categorie,reponse1,reponse2,reponseTrue) VALUE(:question,:categorie,:reponse1,:reponse2,:reponseTrue)');
          $insert_data->bindValue(":question", $question, PDO::PARAM_STR);
        $insert_data->bindValue(":categorie", $categorie, PDO::PARAM_STR);
        $insert_data->bindValue(":reponse1", $reponse1 ,PDO::PARAM_STR);
        $insert_data->bindValue(":reponse2", $reponse2,PDO::PARAM_STR);
        $insert_data->bindValue(":reponseTrue", $reponseTrue,PDO::PARAM_STR);
        $insert_data->execute();
           
    }
}
?>