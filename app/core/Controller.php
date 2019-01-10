<?php

namespace app\core;


class Controller
{
    private $view;
    public $uses = [];
    public $params = [];

    public function __construct($controller, $params = [])
    {
        Session::init();
        $this->view = new View($controller);
        $this->params = $params;
        $this->setModels($controller);
    }

    public function setModels($controller)
    {
        if(!empty($this->uses)){
            foreach ($this->uses as $model){
                $model_path = 'app\\models\\' . $model;
                if(class_exists($model_path)){
                    $this->{$model} = new $model_path;
                }
            }
        }else{
            $model_path = 'app\\models\\' . $controller;
            if(class_exists($model_path)){
                $this->{$controller} = new $model_path;
            }
        }

    }

    public function set($name, $value)
    {
        $this->view->set($name, $value);
    }

    public function display($template)
    {
        $this->view->render($template);
    }


}