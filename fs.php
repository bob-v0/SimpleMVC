<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
require_once (ROOT . DS . 'config' . DS . 'config.php');
require_once (ROOT . DS . 'application' . DS . 'bootstrap.php');


$pageURL = 'http';
if (@$_SERVER["HTTPS"] == "on")
    $pageURL .= "s";
$pageURL .= "://".$_SERVER["SERVER_NAME"];
if ($_SERVER["SERVER_PORT"] != "80")
    $pageURL .= ":".$_SERVER["SERVER_PORT"];
$pageURL .= str_replace(basename(__FILE__), '', $_SERVER["PHP_SELF"]);
define('BASE_URL', $pageURL);


class ControllerNotFoundException extends Exception { }
class ActionNotFoundException extends Exception { }


if(DEV_ENV) {
    error_reporting(E_ALL);
    ini_set('display_errors','On');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors','Off');
    ini_set('log_errors', 'On');
    ini_set('error_log', ROOT.DS.'logs'.DS.'error.log');
}

try
{

    $url = "";
    if(isset($_GET['q'])) $url = $_GET['q'];
    $url = rtrim($url, '/');

    $q = explode('/', $url);

    /////////////////////////////////
    // routing
    /////////////////////////////////

    $route['module'] = "default";
    $route['controller'] = "index";
    $route['action'] = "index";
    $route['query'] = null;


    global $modules;
    $modules = array('default', 'module1'); // todo: naar config
    if(!in_array($q[0], $modules))
        array_unshift($q, 'default');

    $query = array_splice($q, 3);

    $route['module'] = $q[0];
    if(!empty($q[1])) $route['controller'] = $q[1];
    if(!empty($q[2])) $route['action'] = $q[2];
    $route['query'] = $query;


    /////////////////////////////////
    // controller
    /////////////////////////////////               sdd

    $controller = ucfirst($route['controller'].'Controller');
    if(!class_exists($controller))
        throw new ControllerNotFoundException($controller);

    $conObj = new $controller($route['module']);
    $action = ucfirst($route['action']).'Action';
    if(!method_exists($conObj, $action))
        throw new ActionNotFoundException($action);

    $output = $conObj->$action($route['query']);

    echo $output;
}

catch (ActionNotFoundException $ex) {
    $action = $ex->getMessage();
    header("HTTP/1.0 404 Not Found");
    echo "$action not found";
    die;
}

catch (ControllerNotFoundException $ex) {
    //echo "todo: throw 404 error - ".$ex->getMessage();
    $controller = $ex->getMessage();
    header("HTTP/1.0 404 Not Found");
    echo "$controller not found";
    die;
}

catch (Exception $ex) {

    // place the error control & view to its own handler(s)
    echo "Fatal error: ".$ex->getMessage();
    echo "<hr />\n";
    echo "<pre>StackTrace: \n";
    echo $ex->getTraceAsString();
}


function __autoload($className) {



    /*
    if (file_exists(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php')) {
        require_once(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php');
    } else if (file_exists(ROOT . DS . 'application' . DS . 'controller' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'controller' . DS . strtolower($className) . '.php');
    } else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php');
    } else {
    } */

    // todo: refactor to dynamically include subdirectories
    $file = ROOT.DS.'library'.DS.strtolower($className) . '.php';
    if(file_exists($file)) require_once($file);
    else {
        $file = ROOT.DS.'library'.DS.'view'.DS.strtolower($className) . '.php';
        if(file_exists($file)) require_once($file);
    }


    $len = strlen($className);
    //$pos = strrpos($className, 'Controller');
    if($len - strlen('Controller') > 0)
        $className = substr($className, 0, $len - strlen('Controller'));

    global $modules;

    foreach($modules as $key => $value) {
        $file = ROOT.DS.'application'.DS.$value.DS.'controller'.DS.strtolower($className) . '.php';
        if(file_exists($file))
            require_once($file);
    }


}

