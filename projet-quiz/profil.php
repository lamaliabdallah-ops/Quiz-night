<?php
session_start();
require_once 'db.php';

require_once 'header.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="stylee.css">
</head>
<body>
    <div class="auth-page">
        <div class="auth-container">
            <h1>Mon profil</h1>

            <p>Prenom : <?= $_SESSION["firstName"]; ?></p>
            <p>Nom : <?= $_SESSION["lastName"]; ?></p>
            <p>Email : <?= $_SESSION["email"]; ?></p>
            <p>Role : <?= $_SESSION["role"]; ?></p>

            <br>

            <a href="modifier_profil">Modifier le profil</a>
            <br>
            <a href="deconnexion.php">Se deconecter</a>
        </div>
    </div>
    
</body>
</html>