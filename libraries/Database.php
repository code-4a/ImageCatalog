<?php

class Database {
    
    private static $db;
    private $connection;


    private function __construct() {}
    
    public static function getConnect()
    {
        if (empty(self::$db)) {
            self::$db = new static();
            self::$db->connectToDB();
        }
        return self::$db;
    }
    
    private function connectToDB()
    {
        $this->connection = new PDO('sqlite:' . __DIR__ . '/../data.db');
    }
    
    public function select($sql, $class, $params = [])
    {
        $queryObject = $this->connection->prepare($sql);
        $queryObject->execute($params);
        return $queryObject->fetchAll(PDO::FETCH_CLASS, $class);
    }
    
    public function modify($sql, $params = [])
    {
        $queryObject = $this->connection->prepare($sql);  
        return $queryObject->execute($params);
    }
}
