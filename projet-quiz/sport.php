<?php
require_once 'db.php';
include('header.php'); 

$db = Database::getInstance();
$conn = $db->getConnexion();

$sql = "SELECT q.id, q.question 
        FROM question_quiz q
        JOIN quiz qz ON qz.id = q.quiz_id
        WHERE qz.id_categorie = 3";

$result = $conn->query($sql);
$questions = $result->fetchAll(PDO::FETCH_ASSOC);

$sql2 = "SELECT * FROM reponses_quiz";
$result2 = $conn->query($sql2);
$reponses = $result2->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Quiz Sport</title>
<link rel="stylesheet" href="index.css">
</head>
<body>

<h3>Quiz Sport</h3>

<form method="POST" action="resultat.php">
<input type="hidden" name="id_categorie" value="3">
<input type="hidden" name="nom_categorie" value="Sport">

<?php
foreach($questions as $q){
    echo "<div class='question-block'>";
    echo "<p class='question-texte'>" . $q['question'] . "</p>";
    echo "<div class='reponses'>";
    foreach($reponses as $r){
        if($r['id_question_quiz'] == $q['id']){
            echo "<label class='reponse-label'>";
            echo "<input type='radio' name='rep_" . $q['id'] . "' value='" . $r['isTrue'] . "'>";
            echo $r['reponse'];
            echo "</label>";
        }
    }
    echo "</div>";
    echo "</div>";
}
?>
<div class="btn-group">
    <button type="submit" class="btn-valider">Valider</button>
    <a href="Tous les quizz.php" class="btn-annuler">Annuler</a>
</div>
</form>

<?php include('footer.php'); ?>
