<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 各テーブルへのデータの流し込みを呼び出す
        $this->call([
            CompanyGroupsTableSeeder::class,
            CompaniesTableSeeder::class,
            QuartersTableSeeder::class,
            DepartmentsTableSeeder::class,
            UsersTableSeeder::class,
            ObjectivesTableSeeder::class,
            OkrsTableSeeder::class,
        ]);
    }
}
