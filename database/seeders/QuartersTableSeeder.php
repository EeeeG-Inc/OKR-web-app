<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'from'               =>  5,
                'to'                 =>  6,
                'company_id'         =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'from'               =>  7,
                'to'                 =>  9,
                'company_id'         =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'from'               =>  10,
                'to'                 =>  12,
                'company_id'         =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'from'               =>  1,
                'to'                 =>  3,
                'company_id'         =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'from'               =>  4,
                'to'                 =>  6,
                'company_id'         =>  2,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'from'               =>  7,
                'to'                 =>  9,
                'company_id'         =>  2,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'from'               =>  10,
                'to'                 =>  12,
                'company_id'         =>  2,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'from'               =>  1,
                'to'                 =>  3,
                'company_id'         =>  2,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ]
        ];

        foreach ($seeds as $seed) {
            DB::table('quarters')->insert($seed);
        }
    }
}
