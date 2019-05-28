<?php
require_once './include/Router.php';
require_once './include/View.php';
require_once './include/Controller.php';
require_once './include/Request.php';
//require_once './include/Controllers/CreateUserController.php';

$router=new Router();
/*$r->route('/blog/[id]/[nome]/', function($id, $nome) {
    $view = new View();
    $view->assign("id", $nome);
    $view->show("ciao.php");
});*/
$router->get("/blog/", function(){
    $v=new View();
    $v->show("home.php");
});
$router->post("/blog/", "CreateUserController#no");


$router->execute(Router::getUri());