<?php
use Doctrine\ORM\EntityManager;

/** @var EntityManager $em */
include( __DIR__ . '/Message.php' );
include( __DIR__ . '/Product.php' );
$em = include( __DIR__ . '/../bootstrap.php' );

$d = new \Cena\Doctrine2\EmaDoctrine2();
$d->setEntityManager( $em );
$message = $d->newEntity( 'Message' );
$message->setText( 'test EmaDoctrine2' );

$em->persist( $message );
var_dump(  $em->getUnitOfWork()->isScheduledForInsert( $message ) );

$message = $d->findEntity( 'Message', 2 );
var_dump(  $em->getUnitOfWork()->isScheduledForInsert( $message ) );

$d->save();

