<?php

namespace app\core;
use app\controllers\Controller;
require_once __DIR__."/Database.php";
use app\core\Request;
use app\core\Router;
use app\core\Session;
use app\core\View;
class Application
{
    public string $layout = 'main';

    public static Application $app;
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;
    public Database $db;
    public Session $session;
    public ?DbModel $user ;
    public View $view;
    public string $userClass;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self :: $app =$this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->db=new Database($config['db']);
        $this->session = new Session();
        $this->userClass = $config['userClass'];
        $this->view = new View();
        $primaryValue=$this->session->get('user');
        if ($primaryValue){
             $primaryKey=$this->userClass::primaryKey();
            $this->user=$this->userClass::findOne([$primaryKey=>$primaryValue]);
        }
        else{
            $this->user = null;
        }
    }
    public function run()
    {   
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('error', ['exception' => $e]);
        }
        
    }

    public function setController( Controller $controller)
    {
        $this-> controller=$controller;
    }
    public function getController(){

        return $this->controller;
    }
    public function login(DbModel $user){
        $this->user = $user;
        $primaryKey = $user->primarykey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;

    }
    public function logout(){
        $this->user = null;
        $this->session->remove('user');
    }
    public static function isGuest(){
        return !self::$app->user;
    }

}
