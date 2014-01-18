<?php
namespace Tests\Tests;

use Cena\Cena\CenaManager;
use Cena\Cena\Collection;
use Cena\Cena\Composition;
use Cena\Cena\EmAdapterInterface;
use Cena\Doctrine2\EmaDoctrine2;

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
}