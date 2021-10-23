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
            $table
                ->bigIncrements('id');
            $table
                ->text('result')
                ->comment('成果詳細');
            $table
                ->integer('score')
                ->nullable()
                ->comment('OKR個別スコア');
            $table
                ->bigInteger('okrs_id')
                ->unsigned()
                ->nullable()
                ->comment('okrID');
            $table
                ->softDeletes()
                ->comment('削除フラグ');
            $table
                ->timestamps();

            $table
                ->foreign('okrs_id')
                ->references('id')
                ->on('okrs')
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
        Schema::dropIfExists('objectives');
        Schema::table('objectives', function (Blueprint $table) {
            $table
                ->dropForeign(['okrs_id']);
        });
    }
}
