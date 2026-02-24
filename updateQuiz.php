<?php
require_once 'db.php';
require_once 'quiz.php';
require_once 'question.php';
require_once 'reponse.php';
require_once 'categorie.php';

function securityInput($value) {
    return trim(htmlspecialchars($value));
}

 $id_quiz = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = '';

$quiz = new Quiz();
$quizData = $quiz->getIdQuiz($id_quiz);

$q = new Question();
$questions = $q->getQuizId($id_quiz);
$questionActuelle = $questions[0] ?? null;
$r = new Reponse();
$reponsesData = $r->getQuestionId($questionActuelle['id'] ?? 0);

$categorie = new Categorie();
$resultatCategorie = $categorie->getAll();


if (isset($_POST['submit'])) {

    $name = securityInput($_POST['name']);
    $id_categorie = (int)$_POST['id_categorie'];
    $question = securityInput($_POST['question']);
    $reponse1 = securityInput($_POST['reponse1']);
    $reponse2 = securityInput($_POST['reponse2']);
    $isTrue = securityInput($_POST['isTrue']); 

  
    if (empty($name) || empty($id_categorie) || empty($question) || empty($reponse1) || empty($reponse2) || empty($isTrue)) {
        $message = "Tous les champs sont requis.";
    } else {
        try {
        
            $quiz->update($id_quiz, $name, $id_categorie);
           
            $q->update($questionActuelle['id'], $question);

            $r->update($reponsesData[0]['id'], $reponse1, 0);
            $r->update($reponsesData[1]['id'], $reponse2, 0);
            $r->update($reponsesData[2]['id'], $isTrue, 1);

            $message = "Quiz modifié avec succès !";
        } catch (Exception $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    }
}
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

<form  method="post">
    <h3>Le Quiz</h3>

    <label>Nom du Quiz</label>
    <input type="text" name="name" value="<?= htmlspecialchars($quizData['name'] ) ?>"><br>

    <label>Catégorie</label>
    <select name="id_categorie">
        <?php foreach ($resultatCategorie as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == ($quizData['id_categorie'] ?? 0)) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['name']) ?>
            </option>
        <?php endforeach; ?>
    </select><br>


    <label>Question</label>
    <input type="text" name="question" value="<?= htmlspecialchars($questionActuelle['question']) ?>"><br>

    <label>Réponse 1</label>
    <input type="text" name="reponse1" value="<?= htmlspecialchars($reponsesData[0]['reponse'] ) ?>"><br>

    <label>Réponse 2</label>
    <input type="text" name="reponse2" value="<?= htmlspecialchars($reponsesData[1]['reponse'] ) ?>"><br>

    <label>Bonne Réponse</label>
    <input type="text" name="isTrue" value="<?= htmlspecialchars($reponsesData[2]['reponse'] ) ?>"><br>

    <input type="submit" name="submit" value="Modifier">
</form>

<a href="readQuiz.php">Annuler</a>

</body>
</html>