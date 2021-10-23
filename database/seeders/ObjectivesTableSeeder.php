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
                'result'             =>  '沢山歩いた',
                'score'              =>  0.9,
                'okrs_id'            =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'result'             =>  '歩けなかった',
                'score'              =>  0.1,
                'okrs_id'            =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'result'             =>  'ちょっと歩いた',
                'score'              =>  0.5,
                'okrs_id'            =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'result'             =>  'ずっと歩いた',
                'score'              =>  0.2,
                'okrs_id'            =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'result'             =>  'ずっと歩いた',
                'score'              =>  1.0,
                'okrs_id'            =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ]
        ];

        foreach ($seeds as $seed) {
            DB::table('objectives')->insert($seed);
        }
    }
}
