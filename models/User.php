<?php 
namespace app\models;
use app\core\DbModel;
// require_once __DIR__."/Model.php";
class User extends DbModel{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = 2;


    public string $firstname='';
    public string $lastname ='';
    public string $email='';
    public int $status = self::STATUS_INACTIVE;
    public string $password='';
    public string $passwordConfirm='';


    public function tableName():string{
        return 'users';
        }
    public function save(){
        $this->status = self::STATUS_ACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        return parent::save();
        
    }
     public function attributes(){
        return ['firstname', 'lastname', 'email', 'password','status'];
    }
    public function labels(){
        return [
            'firstname' => 'First name',
            'lastname' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'passwordConfirm' => ' Confirm password'
        ];
    }
    public function rules(){
        return [
            # why "self" and "this"   different
            "firstname"=> [self::RULE_REQUIRED],
            "lastname"=> [self::RULE_REQUIRED],
            #check against email column of datatbase of class Use
            "email"=>[self::RULE_REQUIRED,self::RULE_EMAIL,[self::RULE_UNIQUE, 'class'=> self::class]],
            "password"=> [self::RULE_REQUIRED, [self::RULE_MIN,'min'=>2],[self::RULE_MAX,'max'=>10]],
            "passwordConfirm"=>[self::RULE_REQUIRED,[self::RULE_MATCH,'match'=>'password']]

        ];
    }


    
}
?>