<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
                'objectives_id'      =>  '1',
                'score'              =>  '0.9',
                'users_id'           =>  '4',
                'year'               =>  '2021',
                'quaters_id'         =>  '1',
                'delete_flag'        =>  'FALSE'
            ]
        ];

        foreach ($seeds as $seed) {
            DB::table('okrs')->insert($seed);
        }
    }
}
