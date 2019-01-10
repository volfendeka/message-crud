<?php

namespace app\core;


class Model extends Table
{

    public $validation_rules = [];
    public $validation = [];


    public function validate($input_data){
        foreach ($input_data as $input => $value){
            if(isset($this->validation_rules[$input])) {
                foreach ($this->validation_rules[$input] as $rule => $rule_value) {
                    if (empty(Validation::$validation_errors[$input]) && Validation::$rule($input, $value, $rule_value, $this)) {
                        Validation::$rule($input, $value, $rule_value, $this);
                    }
                }
            }
        }
        $this->validation = empty(Validation::$validation_errors) ? false : Validation::$validation_errors;
    }

    public function getErrors()
    {
        return Validation::$validation_errors;
    }

    public function save($data= [], $where =[]){
        if(empty($where)){
            return $this->insert($data);
        }else{
            return $this->update($data, $where);
        }
    }

    public function deleteRecord($where){
        return $this->delete($where);
    }

    public function find($column = '*', $where =[]){
        if(empty($where)){
            return $this->getAll();
        }else{
            return $this->get($column, $where);
        }
    }

    public function findById($id)
    {
        return $this->get('*', ['id', '=', $id])[0];
    }


}