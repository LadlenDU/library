<?php

namespace app\helpers;

use app\core\Config;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * Db - работа с БД через общий объект.
 *
 * @package app\helpers
 */
class Db
{
    protected static $entityManager;

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
     * @return mixed Общий объект EntityManager в соответствии с настройками.
     */
    public static function em()
    {
        if (!self::$entityManager)
        {
            $isDevMode = Config::inst()->database['debug'];
            $dbParams = Config::inst()->database['connection'];

            $config = Setup::createConfiguration($isDevMode);
            self::$entityManager = EntityManager::create($dbParams, $config);
        }
        return self::$entityManager;
    }

}
