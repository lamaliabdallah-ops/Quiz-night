# Requete SQL

SELECT quiz.id, quiz.name, categorie.name FROM `quiz` INNER JOIN categorie ON quiz.id_categorie = categorie.id;