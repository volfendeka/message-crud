<?php

namespace app\core;

use app\interfaces\DatabaseInterface;
use PDO;
use PDOException;


class MySQLDriver implements DatabaseInterface
{

    private static $instance = null;
    private $results;

    public function __construct()
    {
        if(!isset(self::$instance)){
            self::$instance = $this->connect();
        }
        return self::$instance;
    }

    /**
     * @return PDO
     */

    public function connect()
    {
        $pdo = null;
        try {
            $pdo = new \PDO(Config::get('database/type') . ":dbname=" . Config::get('database/dbname') . ";host=" . Config::get('database/host'), Config::get('database/user'), Config::get('database/password'));
        }catch (PDOException $e){
            die($e->getMessage());
        }
        return $pdo;
    }

    /**
     * @param $sql string
     * @param array $params
     * @return mixed
     */

    public function executeQuery($sql, $params = array())
    {
        $pdo_statement = self::$instance->prepare($sql);

        if($pdo_statement){
            if(count($params)) {
                for ($i = 0; $i < count($params); $i++) {
                    if(is_string($params[$i])){
                        $pdo_statement->bindValue($i + 1, $params[$i], PDO::PARAM_STR);
                    }else{
                        $pdo_statement->bindValue($i + 1, $params[$i], PDO::PARAM_INT);
                    }
                }
            }
        }

        if($pdo_statement->execute()) {
            $this->results = $pdo_statement->fetchAll(PDO::FETCH_ASSOC);
            return $this->results;
        }

       return false;

    }

    /**
     * @return \PDO
     */

    public function disconnect()
    {
        return self::$instance = null;
    }


}