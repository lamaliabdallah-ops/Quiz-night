<?php
session_start();
require_once 'db.php';

// il permet de sécriser les input
function secrityInput($nameInput) {
    return trim(htmlspecialchars($nameInput));
}


if (isset($_POST['submit'])) {
    // vérification des input 
   $firstName =  secrityInput($_POST['firstName']);
   $lastName =  secrityInput($_POST['lastName']);
   $email =  secrityInput($_POST['email']);
   $password =  secrityInput($_POST['password']);
   $confirm_password =  secrityInput($_POST['confirm_password']);
    $message = '';
    // vérification si les champs sont remplie
   if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($password) && !empty( $confirm_password)) {
        // verification des mot de pass
        if ($password === $confirm_password ) {
            // vérifier si l'email existe ou bien 
            $verifyEmail = $pdo->prepare("SELECT * FROM user WHERE email =?");
            $verifyEmail->execute([$email]);
            if ($verifyEmail->rowCount() === 0) {
                $passwordHaching = password_hash($password, PASSWORD_DEFAULT);
                // insertion des données à la basse de données 
                $insertData = $pdo->prepare('INSERT INTO user(firstName, lastName, email, password ) VAlUES (:firstName, :lastName, :email, :password)');
                $insertData->bindValue(':firstName', $firstName, PDO::PARAM_STR);
                $insertData->bindValue(':lastName', $lastName);
                $insertData->bindValue(':email', $email);
                $insertData->bindValue(':password', $passwordHaching);
                // vérifier si les données sont bien inserer à la basse de données 
                if ($insertData->execute()){
                    $message = "inscription reuissi avec succés";
                    // redirection à la page de connexion 
                    header("location: connexion.php");
                }else{
                    $message = "erreur lors de l'inscription";
                }
            }else{
                $message = "l'email existe déja";
            }
        }else{
            $message = "les mot de passes ne sont pas identiques !";
        }
   }else{
         $message = "tous les champs sont requis !";
   }
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="connexion">

        <h1 class="page-title">Inscription</h1>
        
        <div class="container">
            <section>
                
                
                <form action="" method="post">
                    <label for="firstName">Prénom</label>
                    <input type="text" name="firstName"><br/><br/>
                    <label for="lastName">Nom</label>
                    <input type="text" name="lastName"><br/><br/>
                    <label for="email">Email</label>
                    <input type="email" name="email"><br/><br/>
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password"><br/><br/>
                    <label for="confirm_password">Confirmer le mot de passe</label>
                    <input type="password" name="confirm_password"><br/><br/>
                    
                    <input type="submit" name="submit" value="s'inscrire">
                    <p>Vous avez deja un compte <a href="connexion.php">Connectez-vous</a></p>
                </form>
            </section>
        </div>
    </div>
    </body>
    </html>