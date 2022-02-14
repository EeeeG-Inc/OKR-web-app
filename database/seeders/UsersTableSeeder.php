<?php

namespace Database\Seeders;

use App\Enums\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeds = [
            [
                'name'          => 'システム管理者',
                'company_id'    => null,
                'department_id' => null,
                'role'          => Role::ADMIN,
                'email'         => 'admin@example.com',
                'password'      => Hash::make('password'),
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ];

        foreach ($seeds as $seed) {
            DB::table('users')->insert($seed);
        }
    }
}
