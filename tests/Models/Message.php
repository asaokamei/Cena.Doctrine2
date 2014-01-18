<?php

/**
 * @Entity
 */
class Message
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @Column(length=140)
     */
    private $text;
    
    /**
     * @Column(type="datetime", name="posted_at")
     */
    private $postedAt;

    // +----------------------------------------------------------------------+
    /**
     * 
     */
    public function __construct()
    {
        $this->postedAt = new \DateTime( 'now', new \DateTimeZone( 'Asia/Tokyo' ) );
    }
    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText( $text )
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getPostedAt()
    {
        return $this->postedAt;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

}