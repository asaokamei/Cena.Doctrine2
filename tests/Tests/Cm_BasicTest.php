<?php
namespace Tests\Tests;

use Cena\Cena\CenaManager;
use Cena\Cena\Factory;
use Cena\Doctrine2\EmaDoctrine2;
use Doctrine\ORM\EntityManager;
use Tests\Models\Comment;
use Tests\Models\Message;

/**
 * Class Cm_BasicTest
 *
 * An integration test for Cena/Cena.Doctrine2.
 * Uses MySQL databases for testing.
 *
 * @package Tests\Tests
 */
class Cm_BasicTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EmaDoctrine2
     */
    public $ema;

    /**
     * @var CenaManager
     */
    public $cm;

    static function setUpBeforeClass()
    {
        $em = include( __DIR__ . '/../autotest.php' );
        $tool = new \Doctrine\ORM\Tools\SchemaTool( $em );
        $classes = array(
            $em->getClassMetadata( 'Tests\Models\Message' ),
            $em->getClassMetadata( 'Tests\Models\Comment' ),
        );
        $tool->dropSchema( $classes );
        $tool->createSchema( $classes );
    }

    function setUp()
    {
        $em = include( __DIR__ . '/../autotest.php' );

        $this->ema = new EmaDoctrine2();
        $this->ema->setEntityManager( $em );

        $this->cm = Factory::cm( $this->ema );
        $this->cm->setClass( 'Tests\Models\Message' );
        $this->cm->setClass( 'Tests\Models\Comment' );
    }
    
    function test0()
    {
        $this->assertEquals( 'Cena\Cena\CenaManager', get_class( $this->cm ) );
    }

    /**
     * @test
     */
    function newEntity_returns_message_with_property_cenaId()
    {
        $message = $this->cm->newEntity( 'Message' );
        $cenaId  = $this->cm->cenaId( $message );
        
        $this->assertEquals( 'Tests\Models\Message', get_class( $message ) );
        $this->assertEquals( 'message.0.1', $cenaId );
    }

    /**
     * @test
     */
    function save_new_entities_to_db()
    {
        /** @var Message $message */
        $content = 'tests-'.md5(uniqid());
        $message = $this->cm->newEntity( 'Message' );
        $message->setMessage( $content );

        // save the entity.
        $this->assertEquals( null, $message->getId() );
        $this->cm->save();

        // also check if id is populated.
        $id = $message->getId();
        $this->assertNotEquals( null, $id );

        // get the message.
        /** @var Message $entity */
        $entity = $this->cm->getEntity( 'Message', $id );
        $this->assertSame( $message, $entity );

        // get really new message entity.
        /** @var EntityManager $em */
        $em = $this->cm->getEntityManager()->em();
        $em->clear();
        /** @var Message $entity2 */
        $entity2 = $em->find( 'Tests\Models\Message', $id );

        $this->assertNotSame( $message, $entity2 );
        $this->assertEquals( $message->getMessage(), $entity2->getMessage() );
    }

    /**
     * it turns out there's nothing much to test here.
     * it is testing basic Doctrine2's association.
     * @test
     */
    function relations()
    {
        /** @var Message $message */
        $contentM = 'message-'.md5(uniqid());
        $message = $this->cm->newEntity( 'Message' );
        $message->setMessage( $contentM );

        /** @var Comment $comment */
        $contentC = 'comment-'.md5(uniqid());
        $comment = $this->cm->newEntity( 'Comment' );
        $comment->setComment( $contentC );

        $comment->setMessage( $message );
        $this->cm->save();
    }

    /**
     * @test
     */
    function register_new_entity()
    {
        $message = new Message();
        $message->setMessage( 'new registry: ' . md5(uniqid()) );
        $cenaId  = $this->cm->register( $message );
        
        $retrieved = $this->cm->fetch( $cenaId );
        $this->assertSame( $message, $retrieved );
    }

    /**
     * @test
     */
    function register_entity_retrieved_from_db()
    {
        // save a message to db using EntityManager.
        $message = new Message();
        $content = 'register:'.md5(uniqid());
        $message->setMessage( $content );
        
        $em = $this->ema->em();
        $em->persist( $message );
        $em->flush();
        $em->clear();
        
        $msg_id   = $message->getId();
        $message2 = $em->find( 'Tests\Models\Message', $msg_id );
        
        $this->assertNotSame( $message, $message2 );
        $this->assertEquals( $message->getMessage(), $message2->getMessage() );
        
        // now test registering the message2 as cena object.
        $cenaId = $this->cm->register( $message2 );
        $this->assertEquals( 'message.1.'.$msg_id, $cenaId );
    }

    /**
     * @test
     */
    function getFieldList_returns_list_of_properties()
    {
        $entity = new Message();
        $list = $this->ema->getFieldList( $entity );
        $this->assertTrue( in_array( 'message_id', $list ) );
        $this->assertTrue( in_array( 'message', $list ) );
        $this->assertTrue( in_array( 'postedAt', $list ) );
    }

    /**
     * @test
     */
    function getRelationList_returns_list_of_relations()
    {
        $entity = new Message();
        $list = $this->ema->getRelationList( $entity );
        $this->assertTrue( in_array( 'comments', $list ) );
    }
}