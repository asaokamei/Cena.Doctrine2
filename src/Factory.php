<?php
namespace Cena\Doctrine2;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class Factory
{
    /**
     * @var Configuration
     */
    public static $config;

    /**
     * @var EntityManager
     */
    public static $em;

    /**
     * @var EmaDoctrine2
     */
    public static $ema;

    /**
     * @param EntityManager $em
     * @return EmaDoctrine2
     */
    public static function getEmaDoctrine2( $em=null )
    {
        if( !$em ) $em = self::$em;
        self::$ema = new EmaDoctrine2();
        self::$ema->setEntityManager( $em );
        return self::$ema;
    }

    /**
     * @param array $dbParams
     * @param string $paths
     * @param bool $isDevMode
     * @return EntityManager
     */
    public static function getEntityManager( $dbParams, $paths, $isDevMode=false )
    {
        $config = self::getConfig( $paths, $isDevMode );
        return self::$em = EntityManager::create($dbParams, $config);
    }

    /**
     * @param string $paths
     * @param bool   $isDevMode
     * @return Configuration
     */
    public static function getConfig( $paths, $isDevMode=false )
    {
        self::$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        return self::$config;
    }
}