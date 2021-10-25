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
                'from'               =>  '05',
                'to'                 =>  '06',
                'company_id'         =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'from'               =>  '07',
                'to'                 =>  '09',
                'company_id'         =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'from'               =>  '10',
                'to'                 =>  '12',
                'company_id'         =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'from'               =>  '01',
                'to'                 =>  '03',
                'company_id'         =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'from'               =>  '04',
                'to'                 =>  '06',
                'company_id'         =>  2,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'from'               =>  '07',
                'to'                 =>  '09',
                'company_id'         =>  2,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'from'               =>  '10',
                'to'                 =>  '12',
                'company_id'         =>  2,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'from'               =>  '01',
                'to'                 =>  '03',
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
