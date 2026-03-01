<?php

//charger le fichier a la bdd
require_once __DIR__ . '/../db.php';

//stocker la connexion pdo
class User {
    private $pdo;

    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnexion();
    }

//INSCRIPTION

    public function register($firstName, $lastName, $email, $password) {
        $firstName = trim($firstName);
        $lastName = trim($lastName);
        $email = trim($email);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO user (firstName, lastName, email, password, role) VALUES (?, ?, ?, ?, 'user')";
        //preparer la requete sql et la stocker 
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$firstName, $lastName, $email, $hashedPassword]);
    }

    public function emailexists($email) {
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }

//CONNEXION

    public function login($email, $password) {
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['firstName'] = $user['firstName'];
                $_SESSION['lastName'] = $user['lastName'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                return true;
            }
        }
        return false;
    }

    public function getuserbyid($id) {
        $sql = "SELECT id, firstName, lastName, email, role FROM user WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }


public function updateprofile($id, $firstName, $lastName, $email) {
        $firstName = trim($firstName);
        $lastName = trim($lastName);
        $email = trim($email);

        $sql = "UPDATE user SET firstName = ?, lastName = ?, email = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$firstName, $lastName, $email, $id]);
    }

    public function updatepassword($id, $currentPassword, $newPassword) {
        //recupérer le mot de passe actuel depuis la bdd
        $sql = "SELECT password FROM user WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $user = $stmt->fetch();

        //verifier que l'ancien mot de passe est correct
        if (!$user || !password_verify($currentPassword, $user['password'])) {
            return false;
        }

        //hasher et enregistrer le nouveau mot de passe
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET password = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$hashedPassword, $id]);
    }

    public function emailotheruser($email, $id) {
        //verifier si l'email est déjà pris par un AUTRE utilisateur
        $sql = "SELECT id FROM user WHERE email = ? AND id != ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email, $id]);
        return $stmt->rowCount() > 0;
    }

}