<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'companies_id'       =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'name'               =>  '総務部',
                'companies_id'       =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'name'               =>  '営業部',
                'companies_id'       =>  1,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'name'               =>  '営業部',
                'companies_id'       =>  2,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ],
            [
                'name'               =>  'カスタマーサポート',
                'companies_id'       =>  2,
                'created_at'         =>  now(),
                'updated_at'         =>  now()
            ]
        ];

        foreach ($seeds as $seed) {
            DB::table('departments')->insert($seed);
        }
    }
}
