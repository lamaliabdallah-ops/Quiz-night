<?php
require_once 'db.php';
include('header.php'); 

$db = Database::getInstance();
$conn = $db->getConnexion();

$id_categorie  = $_POST['id_categorie'];
$nom_categorie = $_POST['nom_categorie'];

$r1 = $conn->prepare("SELECT q.id, q.question FROM question_quiz q JOIN quiz qz ON qz.id = q.quiz_id WHERE qz.id_categorie = ?");
$r1->execute([$id_categorie]);
$questions = $r1->fetchAll(PDO::FETCH_ASSOC);

$r2 = $conn->prepare("SELECT * FROM reponses_quiz");
$r2->execute([]);
$reponses = $r2->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Résultat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h3>Résultat - <?php echo $nom_categorie; ?></h3>

<?php
foreach($questions as $q){
    echo "<div class='question-block'>";
    echo "<p class='question-texte'>" . $q['question'] . "</p>";

    foreach($reponses as $r){
        if($r['id_question_quiz'] == $q['id']){
            if($r['isTrue'] == 1){
                echo "<p>" . $r['reponse'] . "  Bonne réponse</p>";
            } else {
                echo "<p>" . $r['reponse'] . "  Mauvaise réponse</p>";
            }
        }
    }

    echo "</div>";
}
?>

<?php include('footer.php'); ?>
</body>
</html>