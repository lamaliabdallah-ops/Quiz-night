<?php
require_once 'db.php';
require_once 'quiz.php';
require_once 'question.php';
require_once 'reponse.php';
require_once 'categorie.php';


function securityInput($nameInput) {
        return trim(htmlspecialchars($nameInput));
    }
$message = '';

if (isset($_POST['submit'])) {
    $name = securityInput($_POST['name']);
    $id_categorie = (int)securityInput($_POST['id_categorie'] );
    $question = securityInput($_POST['question']);
    $reponse1 = securityInput($_POST['reponse1']);
    $reponse2 = securityInput($_POST['reponse2']);
    $isTrue= securityInput($_POST['isTrue']);

    if (empty($name) || empty($id_categorie) || empty($question) || empty($reponse1) || empty($reponse2) || empty($isTrue)) {
        $message = "Tous les champs sont requis.";
    } else {
        try {
            
            $quiz = new Quiz();
            $quiz->create($name, $id_categorie);
            $quiz_id = $quiz->create($name, $id_categorie);

          
            $q = new Question();
            $id_question_quiz = $q->create($question, $quiz_id);

          
            $r = new Reponse();
            $r->create($id_question_quiz, $reponse1, 0); 
            $r->create($id_question_quiz, $reponse2, 0); 
            $r->create($id_question_quiz, $isTrue, 1); 

            $message = " Quiz ajoutés avec succès !";
        } catch (Exception $e) {
            $message = " Erreur : " . $e->getMessage();
        }
    }
}

$categorie  = new Categorie();
$categories = $categorie->getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un Quiz</title>
</head>
<body>
    <?php if ($message): ?>
        <p><?= $message ?></p>
    <?php endif; ?>

    <form action="" method="post">

        <h3>Le Quiz</h3>
        <label>Nom du Quiz</label>
        <input type="text" name="name"><br>

        <label>Catégorie</label>
        <select name="id_categorie">
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
            <?php endforeach; ?>
        </select><br>
        <label>Question</label>
        <input type="text" name="question"><br>
        <label>Réponse 1</label>
        <input type="text" name="reponse1"><br>

        <label>Réponse 2</label>
        <input type="text" name="reponse2"><br>

        <label>Bonne Réponse</label>
        <input type="text" name="isTrue"><br>

        <input type="submit" name="submit" value="Créer">
    </form>
    <a href="readQuiz.php">Annuler</a>
</body>
</html>
