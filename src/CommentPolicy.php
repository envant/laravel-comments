<?php

namespace Envant\Comments;

use Envant\Comments\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param Model|null $user
     * @return mixed
     */
    public function viewAny(?Model $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param Model|null $user
     * @param Comment $comment
     * @return mixed
     */
    public function view(?Model $user, Comment $comment)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param Model|null $user
     * @return mixed
     */
    public function create(?Model $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param Model|null $user
     * @param Comment $comment
     * @return mixed
     */
    public function update(?Model $user, Comment $comment)
    {
        return $comment->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param Model|null $user
     * @param Comment $comment
     * @return mixed
     */
    public function delete(?Model $user, Comment $comment)
    {
        return $comment->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param Model|null $user
     * @param Comment $comment
     * @return mixed
     */
    public function restore(?Model $user, Comment $comment)
    {
        return $comment->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param Model|null $user
     * @param Comment $comment
     * @return mixed
     */
    public function forceDelete(?Model $user, Comment $comment)
    {
        return $comment->user_id === $user->id;
    }
}
