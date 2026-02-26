<?php
require_once 'db.php';

class Quiz {
    private $pdo;

    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnexion();
    }

    private function securityInput($nameInput) {
        return trim(htmlspecialchars($nameInput));
    }

   public function create($name, $id_categorie) {
    $data = $this->pdo->prepare(
        'INSERT INTO quiz (name, id_categorie) VALUES (:name, :id_categorie)'
    );
    $data->bindValue(':name',$this->securityInput($name),PDO::PARAM_STR);
    $data->bindValue(':id_categorie', $id_categorie, PDO::PARAM_INT);
    $data->execute();
    return $this->pdo->lastInsertId(); 
}

    public function getAll() {
        $data = $this->pdo->prepare('SELECT * FROM  quiz');
        $data->execute();
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByCategorie($id_categorie) {
        $data = $this->pdo->prepare('SELECT * FROM quiz WHERE id_categorie = :id_categorie');
        $data->bindValue(':id_categorie', $id_categorie, PDO::PARAM_INT);
        $data->execute();
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getIdQuiz($id) {
        $data = $this->pdo->prepare('SELECT * FROM quiz WHERE id = :id');
        $data->bindValue(':id', $id, PDO::PARAM_INT);
        $data->execute();
        return $data->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $name, $id_categorie) {
        $data = $this->pdo->prepare(
            'UPDATE quiz SET name = :name, id_categorie = :id_categorie WHERE id = :id'
        );
        $data->bindValue(':name', $this->securityInput($name), PDO::PARAM_STR);
        $data->bindValue(':id_categorie', $id_categorie, PDO::PARAM_INT);
        $data->bindValue(':id', $id, PDO::PARAM_INT);
        return $data->execute();
    }

    public function delete($id) {
        $data = $this->pdo->prepare('DELETE FROM quiz WHERE id = :id');
        $data->bindValue(':id', $id, PDO::PARAM_INT);
        return $data->execute();
    }
}
?>