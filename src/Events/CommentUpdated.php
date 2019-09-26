<?php

namespace Envant\Comments\Events;

use Illuminate\Queue\SerializesModels;
use Envant\Comments\Comment;

class CommentUpdated
{
    use SerializesModels;
    public $comment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}
