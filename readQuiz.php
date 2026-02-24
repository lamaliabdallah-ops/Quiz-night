<?php
require_once 'db.php';

$database = Database::getInstance();
$pdo = $database->getConnexion();
$sql = "SELECT 
            quiz.id AS quiz_id,
            quiz.name AS quiz_name,
            categorie.name AS categorie_name,
            question_quiz.id AS question_id,
            question_quiz.question AS question,
            GROUP_CONCAT(reponses_quiz.reponse SEPARATOR ' | ') AS reponses
        FROM quiz
        INNER JOIN categorie 
            ON quiz.id_categorie = categorie.id
        INNER JOIN question_quiz 
            ON question_quiz.quiz_id = quiz.id
        INNER JOIN reponses_quiz 
            ON reponses_quiz.id_question_quiz = question_quiz.id
        GROUP BY question_quiz.id
        ORDER BY quiz.id";
$stmt = $pdo->prepare($sql);

$data = [];
$stmt->execute($data);

$resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Liste des Quiz</title>
</head>
<body>

<h2>Liste des Quiz</h2>

<a href="createQuiz.php">Créer un quiz</a>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Quiz</th>
            <th>Catégorie</th>
            <th>Question</th>
            <th>Réponses</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

<?php foreach ($resultats as $row): ?>
    <tr>
        <td><?= htmlspecialchars($row['quiz_name']) ?></td>
        <td><?= htmlspecialchars($row['categorie_name']) ?></td>
        <td><?= htmlspecialchars($row['question']) ?></td>
        <td><?= htmlspecialchars($row['reponses']) ?></td>
        <td>
            <a href="updateQuiz.php?id=<?= $row['quiz_id'] ?>">
                <button>Modifier</button>
            </a>

            <a href="deleteQuiz.php?id=<?= $row['quiz_id'] ?>" 
               onclick="return confirm('Supprimer ce quiz ?')">
                <button>Supprimer</button>
            </a>
        </td>
    </tr>
<?php endforeach; ?>

    </tbody>
</table>

</body>
</html>