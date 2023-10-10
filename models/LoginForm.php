<?php

namespace app\models;


use app\core\DbModel;
use app\core\Model;
use app\core\Application;

class LoginForm extends Model
{
    public string $email="";
    public string $password="";

    public function rules()
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }
    public  function  tableName(){
        return "users";
    }
    public function attributes(){
        return ['email', "password"];
    }
    public function login()
    {
      
        $user = (new User() )-> findOne(['email'=>$this->email]);
       
        if (!$user) {
            $this->addError('email', 'User does not exist witht this email');
            return False;
        }
        if (!password_verify($this->password,$user->password)){
           
            $this->addError('password', 'Password is incorrect');

            return False;
                }
        return Application :: $app->login($user);
        // return True;

    }
   
    
}

?>