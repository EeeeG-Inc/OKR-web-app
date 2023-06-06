<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjectiveScoreHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objective_score_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('objective_id')->unsigned()->comment('目標 ID');
            $table->double('score')->default(0)->comment('総合スコア');

            $table->foreign('objective_id')
                ->references('id')
                ->on('objectives')
                ->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('objective_score_histories', function (Blueprint $table): void {
            $table->dropForeign(['objective_id']);
        });
        Schema::dropIfExists('objective_score_histories');
    }
}
