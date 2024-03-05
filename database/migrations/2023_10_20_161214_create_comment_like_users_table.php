<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentLikeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_like_users', function (Blueprint $table) {
            $table->id();
            $table->integer('comment_id')
                ->unsigned()
                ->comment('コメントID');
            $table->integer('user_id')
                ->unsigned()
                ->comment('ユーザID');
            $table->boolean('is_like')
                ->default(false)
                ->comment('いいね');
            $table->timestamps();

            $table->foreign('comment_id')
                ->references('id')
                ->on('comments');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->unique(['comment_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comment_like_users', function (Blueprint $table): void {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['comment_id']);
            $table->dropUnique(['comment_id','user_id']);
        });
        Schema::dropIfExists('comment_like_users');
    }

}
