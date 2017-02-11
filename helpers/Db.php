<?php

namespace helpers;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

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
        $paths = array("/path/to/entity-files");
        $isDevMode = false;

// the connection configuration
        $dbParams = array(
            'driver'   => 'pdo_mysql',
            'user'     => 'root',
            'password' => '',
            'dbname'   => 'foo',
        );

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $entityManager = EntityManager::create($dbParams, $config);

        /*if (!self::$bdClassInstance)
        {
            $className = \app\core\Config::inst()->database['class'];
            self::$bdClassInstance = new $className();
        }
        return self::$bdClassInstance;*/
    }

}
