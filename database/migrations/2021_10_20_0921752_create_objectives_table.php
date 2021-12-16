<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objectives', function (Blueprint $table) {
            $table->increments('id');
            $table->text('objective')->comment('目標');
            $table->float('score')
                ->nullable()
                ->default(0)
                ->comment('総合スコア');
            $table->integer('user_id')
                ->unsigned()
                ->comment('ユーザID');
            $table->integer('year')->comment('年度');
            $table->integer('quarter_id')
                ->unsigned()
                ->comment('四半期ID');
            $table->softDeletes()->comment('削除フラグ');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate();
            $table->foreign('quarter_id')
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
        Schema::table('objectives', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['quarter_id']);
        });
        Schema::dropIfExists('objectives');
    }
}
