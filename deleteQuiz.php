<?php
require_once 'db.php';
require_once 'quiz.php';
require_once 'question.php';
require_once 'reponse.php';


$id_quiz = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_quiz <= 0) {
    die("ID du quiz invalide.");
}

$quiz = new Quiz();
$question = new Question();
$reponse = new Reponse();

$questions = $question->getQuizId($id_quiz);

foreach ($questions as $quest) {
    $reponses = $reponse->getQuestionId($quest['id']);
    foreach ($reponses as $r) {
        $reponse->delete($r['id']);
    }
}


foreach ($questions as $q) {
    $question->delete($q['id']);
}

// Supprimer le quiz
$quiz->delete($id_quiz);

// Redirection vers la liste des quiz
header("Location: readQuiz.php?message=Quiz supprimé avec succès");
exit;