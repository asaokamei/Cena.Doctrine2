<?php
namespace Tests\Models;

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
    private $message_id;
    
    /**
     * @Column(length=140)
     */
    private $message;
    
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
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $text
     */
    public function setMessage( $text )
    {
        $this->message = $text;
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
        return $this->message_id;
    }

}