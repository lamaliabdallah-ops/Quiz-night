<?php
session_start();
require_once 'classes/user.php';
require_once 'db.php';

require_once 'header.php';
$error = '';

if (isset($_POST['submit'])) {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    
    //verification
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        $error = "tous les champs sont requis";
    } elseif ($password !== $confirmPassword) {
        $error = "les mots de passe ne correspondent pas";
    } elseif (strlen($password) < 6) {
        $error = "Le mot de passe doit contenir 6 caracteres";
    } else {
        $user = new User();
        
    if ($user->emailexists($email)) {
            $error = "cet email existe deja";
    } else {
        if ($user->register($firstName, $lastName, $email, $password)) {
                header('Location: connexion.php?success=1');
                exit();
        } else {
            $error = "erreur lors de l'inscription";
            }
        }
}
}

require_once 'footer.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="stylee.css">
</head>
<body>
    <div class="auth-page">
        <div class="auth-container">
            <h1>Inscription</h1>
            
            <?php if (!empty($error)) { ?>
                <p class="error"><?php echo $error; ?></p>
            <?php } ?>
            
            <form method="post">
                <input type="text" name="firstName" placeholder="Prénom" required>
                <input type="text" name="lastName" placeholder="Nom" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <input type="password" name="confirm_password" placeholder="Confirmer le mot passe" required>
                <button type="submit" name="submit">S'inscrire</button>
            </form>
            
            <p>Vous avez deja un compte ?<a href="connexion.php">Connectez-vous</a></p>
        </div>
    </div>
</body>
</html>