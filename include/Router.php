<?php

class Router {
    private $routes = array();
    
    
    private $get_routes=array();
    private $post_routes=array();
    
    public function get($pattern,$callback){
        $this->get_routes[$pattern] = $callback;
    }
    public function post($pattern,$action){
        $this->post_routes[$pattern]= self::splitPostAction($action);
    }
    
    private static function splitPostAction($action){
        $parts= explode("#", $action);
        $controller=$parts[0];
        $controller_method=$parts[1];
        return [$controller,$controller_method];
    }
    

    public function route($pattern, $callback) {
        $this->routes[$pattern] = $callback;
    }

    public function execute($uri) {
        /*foreach ($this->routes as $pattern => $callback) {
            

            $pattern = $this->process_pattern($pattern);
            $uri = $this->process_uri($uri);

            if (preg_match($pattern, $uri, $params) === 1) {
                array_shift($params);
                return call_user_func_array($callback, array_values($params));
            }
        }
        $v=new View();
        return $v->show("404.html");*/
        
        $request_method=$_SERVER["REQUEST_METHOD"];
        echo $request_method;
        
        if($request_method == "GET"){
            foreach ($this->get_routes as $pattern => $callback) {
                $pattern = $this->process_pattern($pattern);
                $uri = $this->process_uri($uri);
                if (preg_match($pattern, $uri, $params) === 1) {
                    array_shift($params);
                    return call_user_func_array($callback, array_values($params));
                }
            }
        }
        if($request_method == "POST"){
            foreach ($this->post_routes as $pattern => $callback) {
                $pattern = $this->process_pattern($pattern);
                $uri = $this->process_uri($uri);
                if (preg_match($pattern, $uri, $params) === 1) {
                    
                    require_once "Controllers/".$callback[0].".php";
                    $class=new $callback[0];
                    $method=$callback[1];
                    $request=new Request($_POST);
                    return call_user_func(array($class,$method),$request);
                }
            }
        }
        $v=new View();
        return $v->show("404.php");
        
        
        
        
        
    }

    //add / at beginning and end if not detected.
    function process_uri($uri) {
        if ($uri[strlen($uri) - 1] != "/") {
            $uri .= "/";
        }
        return $uri;
    }

    function process_pattern($pattern) {
        $patterns = explode("/", $pattern);
        $final_pattern = [];
        foreach ($patterns as $p) {
            /*if($p[0] == "[" && $p[strlen($p) - 1] == "]"){
                array_push($final_pattern, "(\w+)");
            }else{
                array_push($final_pattern, $p);
            }*/
            $parts = preg_split('/^\[|\]$/', $p);
            if (count($parts) == 3) { //vuol dire che è un parametro dinamico
                array_push($final_pattern, "(\w+)");
            } else {
                array_push($final_pattern, $p);
            }
        }
        $final_pattern = implode("\/", $final_pattern);
        $final_pattern = "/^" . $final_pattern . "$/";
        return $final_pattern;
    }

    static function getUri() {
        $uri = "";
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $array_uri = explode('/', $_SERVER['REQUEST_URI']);
            array_shift($array_uri);
            array_shift($array_uri);
            $uri = implode($array_uri, "/");
            $uri = "/" . $uri;
        } else {
            $uri = $_SERVER['REQUEST_URI'];
        }
        return $uri;
    }

}