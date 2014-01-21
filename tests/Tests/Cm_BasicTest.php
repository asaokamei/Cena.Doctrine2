<?php
namespace Tests\Tests;

use Cena\Cena\CenaManager;
use Cena\Cena\Collection;
use Cena\Cena\Composition;
use Cena\Cena\EmAdapterInterface;
use Cena\Doctrine2\EmaDoctrine2;
use Doctrine\ORM\EntityManager;
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
     * @var EmAdapterInterface
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

        $this->cm = new CenaManager(
            new Composition(),
            new Collection()
        );
        $this->cm->setEntityManager( $this->ema );
        $this->cm->setClass( 'Tests\Models\Message' );
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
        $this->assertEquals( 'Message.0.1', $cenaId );
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
}