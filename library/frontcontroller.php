<?php


class FrontController
{
    function setBaseUrl()
    {
        $pageURL = 'http';
        if (@$_SERVER["HTTPS"] == "on")
            $pageURL .= "s";
        $pageURL .= "://" . $_SERVER["SERVER_NAME"];
        if ($_SERVER["SERVER_PORT"] != "80")
            $pageURL .= ":" . $_SERVER["SERVER_PORT"];
        $pageURL .= str_replace(basename(__FILE__), '', $_SERVER["PHP_SELF"]);
        define('BASE_URL', $pageURL);
    }

    function getUrlQuery()
    {
        $url = "";
        if (isset($_GET['q']))
            $url = $_GET['q'];
        $url = rtrim($url, '/');

        $q = explode('/', $url);
        return $q;
    }

    function run()
    {
        $this->setBaseUrl();
        Config::setEnvironmentSettings();
        $query = $this->getUrlQuery();
        $modules = Config::getModules();
        $route = Route::create($query, $modules);
        echo $route->doAction();
    }
}