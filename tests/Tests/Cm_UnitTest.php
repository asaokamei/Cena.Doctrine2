<?php
namespace Tests\Tests;

use Cena\Cena\Factory;
use Cena\Doctrine2\EmaDoctrine2;
use Cena\Cena\CenaManager;

/**
 * Class Cm_BasicTest
 *
 * An integration test for Cena/Cena.Doctrine2.
 * Uses MySQL databases for testing.
 *
 * @package Tests\Tests
 */
class Cm_UnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EmaDoctrine2
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

        $this->cm = Factory::getCenaManager( $this->ema );
        $this->cm->setClass( 'Tests\Models\Message' );
        $this->cm->setClass( 'Tests\Models\Comment' );
    }

    function test0()
    {
        $this->assertEquals( 'Cena\Doctrine2\EmaDoctrine2', get_class( $this->ema ) );
    }

    /**
     * @test
     */
    function isCollection_returns_true_for_array()
    {
        $array = array( 'test' );
        $this->assertTrue( $this->ema->isCollection( $array ) );
    }

    /**
     * @test
     */
    function isCollection_returns_true_for_ArrayAccess()
    {
        $array = $this->getMock( '\ArrayAccess' );
        $this->assertTrue( $this->ema->isCollection( $array ) );
    }

    /**
     * @test
     */
    function isCollection_returns_false_for_anything_else()
    {
        $object = new \StdClass;
        $this->assertFalse( $this->ema->isCollection( $object ) );
        $this->assertFalse( $this->ema->isCollection( 'hi' ) );
    }

}
