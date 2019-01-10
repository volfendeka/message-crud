<?php

namespace app\core;


class Validation
{
    public static $validation_errors = [];

    public static function min($field_name = '', $value = '', $rule_value = '', $model){
        if(strlen($value) < $rule_value){
            self::$validation_errors[$field_name] = "{$field_name} must be at list {$rule_value} chars";
        }
        return true;
    }

    public static function max($field_name = '', $value = '', $rule_value = '', $model){
        if(strlen($value) > $rule_value){
            self::$validation_errors[$field_name] = "{$field_name} must be not longer then {$rule_value} chars";
        }
        return true;
    }

    public static function unique($field_name = '', $value = '', $rule_value = '', $model){
        if($rule_value){
            if($model->find($field_name, [$field_name, '=', $value])){
                self::$validation_errors[$field_name] = "this {$field_name} already exists";
            }
        }
        return true;
    }

    public static function matches($field_name = '', $value = '', $rule_value = '', $model){
        if ($value != Input::get($rule_value)) {
            self::$validation_errors[$field_name] = "{$field_name} have to match";
        }
        return true;
    }

    public static function email($field_name = '', $value = '', $rule_value = '', $model){
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            self::$validation_errors[$field_name] = "{$field_name} have to be valid format";
        }
        return true;
    }

    public static function required($field_name = '', $value = false, $rule_value = '', $model){
        if(!$value){
            self::$validation_errors[$field_name] = "{$field_name} is required";
        }
        return true;
    }
}