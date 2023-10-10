<?php
namespace app\controllers;
use app\core\Request;
use app\controllers\Controller;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;
use app\core\Application;
use app\core\middleware\AuthMiddleware;

// require_once __DIR__."/../controllers/SiteController.php";

class AuthController extends Controller{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }
    
    public function login(Request $request, Response $response){

      $loginForm = new LoginForm();
        if ($request->isPost()){
            $loginForm->loadData($request->getBody());
          
            if ($loginForm->validate()&& $loginForm->login()){
                $response->redirect('/');
                return;
            }            
        }

        return $this-> render('login',['model'=>$loginForm]);
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
    public function logout(Request $request, Response $response){
        Application::$app->logout();
        $response->redirect('/');
    }
    public function profile(){
        // $Application::

        return $this->render('profile',[]);

    }
}
         
    ?>