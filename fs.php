<?php


class ControllerNotFoundException extends Exception { }
class ActionNotFoundException extends Exception { }


function setDefinitions()
{
    define('DS', DIRECTORY_SEPARATOR);
    define('APPPATH', dirname(__FILE__));
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
    spl_autoload_register('autoLoad');
    require_once (APPPATH . DS . 'config' . DS . 'config.php');
    require_once (APPPATH . DS . 'application' . DS . 'bootstrap.php');

    $fc = new FrontController();
    $fc->run();
}

// todo: refactor to a single routing exception that describes the problem
catch (ActionNotFoundException $ex) {
    $action = $ex->getMessage();
    header("HTTP/1.0 404 Not Found");
    if(DEV_ENV)
        echo "$action not found";
    else
        echo "Page not found";
    die;
}

catch (ControllerNotFoundException $ex) {
    $controllerName = $ex->getMessage();
    header("HTTP/1.0 404 Not Found");
    if(DEV_ENV)
        echo "$controllerName not found";
    else
        echo "Page not found";
    die;
}

catch (Exception $ex) {
    if(DEV_ENV) {
        // todo: place the error control & view to its own handler(s)
        echo "Fatal error: ".$ex->getMessage();
        echo "<hr />\n";
        echo "<pre>StackTrace: \n";
        echo $ex->getTraceAsString();
    }
    else {
        echo "An fatal error occurred. Our development team should be automatically notified. Our apology for any inconvenience.";
        // todo: fatal error handler thing so you can easly add functionality with custom requirements.
    }
}





function autoLoad($className)
{
    static $path = null;
    if($path == null)
        $path = APPPATH;

    // Load library classes
    autoLoader($className, APPPATH.DS."library");

    // Get some info so we can load the proper module.
    // These values are parsed now every time they are accessed. We can do better and need to take some lil time to fix this.
    $query = FrontController::getUrlQuery();
    $modules = Config::getModules();
    $route = Route::getRoutingParts($query, $modules);

    // load classes inside the correct module
    autoLoader($className, APPPATH.DS."application".DS.$route["module"]);
}

function autoLoader($className, $path)
{
    $handle = opendir($path);
    while (false !== ($file = readdir($handle))) {

        // ignore hidden directories, the current directory and the parent directory.
        if(strncmp($file, ".", 1) == 0)
            continue;

        if(!is_dir($path.DS.$file))
        {
            if(file_exists(strtolower($path.DS.$className).'.php'))
            {
                require_once(strtolower($path.DS.$className).'.php');
            }

            if(file_exists(strtolower($path.DS.preg_replace("/Controller$/","",$className)).'.php'))
            {
                require_once(strtolower($path.DS.preg_replace("/Controller$/","",$className)).'.php');
            }
            continue;
        }

        autoLoader($className, $path.DS.$file);
    }
    closedir($handle);
}

function __autoload2($className) {

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

