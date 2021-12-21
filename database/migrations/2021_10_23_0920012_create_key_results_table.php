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
            $table->text('key_result')->comment('成果指標');
            $table->double('score')
                ->nullable()
                ->default(0)
                ->comment('個別スコア');
            $table->integer('objective_id')
                ->unsigned()
                ->nullable()
                ->comment('目標 ID');
            $table->softDeletes()
                ->comment('削除フラグ');
            $table->timestamps();

            $table->foreign('objective_id')
                ->references('id')
                ->on('objectives')
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
            $table->dropForeign(['objective_id']);
        });
    }
}
