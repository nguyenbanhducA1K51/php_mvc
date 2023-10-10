<?php 
namespace app\controllers;
use app\core\Application;
use app\core\middleware\BaseMiddleware;
class Controller{

    public string $layout='main';
    public string $action = "";
    public array $middlewares=[];
    protected array $middleewares = [];

    public function render ($view, $params){
        return Application ::$app->view->renderView($view,$params);
    }
    public function setLayout($layout){
        $this->layout=$layout;

    }
    public function  registerMiddleware (BaseMiddleware $middleware){
        $this->middlewares[] = $middleware;
    }
    public function getMiddlewares(){
        return $this->middlewares;
    }
}
?>