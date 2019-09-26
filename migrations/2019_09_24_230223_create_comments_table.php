<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Envant\Comments\Comment;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $userClass = Comment::getAuthModelName();
        $usersTable = (new $userClass())->getTable();

        Schema::create(Comment::getModel()->getTable(), function (Blueprint $table) use ($usersTable) {
            $table->bigIncrements('id');
            $table->morphs('model');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on($usersTable)->onDelete('cascade');
            $table->text('body');
            $table->boolean('is_approved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(Comment::getModel()->getTable());
    }
}