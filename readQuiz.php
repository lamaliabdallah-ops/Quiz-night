<?php
require_once 'db.php';
require_once 'quiz.php';
require_once 'question.php';
require_once 'reponse.php';
require_once 'categorie.php';

$quiz = new Quiz();
$resultat = $quiz->getAll();

$categorie = new Categorie();
$resultatCategorie = $categorie->getAll();

$question = new Question();
$resultatQuestion = $question->getAll();

$reponse = new Reponse();
$resultatReponse = $reponse->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="createQuiz.php">Creer un quiz</a> 
<?php
foreach ($resultat as $quiz) {
    echo "<table border='1'>";
    echo "<thead>
            <tr>
                <th>Quiz</th>
                <th>Catégorie</th>
                <th>Question</th>
                <th>Réponse</th>
                <th>Actions</th>
            </tr>
          </thead>";
    echo "<tbody>";

    foreach ($resultatQuestion as $question) {
        foreach ($resultatReponse as $reponse) {
            if ($reponse['id_question_quiz'] == $question['id']) {
                foreach ($resultatCategorie as $categorie) {
                    echo "<tr>";
                    echo "<td>" . $quiz['name'] . "</td>";
                    echo "<td>" . $categorie['name'] . "</td>";
                    echo "<td>" . $question['question'] . "</td>";
                    echo "<td>" . $reponse['reponse'] . "</td>";
                    echo "<td> 
                    <a href='updateQuiz.php?id=" . $quiz['id'] . "'> <button>Modifier</button> </a>
                    <a href='deleteQuiz.php?id=" . $quiz['id'] ."'> <button>Supprimer</button> </a>
                        </td>";
                    echo "</tr>";
             }
         }
     }
    }

    echo "</tbody>";
    echo "</table><br>";
}
?>

</body>
</html>