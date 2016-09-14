<?php

class HttpForm {
    private $fields;
    private $actionAddress = '';
    private $keyName;
    private $requiredKey = false;


    private function __construct() {}
    
    public static function fromObjectFields(BaseModel $object)
    {
        $form = new static();
        $fieldNames = get_object_vars($object);
        $form->keyName = $object->getKeyFieldName();
        foreach ($fieldNames as $key => $value) {
            $form->fields[$key] = empty($value) ? '' : $value;
        }
        return $form;
    }
    
    public function getHtmlCode()
    {
        $fields = $this->fields;
        if(!$this->requiredKey) {
            unset($fields[$this->keyName]);
        }
        $code = '<form action="' . $this->actionAddress . '" method="post">' . "\n";
        foreach ($fields as $key => $value) {
            if($this->requiredKey && $key == $this->keyName) {
                $code .= $this->getHtmlInput('hidden', $key, $value) . "\n";
            } else {
                $code .= $this->getHtmlLabel($key, $key) . "\n"
                       . $this->getHtmlInput('text', $key, $value) . "\n";
            }
        }
        $code .= '<input type="submit" value="Send">' . "\n";
        return $code . "</form>";
    }
    
    public function setActionAddress($address)
    {
        $this->actionAddress = $address;
    }

    public function addKeyToForm()
    {
        $this->requiredKey = true;
    }
    
    private function getHtmlLabel($caption, $toField)
    {
        if(empty($toField)) {
            return '<label>' . ucfirst($caption) . '</label>';
        } else {
            return '<label for="' . $toField . '">' . ucfirst($caption) . '</label>';
        }
    }
    
    private function getHtmlInput($type, $name, $value)
    {
        return '<input type="' . $type . '" name="' . $name
                   . '" value="' . $value . '">';
    }
    
}
