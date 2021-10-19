<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name')->comment('ユーザー名');
            $table->text('role')->comment('権限');
            $table->text('company')->comment('会社');
            $table->text('department')->comment('部署');
            $table->string('email', 250)->unique()->comment('メールアドレス');
            $table->timestamp('email_verified_at')->nullable()->comment('メールアドレス確認日時');
            $table->rememberToken()->comment('継続ログイン設定');
            $table->text('password')->comment('パスワード');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
