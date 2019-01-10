<?php

namespace app\core;


class Router
{

    private $controller;
    private $action;
    private $view;
    private $params = [];

    public function __construct()
    {
        $request = $this->clearGet($_SERVER['REQUEST_URI']);
        $segments = explode("/",  $request);
        $this->controller = !empty($segments[0]) ? $segments[0] : Config::get('router/defaultController');
        $this->action = !empty($segments[1]) ? $segments[1] : Config::get('router/defaultAction');
        $this->view = $this->action;

        if(count($segments) > 2){
            $this->params = array_slice($segments, 2);
        }

        $this->run();
    }


    public function run(){
        $controller_path = "app\\controllers\\" . ucfirst($this->controller).'Controller';
        $action_path = 'action' . ucfirst($this->action);

        if (!class_exists($controller_path) || !method_exists($controller_path, $action_path)){
            $controller_path = "app\\controllers\\" . ucfirst(Config::get('router/defaultController')) . 'Controller';
            $action_path = 'action' . ucfirst(Config::get('router/defaultErrorAction'));
            $this->controller = Config::get('router/defaultController');
            $this->view = Config::get('router/defaultErrorAction');
        }

       $custom_controller = new $controller_path($this->controller, $this->params);
       call_user_func_array(array($custom_controller, $action_path), $this->params);
       $custom_controller->display($this->view);
    }


    public function clearGet($data){
        $data = trim($data, "/");
        $data = strtolower($data);
        $data = htmlspecialchars($data);
        return $data;
    }

}