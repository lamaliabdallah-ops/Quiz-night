<?php 
require 'db.php';

class Reponse{
     private $pdo;
   
     public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnexion();
    }
    private function secrityInput($nameInput) {
        return trim(htmlspecialchars($nameInput));
        
    }
   
    public function create($id_questionquiz,$reponse, $reponseTrue){
    
        $insert_data = $this->pdo->prepare('INSERT INTO quiz(id_questionquiz,reponse,reponseTrue) VALUE(:name,:id_categorie)');
        $insert_data->bindValue(":id_questionquiz", $id_questionquiz, PDO::PARAM_INT);
        $insert_data->bindValue(":reponse", $reponse, PDO::PARAM_STR);
        $insert_data->bindValue(":reponseTrue", $reponseTrue, PDO::PARAM_STR);
        $insert_data->execute();
           
    }
}
?>