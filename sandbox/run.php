<?php
use Doctrine\ORM\EntityManager;

/** @var EntityManager $em */
include( __DIR__ . '/../src/Message.php' );
include( __DIR__ . '/../src/Product.php' );
$em = include( __DIR__ . '/../bootstrap.php' );

$message = new Message();
$message->setText( 'test me' );

$em->persist( $message );
var_dump(  $em->getUnitOfWork()->isScheduledForInsert( $message ) );

$message = $em->find( 'Message', 2 );
var_dump(  $em->getUnitOfWork()->isScheduledForInsert( $message ) );

//$em->flush();
