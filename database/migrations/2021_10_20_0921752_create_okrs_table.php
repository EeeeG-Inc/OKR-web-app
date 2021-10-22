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
            $table->bigIncrements('id');
            $table->text('name')->comment('登録名');
            $table->bigInteger('objectives_id')->unsigned()->comment('オブジェクトコード');
            $table->integer('score')->nullable()->comment('総合スコア');
            $table->bigInteger('users_id')->unsigned()->comment('ユーザコード');
            $table->integer('year')->comment('年度');
            $table->bigInteger('quarters_id')->unsigned()->comment('四半期コード');
            $table->softDeletes()->comment('削除フラグ');
            $table->timestamps();

            $table
            ->foreign('objectives_id')
            ->references('id')
            ->on('objectives')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();

            $table
            ->foreign('users_id')
            ->references('id')
            ->on('users')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();

            $table
            ->foreign('quarters_id')
            ->references('id')
            ->on('quarters')
            ->cascadeOnDelete()
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
            $table->dropForeign(['objectives_id']);
            $table->dropForeign(['users_id']);
            $table->dropForeign(['quarters_id']);
        });
        Schema::dropIfExists('okrs');
    }
}
