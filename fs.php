<?php


class ControllerNotFoundException extends Exception { }
class ActionNotFoundException extends Exception { }


function setDefinitions()
{
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', dirname(__FILE__));
    define('BASE_NAME', basename(__FILE__));
}

function setBaseUrl()
{
    $pageURL = 'http';
    if (@$_SERVER["HTTPS"] == "on")
        $pageURL .= "s";
    $pageURL .= "://" . $_SERVER["SERVER_NAME"];

    if ($_SERVER["SERVER_PORT"] != "80")
        $pageURL .= ":" . $_SERVER["SERVER_PORT"];

    $pageURL .= str_replace(BASE_NAME, '', $_SERVER["PHP_SELF"]);
    define('BASE_URL', $pageURL);
}

try
{
    setDefinitions();
    setBaseUrl();
    require_once (ROOT . DS . 'config' . DS . 'config.php');
    require_once (ROOT . DS . 'application' . DS . 'bootstrap.php');

    $fc = new FrontController();
    $fc->run();
}

// todo: refector to a single routingexception that describes the problem
catch (ActionNotFoundException $ex) {
    $action = $ex->getMessage();
    header("HTTP/1.0 404 Not Found");
    echo "$action not found";
    die;
}

catch (ControllerNotFoundException $ex) {
    $controllerName = $ex->getMessage();
    header("HTTP/1.0 404 Not Found");
    echo "$controllerName not found";
    die;
}

catch (Exception $ex) {
    // todo: place the error control & view to its own handler(s)
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

