<?php

Route::prefix(config('comments.routes.prefix'))->middleware([config('comments.routes.middleware')])->group(function () {
    Route::resource('comments', config('comments.routes.controller'))->only(['store', 'update', 'destroy']);
});