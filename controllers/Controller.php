<?php 
namespace app\controllers;
// require_once __DIR__."\core\Application.php";
use app\core\Application;
class Controller{

    public string $layout='main';

    public function render ($view, $params){
        return Application ::$app->router->renderView($view,$params);
    }
    public function setLayout($layout){
        $this->layout=$layout;

    }
}
?>