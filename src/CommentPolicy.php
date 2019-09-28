<?php

namespace Envant\Comments;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \Illuminate\Database\Eloquent\Model|null $user
     * @return mixed
     */
    public function viewAny(?Model $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \Illuminate\Database\Eloquent\Model|null $user
     * @param \Envant\Comments\Comment $comment
     * @return mixed
     */
    public function view(?Model $user, Comment $comment): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \Illuminate\Database\Eloquent\Model|null $user
     * @return mixed
     */
    public function create(?Model $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \Illuminate\Database\Eloquent\Model|null $user
     * @param \Envant\Comments\Comment $comment
     * @return mixed
     */
    public function update(?Model $user, Comment $comment): bool
    {
        return $comment->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \Illuminate\Database\Eloquent\Model|null $user
     * @param \Envant\Comments\Comment $comment
     * @return mixed
     */
    public function delete(?Model $user, Comment $comment)
    {
        return $comment->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \Illuminate\Database\Eloquent\Model|null $user
     * @param \Envant\Comments\Comment $comment
     * @return mixed
     */
    public function restore(?Model $user, Comment $comment)
    {
        return $comment->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \Illuminate\Database\Eloquent\Model|null $user
     * @param \Envant\Comments\Comment $comment
     * @return mixed
     */
    public function forceDelete(?Model $user, Comment $comment)
    {
        return $comment->user_id === $user->id;
    }
}
