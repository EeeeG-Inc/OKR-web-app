<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObjectivesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeds = [
            [
                'objective' => '歩く',
                'score' => 0.9,
                'user_id' => 4,
                'year' => 2021,
                'quarter_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($seeds as $seed) {
            DB::table('objectives')->insert($seed);
        }
    }
}
