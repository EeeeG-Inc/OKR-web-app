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
        \App\Models\CompanyGroup::factory(5)->create();
        \App\Models\Company::factory(10)->create();
        \App\Models\Quarter::factory(10)->create();
        \App\Models\Department::factory(10)->create();
        \App\Models\User::factory(10)->create();
        \App\Models\Okr::factory(10)->create();
        \App\Models\Objective::factory(10)->create();
    }
}
