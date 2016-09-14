<?php

class Image extends BaseModel{
 
    protected static $table = 'Images';
    protected static $requiredFieldNames = ['name', 'path', 'created'];
    protected static $keyName = 'id';

    public $id;
    public $name;
    public $path;
    public $created;

    
}
