<?php
namespace app\core;

use app\core\Application;
use PDO;
class Database
{
    public PDO $pdo;        
    public function  __construct(array $config)
    {   
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';     
        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    }
    public function applyMigration(){
        # this will create table migrations if not exist
        $this->createMigrationTable();
        # appliedMigrations will return the the all value in mrigration columns
        $appliedMigrations=$this->getAppliedMigrations();
        # when appliedMigrations return only ['m001_initial.php]
       
        $newMigrations=[];
        $files=scandir( Application::$ROOT_DIR.'/migrations');
        $toApplyMigrations=array_diff($files,$appliedMigrations);
        # this will return ['.','..','m002_initial.php]
        foreach($toApplyMigrations as  $migration){
            if ($migration==='.' || $migration==='..'){
                continue;
            }          
            require_once Application::$ROOT_DIR.'/migrations/'.$migration;
            $className=pathinfo($migration,PATHINFO_FILENAME);
            # what is purpose of this command: seems like it returrn the class name
            $instance=new $className();
            $this->log("Applying migration $className ");
            $instance->up();
            $newMigrations[]=$migration;
            
        }   
        if (!empty($newMigrations)){
            $this->saveMigrations($newMigrations);

        }else{
             $this->log("All migration are applied");
        }
        
}

public function saveMigrations(array $migrations){

    $str= implode (",", array_map(fn($m)=>"('$m')", $migrations));

    # what is preparre right here
    $statement=$this->pdo->prepare("INSERT INTO migrations(migration) VALUES
    $str
    ");
    $statement->execute();
}
    public function createMigrationTable(){
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations(
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)   
            ENGINE=INNODB;");
    }
    public function getAppliedMigrations(){

       $statement= $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }
    protected function log ($message){
        echo '['.date('Y-m-d H:i:s').'] - '.$message.PHP_EOL;
    }

    public function prepare($sql){
        return $this->pdo->prepare($sql);
    }
}
