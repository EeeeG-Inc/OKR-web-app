<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class QuartersTableSeeder extends Seeder
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
                'from'               =>  '5',
                'to'                 =>  '6',
                'companies_id'       =>  '1',
                'delete_flag'        =>  'FALSE'
            ],
            [
                'from'               =>  '7',
                'to'                 =>  '9',
                'companies_id'       =>  '1',
                'delete_flag'        =>  'FALSE'
            ],
            [
                'from'               =>  '10',
                'to'                 =>  '12',
                'companies_id'       =>  '1',
                'delete_flag'        =>  'FALSE'
            ],
            [
                'from'               =>  '1',
                'to'                 =>  '3',
                'companies_id'       =>  '1',
                'delete_flag'        =>  'FALSE'
            ],
            [
                'from'               =>  '4',
                'to'                 =>  '6',
                'companies_id'       =>  '2',
                'delete_flag'        =>  'FALSE'
            ],
            [
                'from'               =>  '7',
                'to'                 =>  '9',
                'companies_id'       =>  '2',
                'delete_flag'        =>  'FALSE'
            ],
            [
                'from'               =>  '10',
                'to'                 =>  '12',
                'companies_id'       =>  '2',
                'delete_flag'        =>  'FALSE'
            ],
            [
                'from'               =>  '1',
                'to'                 =>  '3',
                'companies_id'       =>  '2',
                'delete_flag'        =>  'FALSE'
            ]
        ];

        foreach ($seeds as $seed) {
            DB::table('quarters')->insert($seed);
        }
    }
}
