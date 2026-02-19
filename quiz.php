<?php

class Quiz{
     private $pdo;
   
     public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnexion();
    }
    private function secrityInput($nameInput) {
        return trim(htmlspecialchars($nameInput));
        
    }
   
    public function create($name, $id_categorie){
    
        $insert_data = $this->pdo->prepare('INSERT INTO quiz(name, id_categorie) VALUE(:name, :id_categorie)');
        $insert_data->bindValue(":name", $name, PDO::PARAM_STR);
        $insert_data->bindValue(":id_categorie", $id_categorie, PDO::PARAM_INT);
        $insert_data->execute();
           
    }
}
?>