<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuartersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeds = [
            // 全ての会社共通の通年レコードを作成
            [
                'quarter' => 0,
                'from' => 1,
                'to' => 12,
                'company_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($seeds as $seed) {
            DB::table('quarters')->insert($seed);
        }
    }
}
