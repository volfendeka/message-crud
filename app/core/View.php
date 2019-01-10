<?php

namespace app\core;

class View
{
    private $working_folder;
    private $templates_root = 'templates/';
    private $layout_folder = 'layouts';
    private $layout = 'default';
    private $data = [];

    /**
     * View constructor.
     * @param $working_folder
     */

    public function __construct($working_folder)
    {
        $this->working_folder = $working_folder;
    }

    /**
     * @param $name string
     * @param $value string
     */

    public  function set($name, $value){
        $this->data[$name] = $value;
    }

    /**
     * @param $name string
     * @return mixed
     */

    public function get($name){
        if(isset($this->data[$name])){
            return $this->data[$name];
        }
    }

    /**
     * output generated page
     * @param $template string
     */

    public function render($template){
        $view_file = $this->templates_root.$this->working_folder."/".$template.".php";
        $layout_file = $this->templates_root.$this->layout_folder."/". $this->layout.".php";

        ob_start();
        ob_start();
        extract($this->data);
        if (file_exists($view_file)) {
            require_once($view_file);
        }
        $output = ob_get_clean();

        require_once($layout_file);
        echo ob_get_clean();
    }

}