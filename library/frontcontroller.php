<?php


class FrontController
{
    protected static $_urlParts = null;

    public static function getUrlQuery()
    {
        if(!is_null(self::$_urlParts))
            return self::$_urlParts;

        $url = "";
        if (isset($_GET['q']))
            $url = $_GET['q'];
        $url = rtrim($url, '/');
        self::$_urlParts = explode('/', $url);
        return self::$_urlParts;
    }

    function run()
    {
        Config::setEnvironmentSettings();
        $query = FrontController::getUrlQuery();
        $modules = Config::getModules();
        $route = Route::create($query, $modules);
        echo $route->doAction();
    }
}