<?php
namespace app\controllers;
use app\core\Request;
use app\controllers\Controller;
use app\models\RegisterModel;

// require_once __DIR__."/../controllers/SiteController.php";

class AuthController extends Controller{

    public function __construct()
    {
        $this->layout="auth";
    }
    
    public function login(Request $request){

      
        if ($request->isPost()){
           
           return "handle login";
        }

        return $this-> render('login',[]);
    }
    public function register(Request $request){
        $registerModel=new RegisterModel();
        if ($request->isPost()){          
            $registerModel->loadData($request->getBody());
        
            if ( $registerModel->validate()&& $registerModel->register()){

                    return 'Success';
            }
            // echo '<pre>';
            // var_dump($registerModel->errors);
            // echo '</pre>';
            return $this->render("register",["model"=>$registerModel]);
        }
        return $this-> render("register",["model"=>$registerModel]);
    }
}
         
    ?>