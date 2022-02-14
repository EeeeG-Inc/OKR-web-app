<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slacks', function (Blueprint $table) {
            $table->id();
            $table->string('webhook')->unique()->comment('Webhook URL');
            $table->integer('company_id')->unsigned()->comment('会社ID');
            $table->boolean('is_active')->default(true)->comment('有効フラグ');
            $table->softDeletes()->comment('削除フラグ');
            $table->timestamps();

            $table->foreign('company_id')
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
        Schema::table('slacks', function (Blueprint $table): void {
            $table->dropForeign(['company_id']);
        });
        Schema::dropIfExists('slacks');
    }
}
