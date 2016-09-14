<?php

class HttpPostVars {
    private $postVars = [];
    private $postKey  = ['', ''];
    private $requireFields = [];
    private $requireKey = false;


    public function equalObjectFields(BaseModel $object) {
        $fields = get_object_vars($object);
        $keyField = $object->getKeyFieldName();
        $this->requireFields = $object->getRequiredFieldNames();
        foreach ($fields as $key => $value) {
            $postValue = (empty($_POST[$key])) ? '' : $_POST[$key];
            if($key == $keyField) {
                $this->postKey = [$key, $postValue];
            } else {
                $this->postVars[$key] = $postValue;
            }
        }
        return $this;
    }
    
    public function isFillAny()
    {
        foreach ($this->postVars as $key => $value) {
            if(!empty($value)) {
                return true;
            }
        }
        if(($this->requireKey) && !empty($this->postKey[1])) {
            return true;
        }
        return false;
    }
    
    public function isFillAllRequired()
    {
        foreach ($this->requireFields as $key) {
            if(empty($this->postVars[$key])) {
                return false;
            }
        }
        if(($this->requireKey) && empty($this->postKey[1])) {
            return false;
        }
        return true;
    }
    
    public function getFillVars()
    {
        $fields = $this->postVars;
        if($this->requireKey) {
            $fields[$this->postKey[0]] = $this->postKey[1];
        }
        return $fields;
    }
    
    
    public function fillObject(BaseModel &$object)
    {
        $fields = get_object_vars($object);
        if(!$this->requireKey) {
            $keyName = $object->getKeyFieldName();
            if(isset($fields[$keyName])) unset($fields[$keyName]);
        }
        foreach ($fields as $key => $value) {
            if(isset($this->postVars[$key])) {
                $object->$key = $this->postVars[$key];
            }
        }
    }
    
    public function addKeyToRequired()
    {
        $this->requireKey = true;
    }
}
