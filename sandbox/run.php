<?php
require_once( dirname( __DIR__ ) . '/vendor/autoload.php' );

$config = new \Doctrine\DBAL\Configuration();
//..
$connectionParams = array(
    'dbname' => 'test_doctrine',
    'user' => 'admin',
    'password' => 'admin',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
);
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

