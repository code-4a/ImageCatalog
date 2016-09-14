<?php

abstract class BaseModel {
    
    // Переопреляемые переменные
    protected static $table = '';
    protected static $requiredFieldNames = [];
    protected static $keyName = 'id';
    protected static $parentKeyName = '';
    protected static $manyToManyProxy = false;

    
    public static function getAll()
    {
        return DBQuery::select(static::class)->from()->execute();
    }

    public static function getOne($id)
    {
        $class = get_called_class();
        $res = DBQuery::select()->from(static::$table)
                ->addFilter('id', '=', $id)
                ->execute($class);
        return (empty($res)) ? '' : $res[0];
    }
    
    public static function getMany($filter)
    {
       $class = get_called_class();
       $query = DBQuery::select()->from(static::$table);
       foreach ($filter as $key => $value) {
           $query->addFilter($key, ' = ', $value);
       }
       return $query->execute($class);
    }
    
    public static function find($filter)
    {
       $class = get_called_class();
       $query = DBQuery::select()->from(static::$table);
       foreach ($filter as $key => $value) {
           $query->addFilterLike($key, $value);
       }
       return $query->execute($class);
    }
    
    public static function getKeyFieldName() {
        return static::$keyName;
    }

    public static function getRequiredFieldNames() {
        return static::$requiredFieldNames;
    }
    
    public static function getParentKeyName() {
        return static::$parentKeyName;
    }
    
    public static function getProxyModelKey($model)
    {
        return '';
    }

    public function save()
    {
        $keyName = $this->getKeyFieldName();
        $params = get_object_vars($this);
        unset($params[$keyName]);
        if(empty($this->$keyName)) {
            DBQuery::insert($params)->to(static::$table)
                    ->execute(static::class);
        } else {
            DBQuery::update($params)->from(static::$table)
                    ->addFilter($keyName, '=', $this->$keyName)
                    ->execute(static::class);
        }
    }
    
    public function delete()
    {
        $keyName = $this->getKeyFieldName();
        if(!empty($this->$keyName)) {
            DBQuery::delete()->from(static::$table)
                 ->addFilter($keyName, '=', $this->$keyName)->execute(static::class);
        }
    }
    
    public function linkOneToMany($model)
    {
        $keyName   = $this->getKeyFieldName();
        $keyParent = $model::getParentKeyName();
        if(empty($keyParent)) {
            return false;
        } else {
            $filter = [$keyParent => $this->$keyName];
            return $model::getMany($filter);
        }
    }
    
     public function linkManyToMany($model, $proxyModel)
     {
        $srcKey = $this->getKeyFieldName();
        $dstKey = $model::getKeyFieldName();
        $proxySrcKey = $proxyModel::getProxyModelKey(static::class);
        $proxyDstKey = $proxyModel::getProxyModelKey($model);
        
        //DatabaseQuery::select()->
        
     }
}
