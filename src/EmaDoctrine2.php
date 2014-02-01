<?php
namespace Cena\Doctrine2;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\UnitOfWork;
use Cena\Cena\EmAdapterInterface;

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
     * @return EntityManager
     */
    public function em()
    {
        return $this->em;
    }

    /**
     * saves entities to database. 
     */
    public function save()
    {
        $this->em->flush();
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

    /**
     * @param object $entity
     * @return string|array
     */
    public function getId( $entity )
    {
        $meta = $this->em->getClassMetadata( $entity );
        $id = $meta->getIdentifierValues( $entity );
        return $id;
    }
}
