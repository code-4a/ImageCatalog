<?php

class Tag extends BaseModel{
    
    protected static $table = 'Tags';
    protected static $requiredFieldNames = ['name'];
    protected static $keyName = 'id';
    
    public $id;
    public $name;

}
