<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeyResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('key_results', function (Blueprint $table) {
            $table->increments('id');
            $table->text('objective')->comment('成果指標');
            $table->float('score')
                ->nullable()
                ->default(0)
                ->comment('個別スコア');
            $table->integer('okr_id')
                ->unsigned()
                ->nullable()
                ->comment('okrID');
            $table->softDeletes()
                ->comment('削除フラグ');
            $table->timestamps();

            $table->foreign('okr_id')
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
        Schema::dropIfExists('key_results');
        Schema::table('key_results', function (Blueprint $table) {
            $table->dropForeign(['okr_id']);
        });
    }
}
