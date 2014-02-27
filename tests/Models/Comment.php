<?php
namespace Tests\Models;

/**
 * @Entity
 * @Table(name="test_comment")
 */
class Comment
{
    /**
     * @var int
     * @id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $comment_id;

    /**
     * @var string
     * @Column(length=140)
     */
    private $comment;

    /**
     * @Column(type="datetime", name="posted_at")
     */
    private $postedAt;

    /**
     * @var
     * @ManyToOne( targetEntity="Tests\Models\Message", inversedBy="comments" )
     * @JoinColumn( name="message_id", referencedColumnName="message_id" )
     */
    private $message;

    /**
     *
     */
    public function __construct()
    {
        $this->postedAt = new \DateTime( 'now', new \DateTimeZone( 'Asia/Tokyo' ) );
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->comment_id;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param Message $message
     */
    public function setMessage( Message $message )
    {
        $this->message = $message;
    }
}

