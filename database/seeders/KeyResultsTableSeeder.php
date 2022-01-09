<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeyResultsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeds = [
            [
                'key_result' => '沢山歩いた',
                'score' => 0.9,
                'objective_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key_result' => '歩けなかった',
                'score' => 0.1,
                'objective_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key_result' => 'ちょっと歩いた',
                'score' => 0.5,
                'objective_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key_result' => 'ずっと歩いた',
                'score' => 0.2,
                'objective_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key_result' => 'ずっと歩いた',
                'score' => 1.0,
                'objective_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($seeds as $seed) {
            DB::table('key_results')->insert($seed);
        }
    }
}
