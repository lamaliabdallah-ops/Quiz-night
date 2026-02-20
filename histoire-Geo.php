<?php
require_once('db.php');
 require_once('header.php'); 

$db = Database::getInstance();
$pdo = $db->getConnexion();

$data = $pdo->prepare('SELECT * FROM quiz WHERE categorie = :categorie');
$data->execute(['categorie' => 'histoireGeographie']);
$data_question = $data->fetchAll(PDO::FETCH_ASSOC);

// Debug : vérifier les données
// var_dump($data_question);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz histoire Geographie </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Quiz histoire Geographie </h2>
    <form method="POST" action="resultat.php">

    <section>
<?php 
foreach($data_question as $key => $value){
    $questionName = 'question' . $value['id']; // unique par question
    
    echo "<p>" . $value['id'] . "</p>";
    echo "<h3>" . $value['question'] . "</h3>";
    echo "<input type='radio' name='".$questionName."' value='".$value['reponse1']."'> ".$value['reponse1']."<br>";
    echo "<input type='radio' name='".$questionName."' value='".$value['reponse2']."'> ".$value['reponse2']."<br>";
    echo "<input type='radio' name='".$questionName."' value='".$value['reponseTrue']."'> ".$value['reponseTrue']."<br>";
}
?>

    </section>
            <button type="submit">Valider</button>


<?php require_once('footer.php'); 
?>
