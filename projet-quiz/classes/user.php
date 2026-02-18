<?php
// classes/User.php

require_once __DIR__ . '/../db.php';

class User {
    private $pdo;

    public function __construct() {
        $db = Database::getInstance();
        $this->pdo = $db->getConnexion();
    }

    // Nettoyer les données
    private function clean($data) {
        return trim(htmlspecialchars($data));
    }

    // Inscrire un nouvel utilisateur
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

    // Vérifier si l'email existe déjà
    public function emailExists($email) {
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }

    // Connecter un utilisateur
    public function login($email, $password) {
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch();
            
            if (password_verify($password, $user['password'])) {
                // Stocker les infos en session
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

    // Récupérer un utilisateur par son ID
    public function getUserById($id) {
        $sql = "SELECT id, firstName, lastName, email, role FROM user WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Mettre à jour les informations de profil
    public function updateProfile($id, $firstName, $lastName, $email) {
        $firstName = $this->clean($firstName);
        $lastName = $this->clean($lastName);
        $email = $this->clean($email);
        
        $sql = "UPDATE user SET firstName = ?, lastName = ?, email = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$firstName, $lastName, $email, $id]);
    }

    // Mettre à jour le mot de passe
    public function updatePassword($id, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET password = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$hashedPassword, $id]);
    }

    // Vérifier si le mot de passe est correct
    public function checkPassword($id, $password) {
        $sql = "SELECT password FROM user WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        return password_verify($password, $user['password']);
    }
}