<?php


namespace app\core;

abstract class DbModel extends Model
{

    abstract public function tableName();
    abstract public function attributes();
    abstract public function primaryKey();
    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName(" . implode(',', $attributes) . ") VALUES( " . implode(',', $params) . ")");
        foreach($attributes as $attribute){
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;

    }
    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
    public  function findOne ($where){  ## [email=> abc@gmail.com]
        # call the tableName method in class extends DbModel
        
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode(
            "AND ",
            array_map(fn($attr) => "$attr=:$attr", $attributes)
        );

        $statement = self::prepare("SELECT * fROM $tableName WHERE $sql");
        foreach ($where as $key=>$item){
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        # fetchObject method essentially creates an object of the specified class 
        // and assigns the values from the row in the result set to the object's properties.
        return $statement->fetchObject(static::class);
                
    }
   
}

?>