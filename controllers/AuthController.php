<?php
namespace app\controllers;
use app\core\Request;
use app\controllers\Controller;
use app\models\User;
use app\core\Application;

// require_once __DIR__."/../controllers/SiteController.php";

class AuthController extends Controller{

    public function __construct()
    {
        $this->layout="auth";
    }
    
    public function login(Request $request, Response $response){

      $loginForm = new LoginForm();
        if ($request->isPost()){
            if ($loginForm->validate()&& $loginForm->login()){
                $response->redirect('/');
                Application::$app->login();
                return;
            }            
        }

        return $this-> render('login',[]);
    }
    public function register(Request $request){
        $user=new User();
        if ($request->isPost()){          
            $user->loadData($request->getBody());
        
            if ( $user->validate()&& $user->save()){
               
                Application::$app->session->setFlash('success', 'Thank for registering');
                Application::$app->response->redirect('/');
                exit;
            }
            return $this->render("register",["model"=>$user]);
        }
        return $this-> render("register",["model"=>$user]);
    }
}
         
    ?>