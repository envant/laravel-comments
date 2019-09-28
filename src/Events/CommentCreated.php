<?php

namespace Envant\Comments\Events;

use Illuminate\Queue\SerializesModels;
use Envant\Comments\Comment;

class CommentCreated
{
    use SerializesModels;

    /** @var \Envant\Comments\Comment  */
    public $comment;

    /**
     * Create a new event instance.
     *
     * @param \Envant\Comments\Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}
