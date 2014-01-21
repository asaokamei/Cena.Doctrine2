<?php
namespace Tests\Models;

use Doctrine\Common\Collections\ArrayCollection;

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

    /**
     * @var
     * @OneToMany( targetEntity="Tests\Models\Comment", mappedBy="message" )
     * @JoinColumn( name="comment_id", referencedColumnName="comment_id" )
     */
    private $comments;

    // +----------------------------------------------------------------------+
    /**
     * 
     */
    public function __construct()
    {
        $this->postedAt = new \DateTime( 'now', new \DateTimeZone( 'Asia/Tokyo' ) );
        $this->comments = new ArrayCollection();
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