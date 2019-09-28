<?php

namespace Envant\Comments;

use Envant\Comments\Events\CommentCreated;
use Envant\Comments\Events\CommentUpdated;
use Envant\Comments\Events\CommentDeleted;
use Illuminate\Support\Facades\Event;

class CommentObserver
{
    /**
     * Handle the comment "created" event
     *
     * @param \Envant\Comments\Comment $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        Event::dispatch(new CommentCreated($comment));
    }

    /**
     * Handle the comment "updated" event
     *
     * @param \Envant\Comments\Comment $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
        Event::dispatch(new CommentUpdated($comment));
    }

    /**
     * Handle the comment "deleted" event
     *
     * @param \Envant\Comments\Comment $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        Event::dispatch(new CommentDeleted($comment));
    }
}
