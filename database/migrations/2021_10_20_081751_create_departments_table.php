<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name')->comment('部署名');
            $table->bigInteger('companies_id')->unsigned()->comment('会社コード');
            $table->softDeletes()->comment('削除フラグ');
            $table->timestamps();

            $table
            ->foreign('companies_id')
            ->references('id')
            ->on('companies')
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
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['companies_id']);
        });
        Schema::dropIfExists('departments');
    }
}
