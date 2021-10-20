<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name')->comment('会社名');
            $table->bigInteger('company_group_id')->comment('系列コード')->unsigned();
            $table->boolean('is_master')->comment('マスターフラグ');
            $table->boolean('delete_flag')->comment('削除フラグ');
            $table->timestamps();

            $table->foreign('company_group_id')
            ->references('id')
            ->on('company_groups')
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
        Schema::dropIfExists('companies');
    }
}
