<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OkrsTableSeeder extends Seeder
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
                'name'               =>  '歩く',
                'objectives_id'      =>  1,
                'score'              =>  0.9,
                'users_id'           =>  4,
                'year'               =>  2021,
                'quarters_id'         =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ]
        ];

        foreach ($seeds as $seed) {
            DB::table('okrs')->insert($seed);
        }
    }
}
