<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeyResultsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('key_results', function (Blueprint $table): void {
            $table->increments('id');
            // 成果指標 2 / 成果指標 3 は null になる可能性がある
            $table->text('key_result')
                ->nullable() // 第2・第3の成果指標は未設定・空文字更新したい場合がある
                ->comment('成果指標');
            $table->double('score')
                ->nullable()
                ->default(0)
                ->comment('成果指標スコア');
            $table->integer('objective_id')
                ->unsigned()
                ->nullable()
                ->comment('目標 ID');
            $table->text('remarks')
                ->nullable()
                ->comment('所感');
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
     */
    public function down(): void
    {
        Schema::dropIfExists('key_results');
        Schema::table('key_results', function (Blueprint $table): void {
            $table->dropForeign(['objective_id']);
        });
    }
}
