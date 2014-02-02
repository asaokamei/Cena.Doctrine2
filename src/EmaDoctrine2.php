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
     * @param       $class
     * @param array $data
     * @return object
     */
    public function newEntity( $class, $data=array() )
    {
        $entity = new $class;
        $this->em->persist( $entity );
        if( $data ) {
            $this->assign( $entity, $data );
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
        if( is_array( $object ) ) return true;
        if( is_object( $object ) && $object instanceof \ArrayAccess ) return true;
        return false;
    }

    /**
     * populate an entity with array data.
     *
     * @param object $entity
     * @param array  $data
     * @throws \RuntimeException
     * @return mixed
     */
    public function assign( $entity, $data )
    {
        foreach( $data as $key => $val )
        {
            if( isset( $entity->$key ) ) {
                $entity->$key = $val;
                continue;
            }
            if( is_array( $entity ) || 
                ( is_object( $entity ) && $entity instanceof \ArrayAccess ) ) {
                $entity[ $key ] = $val;
                continue;
            }
            $method = 'set' . $this->makeBasicAccessor( $key );
            if( method_exists( $entity, $method ) ) {
                $entity->$method( $val );
                continue;
            }
            throw new \RuntimeException( "cannot set {$key} of an entity" );
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
        $meta = $this->em->getClassMetadata( get_class( $entity ) );
        if( !$this->isCollection( $target ) ) {
            $target = array( $target );
        }
        $method = 'set' . $this->makeBasicAccessor( $name );
        if( $meta->isCollectionValuedAssociation( $name ) ) {
            // $target should be a collection
            $entity->$method( $target );
            return;
        }
        $entity->$method( $target[0] );
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

    /**
     * @param $entity
     * @return array|mixed
     */
    public function getFieldList( $entity )
    {
        $meta = $this->em->getClassMetadata( get_class( $entity ) );
        $list = $meta->getFieldNames();
        return $list;
    }

    /**
     * @param object $entity
     * @return array
     */
    public function getRelationList( $entity )
    {
        $meta = $this->em->getClassMetadata( get_class( $entity ) );
        $list = $meta->getAssociationNames();
        return $list;
    }

    /**
     * @param $name
     * @return string
     */
    public function makeBasicAccessor( $name )
    {
        $name = ucwords( $name );
        if( strpos( $name, '_' ) !== false ) {
            $list = explode( '_', $name );
            array_walk( $list, function(&$a){$a=ucwords($a);} );
            $name = implode( '', $list );
        }
        return $name;
    }
}
