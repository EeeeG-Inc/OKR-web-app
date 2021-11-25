<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObjectivesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeds = [
            [
                'name'             =>  '沢山歩いた',
                'score'              =>  0.9,
                'okr_id'             =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'name'             =>  '歩けなかった',
                'score'              =>  0.1,
                'okr_id'             =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'name'             =>  'ちょっと歩いた',
                'score'              =>  0.5,
                'okr_id'             =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'name'             =>  'ずっと歩いた',
                'score'              =>  0.2,
                'okr_id'             =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'name'             =>  'ずっと歩いた',
                'score'              =>  1.0,
                'okr_id'             =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ]
        ];

        foreach ($seeds as $seed) {
            DB::table('objectives')->insert($seed);
        }
    }
}
