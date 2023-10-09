<?php
namespace app\controllers;
use app\core\Request;
use app\controllers\Controller;
use app\models\User;

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
        $user=new User();
        if ($request->isPost()){          
            $user->loadData($request->getBody());
        
            if ( $user->validate()&& $user->save()){

                    return 'Success';
            }
            return $this->render("register",["model"=>$user]);
        }
        return $this-> render("register",["model"=>$user]);
    }
}
         
    ?>