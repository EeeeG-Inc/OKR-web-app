<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
                'score'              =>  '0.9',
                'delete_flag'        =>  'FALSE'
            ],
            [
                'result'             =>  '歩けなかった',
                'score'              =>  '0.1',
                'delete_flag'        =>  'FALSE'
            ],
            [
                'result'             =>  'ちょっと歩いた',
                'score'              =>  '0.5',
                'delete_flag'        =>  'FALSE'
            ],
            [
                'result'             =>  'ずっと歩いた',
                'score'              =>  '0.2',
                'delete_flag'        =>  'TRUE'
            ],
            [
                'result'             =>  'ずっと歩いた',
                'score'              =>  '1.0',
                'delete_flag'        =>  'FALSE'
            ]
        ];

        foreach ($seeds as $seed) {
            DB::table('objectives')->insert($seed);
        }
    }
}
