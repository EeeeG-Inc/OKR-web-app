<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table): void {
            $table->increments('id');
            $table->text('name')->comment('ユーザ名');
            $table->integer('role')
                ->nullable()
                ->comment('権限');
            $table->integer('company_id')
                ->nullable()
                ->unsigned()
                ->comment('会社ID');
            $table->integer('department_id')
                ->nullable()
                ->unsigned()
                ->comment('部署ID');
            $table->string('email', 250)
                ->unique()
                ->comment('メールアドレス');
            $table->timestamp('email_verified_at')
                ->nullable()
                ->comment('メールアドレス確認日時');
            $table->string('password')->comment('パスワード');
            $table->softDeletes()->comment('削除フラグ');
            $table->timestamps();

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->cascadeOnUpdate();
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['department_id']);
        });
        Schema::dropIfExists('users');
    }
}
