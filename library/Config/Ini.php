<?php

namespace Config;

class Ini extends \Zend_Config_Ini
{
    private static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self(__DIR__ . '/../App/Config/config.ini', 'production');
        }

        return self::$instance;
    }
}