<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_tokens', function (Blueprint $table) {
            $table->id();
            $table->integer('personal_access_token_id')->comment('パーソナルアクセストークンID');
            $table->integer('user_id')->unsigned()->comment('ユーザID');
            $table->integer('company_id')->unsigned()->unique()->comment('会社ID');
            $table->text('plain_text_token')->comment('API Token');
            $table->softDeletes()->comment('削除フラグ');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate();

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
        Schema::table('api_tokens', function (Blueprint $table): void {
            $table->dropForeign(['user_id', 'company_id']);
        });
        Schema::dropIfExists('api_tokens');
    }
}
