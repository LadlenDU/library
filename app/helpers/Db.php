<?php

namespace app\helpers;

/**
 * Db - работа с БД через общий объект.
 *
 * @package app\helpers
 */
class Db
{
    protected static $bdClassInstance;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    protected function __wakeup()
    {
    }

    /**
     * @return mixed Объект singleton в соответствии с настройками.
     */
    public static function obj()
    {
        if (!self::$bdClassInstance)
        {
            $className = \app\core\Config::inst()->database['class'];
            self::$bdClassInstance = new $className();
        }
        return self::$bdClassInstance;
    }

}
