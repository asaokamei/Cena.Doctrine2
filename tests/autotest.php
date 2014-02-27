<?php
use Cena\Doctrine2\Factory;

// set up Composer's auto loader. 
if( file_exists( dirname( __DIR__ ) . '/vendor/autoload.php' ) ) {
    require_once( dirname( __DIR__ ) . '/vendor/autoload.php' );
    $loader = include( dirname( __DIR__ ) . '/vendor/autoload.php' );
} elseif( file_exists( dirname( __DIR__ ) . '/../../../vendor/autoload.php' ) ) {
    require_once( dirname( __DIR__ ) . '/../../../vendor/autoload.php' );
    $loader = include( dirname( __DIR__ ) . '/../../../vendor/autoload.php' );
}

$loader->addPsr4( 'Cena\\Doctrine2\\', dirname( __DIR__ ) .'/src' );
$loader->addPsr4( 'Tests\\', __DIR__ );
$loader->register();

// Create a simple "default" Doctrine ORM configuration for Annotations
$paths = array( dirname( __DIR__ ) ."/tests/Models");

$dbParams = array(
    'dbname' => 'test_doctrine',
    'user' => 'admin',
    'password' => 'admin',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
);

return Factory::getEntityManager( $dbParams, $paths);
