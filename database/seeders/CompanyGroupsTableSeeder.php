<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompanyGroupsTableSeeder extends Seeder
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
                'name'               =>  'EeeeGグループ',
                'delete_flag'        =>  'FALSE'
            ],
            [
                'name'               =>  '山田グループ',
                'delete_flag'        =>  'FALSE'
            ]
        ];

        foreach ($seeds as $seed) {
           DB::table('company_groups')->insert($seed);
        }
    }
}
