<?php
session_start();
require_once 'db.php';
require_once 'question.php';


if (isset($_POST['submit'])) {
    $db = Database::getInstance();
    $pdo = $db->getConnexion();

    $question = secrityInput($_POST['question']);
    $categorie =  secrityInput($_POST['categorie']);
    $reponse1 =  secrityInput($_POST['reponse1']);
    $reponse2 =  secrityInput($_POST['reponse2']);
    $reponseTrue =  secrityInput($_POST['reponseTrue']);
    
   
        $insert_data = $pdo->prepare('UPDATE quiz set  question = :question,categorie = :categorie,reponse1 = :reponse1,reponse2 =:reponse2,reponseTrue = :reponseTrue WHERE id= :id');
        $insert_data->bindValue(":question", $question);
        $insert_data->bindValue(":categorie", $categorie);
        $insert_data->bindValue(":reponse1", $reponse1);
        $insert_data->bindValue(":reponse2", $reponse2);
        $insert_data->bindValue(":reponseTrue", $reponseTrue);
        $insert_data->bindValue(":id", $_SESSION['id']);
        if ($insert_data->execute()) {
            echo "quiz modifier avec succés !";
        }else{
            echo "erreur à la modification du quiz";
        }
    

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz</title>
</head>
<body>
   
     <section>
        <form action="" method="post">
            <label for="Question">Question</label>
            <input type="text" name="question" value=<?=  ?>><br>
            <label for="categorie">Categorie</label>
            <input type="text" name="categorie"><br>
            <label for="Reponse1">Reponse1</label>
            <input type="text" name="reponse1"><br>
            <label for="Reponse2">Reponse2</label>
            <input type="text" name="reponse2"><br>
            <label for="ReponseTrue">ReponseTrue</label>
            <input type="text" name="reponseTrue"><br>
            <input type="submit" name="submit" value="Validez">
        </form>
            <a href="dashbord.php">Annuler</a>
    </section>
</body>
</html>