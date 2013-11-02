<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once( __DIR__ . '/vendor/autoload.php' );

// Create a simple "default" Doctrine ORM configuration for Annotations
$paths = array(__DIR__ ."/src");
$isDevMode = false;

$dbParams = array(
    'dbname' => 'test_doctrine',
    'user' => 'admin',
    'password' => 'admin',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
return $entityManager = EntityManager::create($dbParams, $config);
