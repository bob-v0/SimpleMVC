<?php


class FrontController
{

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
        Config::setEnvironmentSettings();
        $query = $this->getUrlQuery();
        $modules = Config::getModules();
        $route = Route::create($query, $modules);
        echo $route->doAction();
    }
}