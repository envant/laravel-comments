<?php

namespace Envant\Comments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasComments
{
    /**
     * Return all comments for this model.
     *
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(config('comments.model'), 'model');
    }

    /**
     * Attach a comment to this model.
     *
     * @param string $body
     * @return Model
     */
    public function comment(string $body): Model
    {
        return $this->commentAsUser(auth()->user(), $body);
    }

    /**
     * Attach a comment to this model as a specific user.
     *
     * @param Model|null $user
     * @param string $body
     * @return Model
     */
    public function commentAsUser(?Model $user, string $body): Model
    {
        $comment = $this->comments()->create([
            'body' => $body,
            'user_id' => $user->getKey(),
        ]);

        return $comment;
    }
}
