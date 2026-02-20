<?php
 require_once('header.php'); 

require_once('db.php');
$db = Database::getInstance();
$pdo = $db->getConnexion();

$data = $pdo->prepare('SELECT * FROM categorie');
$data->execute(['categorie' => 'informatique']);
$data_question = $data->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Informatique</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Quiz Informatique</h2>
    <form method="POST" action="resultat.php">

    <section>
<?php 
foreach($data_question as $key => $value){
    
    echo "<p>" . $value['name'] . "</p>";
    echo "<h3>" . $value['question'] . "</h3>";
//     echo "<input type='radio' name='".$questionName."' value='".$value['reponse1']."'> ".$value['reponse1']."<br>";
//     echo "<input type='radio' name='".$questionName."' value='".$value['reponse2']."'> ".$value['reponse2']."<br>";
//     echo "<input type='radio' name='".$questionName."' value='".$value['reponseTrue']."'> ".$value['reponseTrue']."<br>";
}
?>

    </section>
            <button type="submit">Valider</button>


<?php require_once('footer.php'); 
?>
