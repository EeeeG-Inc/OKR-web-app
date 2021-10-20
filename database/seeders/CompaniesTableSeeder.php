<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
                'company_group_id'   =>  '1',
                'is_master'          =>  'TRUE',
                'delete_flag'        =>  'FALSE'
            ],
            [
                'name'               =>  '山田カンパニー',
                'company_group_id'   =>  '2',
                'is_master'          =>  'TRUE',
                'delete_flag'        =>  'FALSE'
            ],
            [
                'name'               =>  'かたかべカンパニー',
                'company_group_id'   =>  '1',
                'is_master'          =>  'FALSE',
                'delete_flag'        =>  'TRUE'
            ]
        ];

        foreach ($seeds as $seed) {
            DB::table('companies')->insert($seed);
        }
    }
}
