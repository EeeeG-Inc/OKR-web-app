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
            $table->integer('yaer')->comment('年度');
            $table->bigInteger('quarters_id')->unsigned()->comment('四半期コード');
            $table->boolean('delete_flag')->comment('削除フラグ');
            $table->timestamps();

            $table->foreign('objectives_id')
            ->references('id')
            ->on('objectives')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('users_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('quarters_id')
            ->references('id')
            ->on('quarters')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('okrs');
    }
}
