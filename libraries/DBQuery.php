<?php

class DBQuery {
    
    const SORT_ORDER_TO_HIGH = 'ASC';
    const SORT_ORDER_TO_LOW  = 'DESC';
    
    private static  $typeSelect = 1;
    private static  $typeUpdate = 2;
    private static  $typeInsert = 3;
    private static  $typeDelete = 4;
    
    private $class;
    private $query_type;
    private $columns = '';
    private $tables  = '';
    private $tableAliases = [];
    private $tableCounter = 1;
    private $where   = '';
    private $order   = '';
    private $parameters = [];
    
    private function __construct() {}

    public static function select($class, $fields = [])
    {
        $query = new static();
        $query->class = $class;
        $query->query_type = self::$typeSelect;
        if(empty($fields)) {
            $query->columns = 'SELECT * ';
        } else {
            $query->columns = 'SELECT ' . implode(', ', $fields) . ' ';
        }
        return $query;
    }
    
    public static function insert($fields) //old
    {
        $query = new static();
        $query->query_type = self::$typeInsert;
        $columns = [];
        $values = [];
        foreach ($fields as $name => $value) {
            $columns[] = $name;
            $values[]  = ':' . $name;
            $query->parameters[':' . $name] = $value;
        }
        $query->columns = '(' .implode(', ', $columns) . ') VALUES('
                . implode(', ', $values) . ')';
        return $query;
    }
    
    public static function update($fields) //old
    {
        $query = new static();
        $query->query_type = self::$typeUpdate;
        $columns = [];
        foreach ($fields as $name => $value) {
            $columns[] = $name . ' = :set' . $name;
            $query->parameters[':set' . $name] = $value;
        }
        $query->columns = 'SET ' . implode(', ', $columns) . ' ';
        return $query;
    }
    
    public static function delete()
    {
        $query = new static();
        $query->query_type = self::$typeDelete;
        $query->columns = 'DELETE ';
        return $query;
    }

    public function from($table) //old 
    {
        switch ($this->query_type) {
            case self::$typeSelect:
            case self::$typeDelete:
                $this->tables = 'FROM ' . $table . ' ';
                break;
            case self::$typeInsert:
                $this->tables = 'INSERT INTO ' . $table . ' ';
                break;
            case self::$typeUpdate:
                $this->tables = 'UPDATE ' . $table . ' ';
                break;
        }
        return $this;
    }
    
    public function to($table)
    {
        return $this->from($table);
    }

    public function addFilter($name, $operator, $value) //old
    {
        //только для теста
        if($this->query_type == self::$typeInsert) {
            return $this;
        }
        $this->where .= (empty($this->where)) ? 'WHERE ' : ' AND ';
        $this->where .= $name . ' ' . $operator . ' :' . $name . ' ';
        $this->parameters[':' . $name] = $value;
        return $this;
    }
    
    public function addFilterLike($name, $value)  //old
    {
         //только для теста
        if($this->query_type != self::$typeInsert) {
            $this->where = 'WHERE ' .$name . ' LIKE :' . $name . ' ';
            $this->parameters[':' . $name] = '%' . $value . '%';
        }
        return $this;
    }

    public function addSort($name, $order)
    {
        if($this->query_type == self::$typeSelect) {
            $separator = ', ';
            if(!$this->order) {
                $this->order = 'ORDER BY ';
                $separator = '';
            }
            $this->order .=  $separator . $name . ' ' . $order;
        }
        return $this;
    }
    
    public function getSQL()
    {
        $sql = '';
        switch ($this->query_type) {
            case self::$typeSelect:
                $sql = $this->columns . $this->tables . $this->where
                    . $this->order;
                break;
            case self::$typeInsert:
                $sql = $this->tables . $this->columns;
                break;
            case self::$typeUpdate:
                $sql = $this->tables . $this->columns . $this->where;
                break;
            case self::$typeDelete:
                $sql = $this->columns . $this->tables . $this->where;
                break;
        }
        return $sql;
    }
    
    private function buildSelect()
    {
        return 'SELECT ' . $this->arrayToStr($this->columns, '*') . ' '
               . 'FROM ' . ${$this->class}::$table;
    }

    private function arrayToStr($array, $defaultValue = '')
    {
        if(is_array($array)) {
            return implode(', ', $array);
        } elseif(empty ($this->columns)) {
            return $defaultValue;
        } else {
            return $array;
        }
    }

    public function execute($class)
    {
        $db = Database::getConnect();
        if($this->query_type == self::$typeSelect){
            return $db->select($this->getSQL(), $class, $this->parameters);
        } else {
            return $db->modify($this->getSQL(), $this->parameters);
        }
    }
    
}
