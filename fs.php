<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
require_once (ROOT . DS . 'config' . DS . 'config.php');
require_once (ROOT . DS . 'application' . DS . 'bootstrap.php');


class ControllerNotFoundException extends Exception { }
class ActionNotFoundException extends Exception { }



try
{
    $fc = new FrontController();
    $fc->run();
}

catch (ActionNotFoundException $ex) {
    $action = $ex->getMessage();
    header("HTTP/1.0 404 Not Found");
    echo "$action not found";
    die;
}

catch (ControllerNotFoundException $ex) {
    //echo "todo: throw 404 error - ".$ex->getMessage();
    $controllerName = $ex->getMessage();
    header("HTTP/1.0 404 Not Found");
    echo "$controllerName not found";
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

    // todo: refactor to dynamically include subdirectories
    $file = ROOT.DS.'library'.DS.strtolower($className) . '.php';
    if(file_exists($file)) require_once($file);
    else {
        $file = ROOT.DS.'library'.DS.'view'.DS.strtolower($className) . '.php';
        if(file_exists($file)) require_once($file);
    }


    $len = strlen($className);
    if($len - strlen('Controller') > 0)
        $className = substr($className, 0, $len - strlen('Controller'));

    $modules = Config::getModules();

    foreach($modules as $key => $value) {
        $file = ROOT.DS.'application'.DS.$value.DS.'controller'.DS.strtolower($className) . '.php';
        if(file_exists($file))
            require_once($file);
    }


}

