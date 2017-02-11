<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
#$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode);
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/app/Entities"), $isDevMode);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parameters
/*$conn = array(
    'driver' => 'pdo_mysql',
    'path' => __DIR__ . '/db.sqlite',
);*/
$conn = array(
    'driver' => 'pdo_mysql',
    'user' => 'root',
    'password' => 'temp123',
    'dbname' => 'library',
    'driverOptions' => [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    ]
);

#$driver = new \Doctrine\ORM\Mapping\Driver\PHPDriver(__DIR__.'/src');
#Doctrine\Common\Persistence\Mapping\Driver\PHPDriver
#$driverF = new \Doctrine\Common\Persistence\Mapping\Driver\PHPDriver(__DIR__ . '/src');
#$config->setMetadataDriverImpl($driverF);
//$driverImpl = $config->newDefaultAnnotationDriver(__DIR__ . '/src');
#$driverImpl = $config->newDefaultAnnotationDriver(__DIR__ . '/vendor/doctrine/orm/lib');
#$driverImpl = $config->newDefaultAnnotationDriver(__DIR__ . '/vendor/doctrine/annotations/lib');
#$config->setMetadataDriverImpl($driverImpl);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
