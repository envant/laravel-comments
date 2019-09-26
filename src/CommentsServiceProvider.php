<?php

namespace Envant\Comments;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CommentsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        $this->loadRoutes();

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        Gate::policy(Comment::class, config('comments.routes.policy.class'));
        Comment::observe(CommentObserver::class);
    }

    /**
     * Register routes
     *
     * @return void
     */
    public function loadRoutes()
    {
        if (config('comments.routes.enabled') === true) {
            $this->loadRoutesFrom(__DIR__ . '/routes.php');
            Route::model('comment', config('comments.model'));
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/comments.php', 'comments');
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/comments.php' => config_path('comments.php'),
        ], 'comments.config');

        $this->publishes([
            __DIR__ . '/../migrations/' => database_path('migrations')
        ], 'migrations');
    }
}
