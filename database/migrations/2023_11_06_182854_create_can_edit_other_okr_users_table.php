<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCanEditOtherOkrUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('can_edit_other_okr_users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->comment('ユーザ ID');
            $table->integer('target_user_id')->unsigned()->comment('ターゲットユーザ ID');
            $table->boolean('can_edit')->default(false)->comment('編集権限可否');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate();

            $table->foreign('target_user_id')
                ->references('id')
                ->on('users')
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
        Schema::table('can_edit_other_okr_users', function (Blueprint $table): void {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['target_user_id']);
        });
        Schema::dropIfExists('can_edit_other_okr_users');
    }
}
