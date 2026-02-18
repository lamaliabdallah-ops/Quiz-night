<?php
// classes/User.php

require_once __DIR__ . '/../db.php';

class User {
    private $pdo;

    public function __construct() {
        // Utiliser ton Singleton
        $db = Database::getInstance();
        $this->pdo = $db->getConnexion();
    }

    // Nettoyer les données (sécurité)
    private function clean($data) {
        return trim(htmlspecialchars($data));
    }

    // INSCRIPTION
    public function register($firstName, $lastName, $email, $password) {
        $firstName = $this->clean($firstName);
        $lastName = $this->clean($lastName);
        $email = $this->clean($email);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO user (firstName, lastName, email, password, role) 
                VALUES (?, ?, ?, ?, 'user')";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$firstName, $lastName, $email, $hashedPassword]);
    }

    // Vérifier si l'email existe
    public function emailExists($email) {
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }

    // CONNEXION
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

    // RÉCUPÉRER UN UTILISATEUR
    public function getUserById($id) {
        $sql = "SELECT id, firstName, lastName, email, role FROM user WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // MODIFIER LE PROFIL
    public function updateProfile($id, $firstName, $lastName, $email) {
        $firstName = $this->clean($firstName);
        $lastName = $this->clean($lastName);
        $email = $this->clean($email);
        
        $sql = "UPDATE user SET firstName = ?, lastName = ?, email = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$firstName, $lastName, $email, $id]);
    }

    // MODIFIER LE MOT DE PASSE
    public function updatePassword($id, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET password = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$hashedPassword, $id]);
    }

    // VÉRIFIER L'ANCIEN MOT DE PASSE
    public function checkPassword($id, $password) {
        $sql = "SELECT password FROM user WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        return password_verify($password, $user['password']);
    }
}
