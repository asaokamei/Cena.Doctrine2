<?php
namespace WScore\Cena\EmAdapter;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\UnitOfWork;
use WScore\Cena\EntityMap;

class EmaDoctrine2 implements EmAdapterInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    
    /**
     * @param EntityManager $em
     */
    public function setEntityManager( $em )
    {
        $this->em = $em;
    }
    
    /**
     * @param EntityMap $map
     * @return mixed
     */
    public function setEntityMap( $map )
    {
        // TODO: Implement setEntityMap() method.
    }

    /**
     * @return mixed
     */
    public function em()
    {
        return $this->em;
    }

    /**
     * fetch a entity from database or forge a new object.
     * should use getEntityByCenaId, instead.
     *
     * @param string $class
     * @param string $type
     * @param string $id
     * @return mixed
     */
    public function fetchEntity( $class, $type, $id )
    {
        if( $type == 'new' ) {
            return $this->newEntity( $class );
        } else {
            return $this->findEntity( $class, $id );
        }
    }

    /**
     * @param       $class
     * @param array $data
     * @return object
     */
    public function newEntity( $class, $data=array() )
    {
        $entity = new $class;
        $this->em->persist( $entity );
        if( $data ) {
            $this->loadData( $entity, $data );
        }
        return $entity;
    }

    /**
     * @param $class
     * @param $id
     * @return null|object
     */
    public function findEntity( $class, $id )
    {
        return $this->em->find( $class, $id );
    }

    /**
     * @param object $entity
     * @return mixed
     */
    public function getId( $entity )
    {
        // TODO: Implement getId() method.
    }

    /**
     * @param object $entity
     * @return mixed
     */
    public function getIdName( $entity )
    {
        // TODO: Implement getIdName() method.
    }

    /**
     * returns if the $entity object is marked as delete.
     *
     * @param object $entity
     * @return mixed
     */
    public function isDeleted( $entity )
    {
        $state = $this->em->getUnitOfWork()->getEntityState( $entity );
        if( $state == UnitOfWork::STATE_REMOVED ) {
            return true;
        } 
        return false;
    }

    /**
     * returns if the $entity object is retrieved from data base.
     *
     * @param $entity
     * @return mixed
     */
    public function isRetrieved( $entity )
    {
        $state = $this->em->getUnitOfWork()->getEntityState( $entity );
        if( $state == UnitOfWork::STATE_MANAGED ) {
            return true;
        }
        return false;
    }

    /**
     * returns if the $object is a collection of entities or not.
     *
     * @param object $object
     * @return mixed
     */
    public function isCollection( $object )
    {
        // TODO: Implement isCollection() method.
    }

    /**
     * populate an entity with array data.
     *
     * @param object $entity
     * @param array  $data
     * @return mixed
     */
    public function loadData( $entity, $data )
    {
        foreach( $data as $key => $val )
        {
            if( isset( $entity->$key ) ) {
                $entity->$key = $val;
            } elseif( method_exists( $entity, 'set'.ucwords($key) ) ) {
                $method = 'set'.ucwords($key);
                $entity->$method( $val );
            }
        }
    }

    /**
     * relate $entity with $target object by $name relation.
     *
     * @param object $entity
     * @param string $name
     * @param object $target
     * @return mixed
     */
    public function relate( $entity, $name, $target )
    {
        // TODO: Implement relate() method.
    }
}
