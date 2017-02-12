<?php

namespace app\helpers;

use app\core\Config;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

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
            /*$isDevMode = Config::inst()->database['debug'];
            $dbParams = Config::inst()->database['connection'];

            //$config = Setup::createConfiguration($isDevMode);
            $config = Setup::createAnnotationMetadataConfiguration(
                [Config::inst()->appDir . "/src/doctrine/entities"],
                $isDevMode
            );
            self::$entityManager = EntityManager::create($dbParams, $config);*/

            $paths = [Config::inst()->appDir . "/src/doctrine/entities"];
            $isDevMode = Config::inst()->database['debug'];
            $connectionParams = Config::inst()->database['connection'];

            $config = Setup::createConfiguration($isDevMode);
            $driver = new AnnotationDriver(new AnnotationReader(), $paths);

            // registering noop annotation autoloader - allow all annotations by default
            AnnotationRegistry::registerLoader('class_exists');
            $config->setMetadataDriverImpl($driver);

            self::$entityManager = EntityManager::create($connectionParams, $config);
        }
        return self::$entityManager;
    }

}
