<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

// set up Composer's auto loader. 
require_once( dirname( __DIR__ ) . '/vendor/autoload.php' );

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = include( dirname( __DIR__ ) . '/vendor/autoload.php' );

$loader->addPsr4( 'Cena\\Doctrine2\\', dirname( __DIR__ ) .'/src' );
$loader->register();

// Create a simple "default" Doctrine ORM configuration for Annotations
$paths = array( dirname( __DIR__ ) ."/tests/Models");
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
