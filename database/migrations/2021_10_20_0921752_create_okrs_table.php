<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOkrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('okrs', function (Blueprint $table) {
            $table
                ->bigIncrements('id');
            $table
                ->text('name')
                ->comment('OKR目標');
            $table
                ->integer('score')
                ->nullable()
                ->comment('OKR総合スコア');
            $table
                ->bigInteger('users_id')
                ->unsigned()
                ->comment('ユーザID');
            $table
                ->integer('year')
                ->comment('年度');
            $table
                ->bigInteger('quarters_id')
                ->unsigned()
                ->comment('四半期ID');
            $table
                ->softDeletes()
                ->comment('削除フラグ');
            $table
                ->timestamps();

            $table
                ->foreign('users_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate();
            $table
                ->foreign('quarters_id')
                ->references('id')
                ->on('quarters')
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('okrs', function (Blueprint $table) {
            $table
                ->dropForeign(['users_id']);
            $table
                ->dropForeign(['quarters_id']);
        });
        Schema::dropIfExists('okrs');
    }
}
