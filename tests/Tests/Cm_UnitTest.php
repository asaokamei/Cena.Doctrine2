<?php
namespace Tests\Tests;

use Cena\Doctrine2\EmaDoctrine2;
use Cena\Cena\Utils\ClassMap;
use Cena\Cena\Utils\Collection;
use Cena\Cena\Utils\Composition;
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

}
