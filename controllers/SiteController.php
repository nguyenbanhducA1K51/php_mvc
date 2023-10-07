<?php 

namespace app\controllers;

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
    public function contact(){

        return $this->render('contact',[]);
}
}

?>