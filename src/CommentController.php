<?php

namespace Envant\Comments;

use Illuminate\Routing\Controller;
use Envant\Comments\Resources\CommentResource;
use Envant\Comments\Comment;
use Envant\Comments\Requests\CreateRequest;
use Envant\Comments\Requests\UpdateRequest;
use Envant\Helpers\ModelMapper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
    }

    public function store(CreateRequest $request)
    {
        if (config('comments.routes.policy.enabled') === true) {
            $this->authorize('create', Comment::class);
        }

        $model = ModelMapper::getEntity($request->model_type, $request->model_id);
        $comment = $model->comment($request->body);

        return new CommentResource($comment);
    }

    public function update(UpdateRequest $request, Comment $comment)
    {
        if (config('comments.routes.policy.enabled') === true) {
            $this->authorize('update', $comment);
        }

        $comment->update($request->validated());

        return new CommentResource($comment);
    }

    public function destroy(Comment $comment)
    {
        if (config('comments.routes.policy.enabled') === true) {
            $this->authorize('delete', $comment);
        }

        $comment->delete();

        response()->json([
            'success' => true,
        ], Response::HTTP_NO_CONTENT);
    }
}
