<?php 
namespace app\models;
use app\core\Model;
// require_once __DIR__."/Model.php";
class RegisterModel extends Model{


    public string $firstname='';
    public string $lastname ='';
    public string $email='';
    public string $password='';
    public string $passwordConfirm='';

    public function register(){
        
    }
    public function rules(){
        return [
            # why "self" and "this"   different
            "firstname"=> [self::RULE_REQUIRED],
            "lastname"=> [self::RULE_REQUIRED],
            "email"=>[self::RULE_REQUIRED,self::RULE_EMAIL],
            "password"=> [self::RULE_REQUIRED, [self::RULE_MIN,'min'=>8],[self::RULE_MAX,'max'=>10]],
            "passwordConfirm"=>[self::RULE_REQUIRED,[self::RULE_MATCH,'match'=>'password']]

        ];
    }


    
}
?>