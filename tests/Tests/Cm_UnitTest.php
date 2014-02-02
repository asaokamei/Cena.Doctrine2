<?php
namespace Tests\Tests;

use Cena\Doctrine2\EmaDoctrine2;
use Cena\Cena\Utils\ClassMap;
use Cena\Cena\Utils\Collection;
use Cena\Cena\Utils\Composition;
use Cena\Cena\CenaManager;
use Tests\Models\Message;

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

        $this->cm = new CenaManager(
            new Composition(),
            new Collection(),
            new ClassMap()
        );
        $this->cm->setEntityManager( $this->ema );
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
    function makeBasicAccessor_generates_UcWords()
    {
        $origin = 'my_test';
        $access = $this->ema->makeBasicAccessor( $origin );
        $this->assertEquals( 'MyTest', $access );
    }

    /**
     * @test
     */
    function makeBasicAccessor_single_word()
    {
        $origin = 'test';
        $access = $this->ema->makeBasicAccessor( $origin );
        $this->assertEquals( 'Test', $access );
    }

    /**
     * @test
     */
    function makeBasicAccessor_two_underscore()
    {
        $origin = 'my__test';
        $access = $this->ema->makeBasicAccessor( $origin );
        $this->assertEquals( 'MyTest', $access );
    }

    /**
     * @test
     */
    function makeBasicAccessor_upper_case()
    {
        $origin = 'MY_test';
        $access = $this->ema->makeBasicAccessor( $origin );
        $this->assertEquals( 'MYTest', $access );
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

    /**
     * @test
     */
    function assign_sets_data_to_object()
    {
        $data = array(
            'test' => 'value' . md5(uniqid()),
            'more' => 'more ' . md5(uniqid()),
        );
        $entity = new \StdClass();
        $entity->test = null;
        $entity->more = null;
        $this->ema->assign( $entity, $data );
        $this->assertEquals( $data['test'], $entity->test );
        $this->assertEquals( $data['more'], $entity->more );
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    function assign_throws_exception()
    {
        $data = array(
            'test' => 'value' . md5(uniqid()),
        );
        $entity = new \StdClass();
        $this->ema->assign( $entity, $data );
    }

    /**
     * @test
     */
    function assign_to_setter_method()
    {
        $data = array(
            'test' => 'test setter',
        );
        $entity = $this->getmock( '\StdClass', array('setTest') );
        $entity->expects( $this->any() )
            ->method( 'setTest' )
            ->with(
                $this->equalTo( 'test setter' )
            );
        $this->ema->assign( $entity, $data );
    }

    /**
     * @test
     */
    function assign_to_ArrayAccess()
    {
        $data = array(
            'test' => 'test array',
        );
        $entity = $this->getmock( '\ArrayAccess', array('offsetSet','offsetExists','offsetGet','offsetUnset') );
        $entity->expects( $this->any() )
            ->method( 'offsetSet' )
            ->with(
                $this->equalTo( 'test' ),
                $this->equalTo( 'test array' )
            );
        $this->ema->assign( $entity, $data );
    }
}
