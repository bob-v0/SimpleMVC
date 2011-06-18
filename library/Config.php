<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dutchpowercow
 * Date: 6/18/11
 * Time: 7:46 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Config {
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
}
