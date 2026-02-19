<?php
require_once 'db.php';
require_once 'question.php';


if (isset($_POST['submit'])) {

    $question =  $_POST['question'];
    $categorie =  $_POST['categorie'];
    $reponse1 =  $_POST['reponse1'];
    $reponse2 =  $_POST['reponse2'];
    $reponseTrue =  $_POST['reponseTrue'];

    if (empty($question) || empty($categorie) || empty($reponse1) || empty($reponse2) || empty($reponseTrue)) {
        echo "Tout les champs sont requits" ;
    }else{
       $quiz = new Question();
       $quiz->create($question,$categorie,$reponseTrue,$reponse1,$reponse2);
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
            <input type="text" name="question"><br>
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