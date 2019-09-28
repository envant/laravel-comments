<?php

return [
    'table' => 'comments',
    'moderation' => false,
    'model' => Envant\Comments\Comment::class,
    'user_model' => null,
    'routes' => [
        'enabled' => true,
        'controller' => Envant\Comments\CommentController::class,
        'middleware' => 'auth:api',
        'prefix' => 'api',
        'policy' => [
            'enabled' => true,
            'class' => Envant\Comments\CommentPolicy::class,
        ]
    ],
];
