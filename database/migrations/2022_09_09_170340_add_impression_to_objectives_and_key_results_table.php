<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImpressionToObjectivesAndKeyResultsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('objectives', function (Blueprint $table) {
            $table->text('remarks')->comment('備考')->change();
            $table->text('impression')
                ->nullable()
                ->comment('所感');
        });

        Schema::table('key_results', function (Blueprint $table) {
            $table->text('remarks')->comment('備考')->change();
            $table->text('impression')
                ->nullable()
                ->comment('所感');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('objectives', function (Blueprint $table): void {
            $table->text('remarks')->comment('所感')->change();
            $table->dropColumn('impression');
        });

        Schema::table('key_results', function (Blueprint $table): void {
            $table->text('remarks')->comment('所感')->change();
            $table->dropColumn('impression');
        });
    }
}
