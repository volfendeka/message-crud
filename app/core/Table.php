<?php


namespace app\core;

class Table
{
    protected $use_table;
    protected $db_connect;

    public function __construct()
    {
        $db_driver = Config::get('database/driver');
        $this->db_connect = new $db_driver(); //MySQLDriver
    }

    private function action($action, $where = null){
        $values = [];
        $condition = [];
        if(is_array($where)) {
            $oparators = ['=', '<', '>', '>=', '<='];
            if (count($where) === 3) {
                $field = $where[0];
                $oparator = $where[1];
                $value = $where[2];
                if (in_array($oparator, $oparators)) {
                    $condition[] = $field . $oparator . '?';
                    $values[] = $value;
                }
            } else {
                return false;
            }
        }
        $condition_string = implode(' AND ', $condition);
        $result['sql'] = "{$action} FROM {$this->use_table} WHERE $condition_string";
        $result['params'] = $values;
        $query_result = $this->db_connect->executeQuery($result['sql'], $result['params']);
        return $query_result;
    }

    public function get($column = '*', $where = []){
        if(is_string($column)){
            $result = $this->action("SELECT {$column}", $where);
            return $result;
        }else{
            return false;
        }
    }

    public function getAll($column = '*', $order_params = []){
        if(is_string($column)){
            $sql_query = "SELECT {$column} FROM {$this->use_table}";
            if(!empty($order_params)){
                $sql_query.= " ORDER BY {$order_params['column']}  {$order_params['order']} LIMIT ?, ?";
                unset($order_params['column']);
                unset($order_params['order']);
            }

            $query_result = $this->db_connect->executeQuery($sql_query, $order_params);
            return $query_result;
        }else{
            return false;
        }
    }

    public function insert($data = []){
        $sql_query = "INSERT INTO ". $this->use_table;
        $columns = [];
        $columns_string = '';
        $values_string = '';
        $params_array = [];
        if(!empty($data)){
            foreach ($data as $key => $value){
                $columns[] = $key;
                $values[] = '?';
                $values_string = implode(',', $values);
                $columns_string = implode('`, `', $columns);
                $params_array[] = $value;
            }
        }
        $sql_query .= " (`".$columns_string."`) VALUES (".$values_string.")";
        $this->db_connect->executeQuery($sql_query, $params_array);
        return true;
    }

    public function update($data = [], $where = []){
        $sql_query = "UPDATE $this->use_table SET "; //name=? WHERE id=?
        $params_array = [];
        $column = [];
        $condition = [];
        if(!empty($data)){
            foreach ($data as $key => $value){
                $column[] = $key."=?";
                $params_array[] = $value;
            }
            $columns_string = implode(',', $column);
            $sql_query .= $columns_string;
        }
        if(is_array($where)) {
            $oparators = ['=', '<', '>', '>=', '<='];
            if (count($where) === 3) {
                $field = $where[0];
                $oparator = $where[1];
                $value = $where[2];
                if (in_array($oparator, $oparators)) {
                    $condition[] = $field . $oparator . $value;
                }
            } else {
                return false;
            }
        }
        $condition_string = implode(' AND ', $condition);
        $sql_query .= " WHERE $condition_string";
        $this->db_connect->executeQuery($sql_query, $params_array);
        return true;
    }

    public function delete($where = []){
        $this->action("DELETE ", $where);
        return true;
    }
}