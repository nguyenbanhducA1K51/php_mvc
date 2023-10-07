<?php

namespace app\core;
use app\controllers\Controller;
require_once __DIR__."/Database.php";
// require_once __DIR__."/Router.php";
// require_once __DIR__."/Response.php";
// require_once __DIR__."/Request.php";
// require_once __DIR__."/../controllers/Controller.php";

use app\core\Request;
use app\core\Router;
class Application
{

    public static Application $app;
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;
    public Database $db;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self :: $app =$this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->db=new Database($config['db']);
    }
    public function run()
    {
        echo  $this->router->resolve();
    }

    public function setController( Controller $controller)
    {
        $this-> controller=$controller;
    }
    public function getController(){

        return $this->controller;
    }

}