<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuartersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quarters', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('quarter')->comment('四半期区分');
            $table->integer('from')->comment('開始月');
            $table->integer('to')->comment('終了月');
            $table->integer('company_id')
                ->nullable() // 通年だけ null とする
                ->comment('会社ID')
                ->unsigned();
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
     */
    public function down(): void
    {
        Schema::table('quarters', function (Blueprint $table): void {
            $table->dropForeign(['company_id']);
        });
        Schema::dropIfExists('quarters');
    }
}
