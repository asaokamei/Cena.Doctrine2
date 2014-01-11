<?php
namespace WScore\Cena\EmAdapter;

use Doctrine\ORM\EntityManager;
use WScore\Cena\EntityMap;

class EmaDoctrine2 implements EmAdapterInterface
{
    /**
     * @var EntityManager
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
     * @param string $model
     * @param string $type
     * @param string $id
     * @return mixed
     */
    public function fetchEntity( $model, $type, $id )
    {
        // TODO: Implement fetchEntity() method.
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
     * get an entity from entity manager collection.
     *
     * @param string $cenaId
     * @return object
     */
    public function getEntityByCenaId( $cenaId )
    {
        // TODO: Implement getEntityByCenaId() method.
    }

    /**
     * get CenaID from an entity object.
     *
     * @param object $entity
     * @return string
     */
    public function getCenaIdByEntity( $entity )
    {
        // TODO: Implement getCenaIdByEntity() method.
    }

    /**
     * returns if the $entity object is marked as delete.
     *
     * @param object $entity
     * @return mixed
     */
    public function isDeleted( $entity )
    {
        // TODO: Implement isDeleted() method.
    }

    /**
     * returns if the $entity object is retrieved from data base.
     *
     * @param $entity
     * @return mixed
     */
    public function isRetrieved( $entity )
    {
        // TODO: Implement isRetrieved() method.
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
        // TODO: Implement loadData() method.
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
