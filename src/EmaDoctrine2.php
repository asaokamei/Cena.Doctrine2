<?php
namespace Cena\Doctrine2;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\UnitOfWork;
use Cena\Cena\EmAdapter\EmAdapterInterface;

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
     * clears the entity cache. 
     */
    public function clear()
    {
        $this->em->clear();
    }

    /**
     * @param string $class
     * @return object
     */
    public function newEntity( $class )
    {
        $entity = new $class;
        $this->em->persist( $entity );
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
     * @return mixed|void
     */
    public function deleteEntity( $entity )
    {
        $this->em->remove( $entity );
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
        return !$this->em->getUnitOfWork()->isScheduledForInsert( $entity );
    }

    /**
     * returns if the $object is a collection of entities or not.
     *
     * @param object $object
     * @return mixed
     */
    public function isCollection( $object )
    {
        if( is_array( $object ) ) return true;
        if( is_object( $object ) && $object instanceof \ArrayAccess ) return true;
        return false;
    }

    /**
     * @param object $entity
     * @return string|array
     */
    public function getId( $entity )
    {
        $meta = $this->em->getClassMetadata( get_class( $entity ) );
        $id = $meta->getIdentifierValues( $entity );
        return $id;
    }
}
