<?php require_once('header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>quizz</title>
</head>
<body>
<main>
        <h2>Selectionner un Quiz</h2>

</main>
<div class="container">

    <div class="quiz">
        <h3>Histoire et Géographie</h3>
        <a href="histoire-Geo">Jouer</a>
    </div>

    <div class="quiz">
        <h3>Sports</h3>
        <a href="sport.php">Jouer</a>
    </div>

    <div class="quiz">
        <h3>Informatique</h3>
        <a href="informatique.php">Jouer</a>
    </div>

</div>

<?php
require_once 'db.php';


require_once('footer.php'); ?>
