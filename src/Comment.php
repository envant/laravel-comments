<?php

namespace Envant\Comments;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Route;

class Comment extends Model
{
    use HasComments;

    /** @var array */
    protected $fillable = [
        'body', 'user_id',
    ];

    /** @var array */
    protected $hidden = [
        'model_id',
        'model_type',
        'is_approved',
    ];

    /** @var array */
    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Show only approved comments if moderation is enabled
        static::addGlobalScope('is_approved', function (Builder $query) {
            if (config('comments.moderation')) {
                $query->where('is_approved', true);
            }
        });

        // Bypass global scopes for model-route binding
        Route::bind('comment', function ($id) {
            return static::withoutGlobalScopes()->findOrFail($id);
        });

        // Set approved status depending on config
        static::saving(function ($model) {
            $model->is_approved = !config('comments.moderation');
        });
    }

    /**
     * Override default model name
     *
     * @return string
     */
    public function getTable(): string
    {
        return config('comments.table');
    }

    /*
     |--------------------------------------------------------------------------
     | Relationships
     |--------------------------------------------------------------------------
     */

    /**
     * Commenter
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Contracts\Auth\Authenticatable
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(static::getAuthModelName(), 'user_id');
    }

    /**
     * Related model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /*
     |--------------------------------------------------------------------------
     | Scopes
     |--------------------------------------------------------------------------
     */

    /**
     * Get all comments
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAll(Builder $query): Builder
    {
        return $query->withoutGlobalScope('is_approved');
    }

    /**
     * Approved comments only
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('approved', true);
    }

    /**
     * Not approved comments only
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('approved', false);
    }

    /*
     |--------------------------------------------------------------------------
     | Methods
     |--------------------------------------------------------------------------
     */

    /**
     * Approve comment
     *
     * @return \Envant\Comments\Comment
     */
    public function approve(): Comment
    {
        $this->is_approved = true;
        $this->save();

        return $this;
    }

    /**
     * Disapprove comment
     *
     * @return \Envant\Comments\Comment
     */
    public function disapprove()
    {
        $this->is_approved = false;
        $this->save();

        return $this;
    }

    /*
     |--------------------------------------------------------------------------
     | Helpers
     |--------------------------------------------------------------------------
     */

    /**
     * Get auth model
     *
     * @return string
     * @throws Exception
     */
    public static function getAuthModelName(): string 
    {
        if (config('comments.user_model')) {
            return config('comments.user_model');
        }

        if (!is_null(config('auth.providers.users.model'))) {
            return config('auth.providers.users.model');
        }

        throw new Exception('Could not determine the commentator model name.');
    }
}
