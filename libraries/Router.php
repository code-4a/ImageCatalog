<?php

class Router {
    
    private $routes;
    private $defaultRoute;

    private function __construct() {
        $this->routes = [];
        $this->defaultRoute = '';
    }

    /**
     * Добавить маршрут
     * @param array $routes Массив маршрутов
     * @return Router Объект класса Router
     * @example [ Address => 'Controller.Method' ]
     */
    public static function createRouteTable($routes)
    {
        $router = new static();
        $router->routes = $routes;
        return $router;
    }
    
    /**
     * Назначить маршрут по-умолчанию
     * @param string $route 'Контроллер.Метод'
     */
    public function setDefault($route)
    {
        $this->defaultRoute = $route;
    }
    
    /**
     * Проверка текущего маршрута и вызов контроллера
     */
    public function start()
    {
        foreach ($this->routes as $address => $callName) {
            $matches = [];
            if(preg_match('#^' . $address . '/?$#', $_SERVER["REQUEST_URI"], $matches)) {
                $this->execMethod($callName, $matches);
                return;
            }
        }
        $this->execMethod('');
    }
    
    private function execMethod($route, $params = [])
    {
        $callName = $route;
        if(empty($route)) {
           $callName = $this->defaultRoute; 
        }
        list($controller, $method) = explode('.', $callName);
        $controller .= 'Controller';
        $objController = new $controller();
        $objController->$method($params);
    }
}
