<?php 

namespace app\controllers;
use app\core\Response;
use app\models\ContactForm;
use app\core\Application;
use app\core\Request;

class SiteController extends Controller{


    public function home(){

        $params=[
            'name'=>"duke"
        ];
        return $this->render('home',$params);
    }
    public function handleContact(Request $request){
            $body=$request->getBody();
       
            return 'handling submitted data';
    }
    public function contact( Request $request,Response $response){

        $contact = new ContactForm();
        if ($request->isPost()){
            $contact->loadData($request->getBody());
            if ($contact->validate()&&$contact->send()){
                Application::$app->session->setFlash('success', 'Thanks for contact us.');

                return $response->redirect('/contact');
            }
            
        }

        return $this->render('contact',['model'=>$contact]);
}
}

?>