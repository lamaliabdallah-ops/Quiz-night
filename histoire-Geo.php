<?php
require_once 'db.php';
include('header.php'); 

$db = Database::getInstance();
$conn = $db->getConnexion();

$sql = "SELECT q.id, q.question 
        FROM question_quiz q
        JOIN quiz qz ON qz.id = q.quiz_id
        WHERE qz.id_categorie = 4";

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
<title>Quiz Histoire & Géographie</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<h3>Quiz Histoire & Géographie</h3>

<form method="POST" action="resultat.php">
<input type="hidden" name="id_categorie" value="4">
<input type="hidden" name="nom_categorie" value="Histoire & Géographie">

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

<a href="resultat.php"><button type="submit" class="btn-valider">Valider</button></a>
</form>

<?php include('footer.php'); ?>
</body>
