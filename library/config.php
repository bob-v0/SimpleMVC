<?php

if(!BASE_URL) die();

class Config
{
    public static function setEnvironmentSettings()
    {
        if (DEV_ENV) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', ROOT . DS . 'logs' . DS . 'error.log');
        }
    }

    public static function getModules()
    {
        return array('default', 'module1');
    }
}
