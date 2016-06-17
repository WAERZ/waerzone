<?php
class Router
{
    private $routing_rules = array();
    public function __construct(){}

    public function init(){
        $route =   explode('/', $_SERVER['REQUEST_URI']);
        if(!empty($route[1])){
            //remove the first value of the array, for array_shift
            array_splice($route, 0, 1);

            $controller = ucfirst(array_shift($route));
            $action = 'action' . ucfirst(array_shift($route));
            $params     = $route;
        } else{
            $controller = 'Base';
            $action     = 'actionIndex';
            $params     = array();
        }
        if(is_callable(array($controller, $action))){
            call_user_func_array(array(new $controller(), $action), $params);
        } else {
            $this->errorPage404();
        }
    }

    public function errorPage404()
    {
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/404');
    }
}