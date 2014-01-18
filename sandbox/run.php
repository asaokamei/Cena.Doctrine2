<?php
use Doctrine\ORM\EntityManager;

/** @var EntityManager $em */
include( __DIR__ . '/Message.php' );
include( __DIR__ . '/Product.php' );
$em = include( __DIR__ . '/../bootstrap.php' );

/*
 * create Ema for Doctrine2
 */

$d = new \Cena\Doctrine2\EmaDoctrine2();
$d->setEntityManager( $em );

$message = $d->newEntity( 'Message' );
$message->setText( 'test EmaDoctrine2' );

$em->persist( $message );
var_dump(  $em->getUnitOfWork()->isScheduledForInsert( $message ) );

$message = $d->findEntity( 'Message', 2 );
var_dump(  $em->getUnitOfWork()->isScheduledForInsert( $message ) );

/*
 * create CenaManager
 */
$cm = new \Cena\Cena\CenaManager( 
    new \Cena\Cena\Composition(), 
    new \Cena\Cena\Collection() 
);
$cm->setEntityManager( $d );

$message = $cm->newEntity( 'Message' );
$message->setText( 'test CenaManager' );
echo $cm->cenaId( $message );

$message = $cm->getEntity( 'message', 3 );
echo $cm->cenaId( $message );
var_dump(  $em->getUnitOfWork()->isScheduledForInsert( $message ) );

$d->save();

