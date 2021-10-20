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
        $this->call('CompaniesTableSeeder::class');
        $this->call('CompanyGroupsTableSeeder::class');
        $this->call('DepartmentsTableSeeder::class');
        $this->call('ObjectivesTableSeeder::class');
        $this->call('OkrsTableSeeder::class');
        $this->call('QuatersTableSeeder::class');
        $this->call('UsersTableSeeder::class');
    }
}
