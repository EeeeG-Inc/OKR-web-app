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
            $table->integer('id');
            $table->text('name')->comment('会社名');
            $table
                ->integer('company_group_id')
                ->comment('系列ID')
                ->unsigned();
            $table->boolean('is_master')->comment('マスターフラグ');
            $table->softDeletes()->comment('削除フラグ');
            $table->timestamps();

            $table
                ->foreign('company_group_id')
                ->references('id')
                ->on('company_groups')
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
        Schema::table('companies', function (Blueprint $table) {
            $table
                ->dropForeign(['company_group_id']);
        });
        Schema::dropIfExists('companies');
    }
}
