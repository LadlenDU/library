<?php
// cli-config.php
require_once "bootstrap.php";

#new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($entityManager, $mappingPaths);
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);