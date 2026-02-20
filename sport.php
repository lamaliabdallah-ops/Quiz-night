<?php
require_once('header.php'); 
require_once('db.php');
$db = Database::getInstance();
$pdo = $db->getConnexion();

$data = $pdo->prepare('SELECT * FROM quiz WHERE categorie = :categorie');
$data->execute(['categorie' => 'sport']);
$data_question = $data->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Sport</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Quiz Sport</h2>
    <form method="POST">

    <section class="sport">
<?php 
foreach($data_question as $key => $value){
    
    echo "<p>" . $value['id'] . "</p>";
    echo "<h3>" . $value['question'] . "</h3>";
    echo "<input type='radio' name='".$questionName."' value='".$value['reponse1']."'> ";
    echo "<input type='radio' name='".$questionName."' value='".$value['reponse2']."'>";
    echo "<input type='radio' name='".$questionName."' value='".$value['reponseTrue']."'>";
}
?>

    </section>
            <button type="submit">Valider</button>

<?php require_once('footer.php'); 
?>
