<?php

class ImageTag extends BaseModel {
    
    protected static $table = 'ImageTag';
    protected static $requiredFieldNames = ['tag_id', 'image_id'];
    protected static $manyToManyProxy = true;
    
    public $id;
    public $image_id;
    public $tag_id;
    
    public static function getProxyModelKey($model)
    {
        switch ($model) {
            case 'Image': 
                return 'image_id';
            case 'Tag':
                return 'tag_id';
            default :
                return '';
        }
    }
}
