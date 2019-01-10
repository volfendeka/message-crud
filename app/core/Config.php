<?php

namespace app\core;


class Config
{
    private static $config = [];

    public function __construct()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        self::set(require_once "app/configs/config.php");

        spl_autoload_register(function ($class){

            $namespace = explode("\\", $class);
            if(is_array($namespace)){
                $class_route = implode("/", $namespace).".php";
            }
            if(file_exists($class_route)){
                require_once $class_route;
            }
        });
    }

    /**
     * @param $config array
     */

    public static function set($config){
        self::$config = $config;
    }

    /**
     * @return mixed
     */
    public static function get($path = null){
        if($path){
            if(strpos($path, '/')){
                $path = explode('/', $path);
                foreach ($path as $key => $value){
                    if(isset(self::$config[$value])){
                        $configuration = self::$config[$value];
                    }
                    if(isset($configuration[$value])){
                        return $configuration[$value];
                    }
                }
            }else{
                if(isset(self::$config[$path])){
                    return self::$config[$path];
                }
            }
        }else {
            return false;
        }
    }


}