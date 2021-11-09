<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
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
                'name'               =>  'EeeeG',
                'company_group_id'   =>  1,
                'is_master'          =>  1,
                'created_at'         => now(),
                'updated_at'         => now()
            ],
            [
                'name'               =>  '山田カンパニー',
                'company_group_id'   =>  2,
                'is_master'          =>  1,
                'created_at'         => now(),
                'updated_at'         => now()
            ],
            [
                'name'               =>  'かたかべカンパニー',
                'company_group_id'   =>  1,
                'is_master'          =>  0,
                'created_at'         => now(),
                'updated_at'         => now()
            ]
        ];

        foreach ($seeds as $seed) {
            DB::table('companies')->insert($seed);
        }
    }
}
