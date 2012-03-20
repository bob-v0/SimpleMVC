<?php


class Route
{
    private $moduleName;
    private $controllerName;
    private $controller;
    private $actionName;
    private $action;
    private $queryName;

    public function __construct($module, $controller, $action, $query)
    {
        $this->moduleName = $module;
        $this->controllerName = $controller;
        $this->actionName = $action;
        $this->queryName = $query;

        // controller
        $controllerName = ucfirst($controller.'Controller');

        //if(!class_exists($controllerName))
        //    echo "not exists: SimpleMVC\\Modules\\Module1\\$controllerName<br />";


        if(!class_exists($controllerName))
            throw new ControllerNotFoundException($module."\\".$controllerName);

        $this->controller = new $controllerName($module);
        $this->action = ucfirst($action).'Action';
        if(!method_exists($this->controller, $this->action))
            throw new ActionNotFoundException($this->action);
    }

    public function getModuleName()
    {
        return $this->module;
    }

    public function getControllerName()
    {
        return $this->controller;
    }

    public function getActionName()
    {
        return $this->action;
    }

    public function getQueryName()
    {
        return $this->query;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function doAction() {
        // yes this matters, $this->action will give an object to string conversion error.
        $action = $this->action;
        return $this->controller->$action($this->queryName);
    }


    public static function create($q, $modules)
    {

        $route = self::getRoutingParts($q, $modules);

        // return array($route, $modules);
        $routeObj = new Route($route['module'], $route['controller'], $route['action'], $route['query']);
        return $routeObj;
    }

    public static function getRoutingParts($q, $modules)
    {
        $route = array();
        $route['module'] = "default";
        $route['controller'] = "index";
        $route['action'] = "index";
        $route['query'] = null;

        if (!in_array($q[0], $modules))
            array_unshift($q, 'default');

        $query = array_splice($q, 3);

        $route['module'] = $q[0];
        if (!empty($q[1])) $route['controller'] = $q[1];
        if (!empty($q[2])) $route['action'] = $q[2];
        $route['query'] = $query;
        return $route;
    }
}

