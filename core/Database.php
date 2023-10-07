<?php
namespace app\core;

use app\core\Application;

class Database
{
    public \PDO $pdo;

    public function  __construct(array $config)
    {
        echo '<pre>';
        var_dump($config['dsn'], $config['user']);
        echo '</pre>';
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        $reflection = new \ReflectionClass("PDO");

// Print class information and location
        echo 'Class Name: ' . $reflection->getName() . '<br>';
        echo 'Class Location: ' . $reflection->getFileName() . '<br>';

        // $db= new \PDO("mysql:host=localhost;dbname=db_iis", "user", "user");
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    public function applyMigration(){
        $this->createMigrationTable();
        $this->getAppliedMigrations();
        $files=scandir( Application::$ROOT_DIR.'/migrations');
        echo '<pre>';
        var_dump($files);
        echo '</pre>';
    }
    public function createMigrationTable(){
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations(

            id INT AUTO_INCREMENT PRIMARY_KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
        );
    }
    public function getAppliedMigrations(){

       $statement= $this->pdo->prepare("SELECT migration FROM migration");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }
}
