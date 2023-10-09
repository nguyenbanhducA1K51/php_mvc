<?php

namespace app\models;
use app\core\Model;

class LoginForm extends Model {
    public string $email;
    public string $password;

    public function rules(){
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }
    public function login(){
        User::findOne(['email=>$this->email']);
        Application::$app->login();
    }
}

?>