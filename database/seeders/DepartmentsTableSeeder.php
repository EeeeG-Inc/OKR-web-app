<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
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
                'name'               =>  'システム事業部',
                'companies_id'       =>  '1',
                'delete_flag'        =>  'FALSE'
            ],
            [
                'name'               =>  '総務部',
                'companies_id'       =>  '1',
                'delete_flag'        =>  'FALSE'
            ],
            [
                'name'               =>  '営業部',
                'companies_id'       =>  '1',
                'delete_flag'        =>  'FALSE'
            ],
            [
                'name'               =>  '営業部',
                'companies_id'       =>  '2',
                'delete_flag'        =>  'FALSE'
            ],
            [
                'name'               =>  'カスタマーサポート',
                'companies_id'       =>  '2',
                'delete_flag'        =>  'FALSE'
            ]
        ];

        foreach ($seeds as $seed) {
            DB::table('departments')->insert($seed);
        }
    }
}
