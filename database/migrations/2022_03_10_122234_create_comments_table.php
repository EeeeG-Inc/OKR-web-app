<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('comment')->nullable()->comment('コメント');
            $table->integer('objective_id')->unsigned()->comment('目標 ID');
            $table->integer('user_id')->unsigned()->comment('ユーザID');
            $table->softDeletes()->comment('削除フラグ');
            $table->timestamps();

            $table->foreign('objective_id')->references('id')->on('objectives')->cascadeOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table): void {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['objective_id']);
        });
        Schema::dropIfExists('comments');
    }
}
