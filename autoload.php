<?php

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = include( __DIR__ . '/vendor/autoload.php' );

$loader->addPsr4( 'Cena\\Doctrine2\\', __DIR__ .'/src' );
$loader->register();

