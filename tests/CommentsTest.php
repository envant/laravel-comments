<?php

namespace Envant\Comments\Tests;

use Envant\Comments\Comment;
use Illuminate\Support\Facades\Config;

class CommentsTest extends TestCase
{
    public function testComment()
    {
        $commentBody = 'random text';
        $comment = $this->testPost->comment($commentBody);

        $this->assertEquals($this->testPost->comments()->first()->id, $comment->id);
        $this->assertEquals($comment->is_approved, true);

        Comment::query()->delete();
    }

    public function testCommentNotApproved()
    {
        // turn moderation on
        Config::set('comments.moderation', true);

        $commentBody = 'random text';
        $comment = $this->testPost->comment($commentBody);

        // users should not see disapproved comments by default if moderation is enabled
        $this->assertNull($this->testPost->comments()->first());

        // turn moderation off
        Config::set('comments.moderation', false);
        $this->assertEquals($this->testPost->comments()->first()->id, $comment->id);

        $this->assertEquals($comment->is_approved, false);
    }
}
