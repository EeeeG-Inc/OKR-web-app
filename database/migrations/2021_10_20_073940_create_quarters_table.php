<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuartersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quarters', function (Blueprint $table) {
            $table
                ->bigIncrements('id');
            $table
                ->string('from', 2)
                ->comment('開始月');
            $table
                ->string('to', 2)
                ->comment('終了月');
            $table
                ->bigInteger('companies_id')
                ->comment('会社ID')
                ->unsigned();
            $table
                ->softDeletes()
                ->comment('削除フラグ');
            $table
                ->timestamps();

            $table
                ->foreign('companies_id')
                ->references('id')
                ->on('companies')
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
        Schema::table('quarters', function (Blueprint $table) {
            $table
                ->dropForeign(['companies_id']);
        });
        Schema::dropIfExists('quarters');
    }
}
