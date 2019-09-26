<?php

namespace Envant\Comments\Tests\Models;

use Envant\Comments\HasComments;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasComments;
    protected $guarded = [];
}
