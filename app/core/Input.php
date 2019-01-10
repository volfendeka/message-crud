<?php

namespace app\core;

class Input
{
    public static function exists($name)
    {
        return isset($_POST[$name]);
    }

    public static function get($item){
        if(isset($_POST[$item])){
            return $_POST[$item];
        }elseif (isset($_GET[$item])){
            return$_GET[$item];
        }
        return '';
    }

    public static function getPost()
    {
        if (isset($_POST)) {
            return $_POST;
        }
    }

    public static function input($name)
    {
        if (self::exists($name)) {
            return $_POST[$name];
        } else {
            return false;
        }
    }

    public static function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public static function isGet()
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public static function isAjax()
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

}