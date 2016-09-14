<?php

class View {
    private static $view;
    private $mainSection = '';
    private $headerSection = '';
    private $footerSection = '';
    
    private function __construct() {}
    
    public static function currentView()
    {
        if (empty(self::$view)) {
            self::$view = new static();
            self::$view->initView();
        }
        return self::$view;
    }

    private function initView()
    {
        $this->headerSection = $this->parseFile('header');
        $this->footerSection = $this->parseFile('footer');
    }

    private function parseFile($file, $params = [])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        require __DIR__ . '/../views/' . $file . '.php';
        $code = ob_get_contents();
        ob_end_clean();
        return $code;
    }

    public function addFile($file, $params = [])
    {
        $this->mainSection .= $this->parseFile($file, $params);
    }
    
    public function addHtml($text)
    {
        $this->mainSection .= $text;
    }
    
    public function setHeader($code) 
    {
        $this->headerSection = $code;
    }
    
    public function setFooter($code)
    {
        $this->footerSection = $code;
    }
    
    public function setMenu() {}
    
    public function showPage() 
    {
        echo $this->headerSection;
        echo $this->mainSection;
        echo $this->footerSection;
    }
    
}
