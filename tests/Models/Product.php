<?php
namespace Tests\Models;

/**
 * @Entity
 */
class Product
{
    /**
     * @var int
     * @id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string
     * @Column(length=140)
     */
    protected $name;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}

