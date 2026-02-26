<?php
require_once 'db.php';
require_once 'quiz.php';
require_once 'question.php';
require_once 'reponse.php';
require_once 'categorie.php';

function securityInput($nameInput) {
    return trim(htmlspecialchars($nameInput));
}

$id_quiz = (int)$_GET['id'];
$message = '';

$quiz = new Quiz();
$quizData = $quiz->getIdQuiz($id_quiz);

$q = new Question();
$questionActuelle = $q->getQuizId($id_quiz);

$r = new Reponse();
$reponsesData = $r->getQuestionId($questionActuelle['id']);

if (isset($_POST['submit'])) {
    $name = securityInput($_POST['name']);
    $id_categorie = (int)$_POST['id_categorie'];
    $question = securityInput($_POST['question']);
    $reponse1 = securityInput($_POST['reponse1']);
    $reponse2 = securityInput($_POST['reponse2']);
    $isTrue = securityInput($_POST['isTrue']);

    if (empty($name) || empty($id_categorie) || empty($question) || empty($reponse1) || empty($reponse2) || empty($reponseTrue)) {
        $message = "Tous les champs sont requis.";
    } else {
        try {
            $quiz->update($id_quiz, $name, $id_categorie);
            $q->update($questionActuelle['id'], $question);
            $r->update($reponsesData[0]['id'], $reponse1, 0);
            $r->update($reponsesData[1]['id'], $reponse2, 0);
            $r->update($reponsesData[2]['id'], $reponseTrue, 1);

            $message = " Quiz modifié avec succès !";
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
    <title>Modifier le Quiz</title>
</head>
<body>
    <?php if ($message): ?>
        <p><?= $message ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <h3>Le Quiz</h3>
        <label>Nom du Quiz</label>
        <input type="text" name="name" value="<?= htmlspecialchars($quizData['name']) ?>"><br>

        <label>Catégorie</label>
        <select name="id_categorie">
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>">
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <h3>La Question</h3>
        <label>Question</label>
        <input type="text" name="question" value="<?= htmlspecialchars($questionActuelle['question']) ?>"><br>

        <h3>Les Réponses</h3>
        <label>Réponse 1</label>
        <input type="text" name="reponse1" value="<?= htmlspecialchars($reponsesData['reponse']) ?>"><br>

        <label>Réponse 2</label>
        <input type="text" name="reponse2" value="<?= htmlspecialchars($reponsesData['reponse']) ?>"><br>

        <label>Bonne Réponse</label>
        <input type="text" name="reponseTrue" value="<?= htmlspecialchars($reponsesData['reponse']) ?>"><br>

        <input type="submit" name="submit" value="Modifier">
    </form>
    <a href="readQuiz.php">Annuler</a>
</body>
</html>