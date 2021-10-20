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
            $table->bigIncrements('id');
            $table->date('from')->comment('開始月');
            $table->date('to')->comment('終了月');
            $table->bigInteger('companies_id')->comment('会社コード')->unsigned();
            $table->boolean('delete_flag')->comment('削除フラグ');
            $table->timestamps();

            $table->foreign('companies_id')
            ->references('id')
            ->on('companies')
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
        Schema::dropIfExists('quarters');
    }
}
