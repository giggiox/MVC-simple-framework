<?php
class CreateUserController extends Controller{
    public function no(Request $request){
        echo $request->nome;
        $v=new View();
        $v->assign("si", $request->nome);
        $v->show("home.php");
    }
    
}
