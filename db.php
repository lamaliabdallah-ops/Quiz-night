<?php
// Login à la base de donnée avec des variables, faciles a modifié si changement de mot de passe ou de db




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
