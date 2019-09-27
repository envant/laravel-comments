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
        $userModel = new $userClass();

        Schema::create(Comment::getModel()->getTable(), function (Blueprint $table) use ($userModel) {
            $table->bigIncrements('id');
            $table->morphs('model');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references($userModel->getKeyName())->on($userModel->getTable())->onDelete('cascade');
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