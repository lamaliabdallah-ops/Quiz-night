<?php
session_start();
require_once 'db.php';
require_once 'classes/user.php';
require_once 'header.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

$user = new User();
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // MODIFIER LE PROFIL
    if (isset($_POST['update_profile'])) {
        $firstName = trim($_POST['firstName']);
        $lastName  = trim($_POST['lastName']);
        $email     = trim($_POST['email']);

        if ($user->emailotheruser($email, $_SESSION['user_id'])) {
            $error = "Cet email est déjà utilisé.";
        } else {
            $user->updateprofile($_SESSION['user_id'], $firstName, $lastName, $email);
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName']  = $lastName;
            $_SESSION['email']     = $email;
            $success = "Profil mis à jour avec succès.";
        }
    }

    // MODIFIER LE MOT DE PASSE
    if (isset($_POST['update_password'])) {
        $currentPassword = $_POST['currentPassword'];
        $newPassword     = $_POST['newPassword'];

        if (!$user->updatepassword($_SESSION['user_id'], $currentPassword, $newPassword)) {
            $error = "Mot de passe actuel incorrect.";
        } else {
            $success = "Mot de passe modifié avec succès.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le profil</title>
    <link rel="stylesheet" href="stylee.css">
</head>
<body>
<div class="auth-page">
    <div class="auth-container">
        <h1>Modifier le profil</h1>

        <?php if ($error)   echo "<p style='color:red'>$error</p>"; ?>
        <?php if ($success) echo "<p style='color:green'>$success</p>"; ?>

        <!-- Formulaire infos personnelles -->
        <form action="" method="post">
            <label for="firstName">Prénom</label>
            <input type="text" name="firstName" id="firstName" value="<?= $_SESSION['firstName'] ?>"><br><br>

            <label for="lastName">Nom</label>
            <input type="text" name="lastName" id="lastName" value="<?= $_SESSION['lastName'] ?>"><br><br>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= $_SESSION['email'] ?>"><br><br>

            <label for="currentPassword">Mot de passe actuel</label>
            <input type="password" name="currentPassword" id="currentPassword"><br><br>

            <label for="newPassword">Nouveau mot de passe</label>
            <input type="password" name="newPassword" id="newPassword"><br><br>

            <button type="submit" name="update_profile">Mettre à jour</button>
        </form>

        <br>
        <a href="profil.php">Retour au profil</a>
    </div>
</div>
</body>
</html>

<?php require_once 'footer.php'; ?>