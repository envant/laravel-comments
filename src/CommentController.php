<?php

namespace Envant\Comments;

use Illuminate\Routing\Controller;
use Envant\Comments\Resources\CommentResource;
use Envant\Comments\Requests\CreateRequest;
use Envant\Comments\Requests\UpdateRequest;
use Envant\Helpers\ModelMapper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    use AuthorizesRequests;

    private $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * @param \Envant\Comments\Requests\CreateRequest $request
     * @return \Envant\Comments\Resources\CommentResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateRequest $request)
    {
        if (config('comments.routes.policy.enabled') === true) {
            $this->authorize('create', Comment::class);
        }

        /** @var \Envant\Comments\HasComments $model */
        $model = ModelMapper::getEntity($request->model_type, $request->model_id);
        $comment = $model->comment($request->body);

        return new CommentResource($comment);
    }

    /**
     * @param \Envant\Comments\Requests\UpdateRequest $request
     * @param \Envant\Comments\Comment $comment
     * @return \Envant\Comments\Resources\CommentResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateRequest $request, Comment $comment)
    {
        if (config('comments.routes.policy.enabled') === true) {
            $this->authorize('update', $comment);
        }

        $comment->update($request->validated());

        return new CommentResource($comment);
    }

    /**
     * @param \Envant\Comments\Comment $comment
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
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
