<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('objectives', function (Blueprint $table): void {
            $table->increments('id');
            $table->text('objective')->comment('目標');
            $table->double('score')
                ->nullable()
                ->default(0)
                ->comment('総合スコア');
            $table->integer('user_id')
                ->unsigned()
                ->comment('ユーザID');
            $table->integer('year')->comment('年度');
            $table->integer('quarter_id')
                ->unsigned()
                ->comment('四半期ID');
            $table->integer('priority')
                ->nullable()
                ->comment('優先度');
            $table->text('remarks')
                ->nullable()
                ->comment('備考');
            $table->softDeletes()->comment('削除フラグ');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate();
            $table->foreign('quarter_id')
                ->references('id')
                ->on('quarters')
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('objectives', function (Blueprint $table): void {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['quarter_id']);
        });
        Schema::dropIfExists('objectives');
    }
}
