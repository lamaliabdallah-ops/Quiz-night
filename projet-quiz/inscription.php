<?php
session_start();
require_once 'classes/User.php';
require_once 'db.php';

$error = '';

if (isset($_POST['submit'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    
    // Vérifications simples
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        $error = "Tous les champs sont requis";
    } elseif ($password !== $confirmPassword) {
        $error = "Les mots de passe ne correspondent pas";
    } elseif (strlen($password) < 6) {
        $error = "Le mot de passe doit contenir au moins 6 caractères";
    } else {
        $user = new User();
        
        if ($user->emailExists($email)) {
            $error = "Cet email existe déjà";
        } else {
            if ($user->register($firstName, $lastName, $email, $password)) {
                header('Location: connexion.php?success=1');
                exit();
            } else {
                $error = "Erreur lors de l'inscription";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Inscription</h1>
        
        <?php 
        if (!empty($error)) {
            echo '<p class="error">' . $error . '</p>';
        }
        ?>
        
        <form method="post">
            <input type="text" name="firstName" placeholder="Prénom" required>
            <input type="text" name="lastName" placeholder="Nom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="password" name="confirm_password" placeholder="Confirmer" required>
            <button type="submit" name="submit">S'inscrire</button>
        </form>
        
        <p>Déjà un compte ? <a href="connexion.php">Connectez-vous</a></p>
    </div>
</body>
</html>