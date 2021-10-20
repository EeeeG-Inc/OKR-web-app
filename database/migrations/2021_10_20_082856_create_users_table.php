<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->integer('role')->comment('権限');
            $table->bigInteger('companies_id')->nullable()->unsigned()->comment('会社コード');
            $table->bigInteger('departments_id')->nullable()->unsigned()->comment('部署コード');
            $table->string('email', 250)->unique()->comment('メールアドレス');
            $table->timestamp('email_verified_at')->nullable()->comment('メールアドレス確認日時');
            $table->text('password')->comment('パスワード');
            $table->boolean('delete_flag')->comment('削除フラグ');
            $table->timestamps();

            $table->foreign('companies_id')
            ->references('id')
            ->on('companies')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('departments_id')
            ->references('id')
            ->on('departments')
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
        Schema::dropIfExists('users');
    }
}
