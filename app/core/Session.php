<?php

namespace app\core;

class Session
{
    public static function init(){
        session_start();
    }

    public static function destroy(){
        session_unset();
        session_destroy();
        $_SESSION = array();
    }

    public static function exists($name){
        return isset($_SESSION[$name]) ? true : false;
    }

    public static function put($name, $value){
        $_SESSION[$name] = $value;
    }

    public static function get($name){
        if(self::exists($name)){
            return $_SESSION[$name];
        }else{
            return false;
        }
    }

    public static function delete($name){
        if(self::exists($name)){
            unset($_SESSION[$name]);
        }else{
            return false;
        }
    }

    public static function flashMessage($name, $flash = ''){
        if(self::exists($name)){
            $session = self::get($name);
            self::delete($name);
            return $session;
        }else{
            self::put($name, $flash);
        }
    }

}