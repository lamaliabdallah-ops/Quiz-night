<?php
// Login à la base de donnée avec des variables, faciles a modifié si changement de mot de passe ou de db
// $host = 'mourtalla-sall.students-laplateforme.io';
// $dbname = 'mourtalla-sall_QuizNight';
// $username = 'Quiz_night';
// $password = 'QuizNight123@';     

// try {
//     $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     // On utilise PDO pour se connecter à la base de donnée
// } catch (PDOException $e) {
//     die("Erreur de connexion : " . $e->getMessage());
// }
class Database{
    private static $instance;
    private PDO $pdo ;
    
    private function __construct()
    {
        $this->pdo = new PDO("mysql:host=mourtalla-sall.students-laplateforme.io;
        dbname=mourtalla-sall_QuizNight;charset=utf8", 
        'Quiz_night', 'QuizNight123@',
        [
           PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
        ]); 
        
    }
    public static function getInstance(){
        if (self::$instance === NULL) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    public function getConnexion(): PDO{
        return $this->pdo;
    }
}
// $ConnexionDB = Database::getInstance();
// $ConnexionDB->pdo->exec();
?>
