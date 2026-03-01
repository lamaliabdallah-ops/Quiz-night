<?php
session_start();
require_once 'classes/user.php';
require_once 'db.php';

require_once 'header.php';

$user = new User();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($user->login($email, $password)) {
            header('Location: profil.php');
            exit();
    } else {
            $error = "Email ou mot de passe incorrect";
        }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="stylee.css">
</head>
<body>
    <div class="auth-page">
        
        <div class="auth-container">
            <h1>Connexion</h1>
                 
                <form action="" method="post">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email"> <br/><br/>
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password"> <br/><br/>
                    <button type="submit" name="submit">Connexion</button>
                    <p>vous n'avez pas de compte <a href="inscription.php">S'inscrire</a></p>
                </form>
                <?php if(isset($error)) {
                    echo "<p>$error</p>";
                }
                ?>
        </div>
    </div>
    </body>
    </html>
    
<?php
require_once 'footer.php';
?>