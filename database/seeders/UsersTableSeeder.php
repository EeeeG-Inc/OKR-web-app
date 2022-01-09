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
                'name' => 'Admin',
                'company_id' => null,
                'department_id' => null,
                'role' => Role::ADMIN,
                'email' => 'admin@hoge.hoge',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'EeeeG',
                'company_id' => 1,
                'department_id' => null,
                'role' => Role::COMPANY,
                'email' => 'eeeeg@hoge.hoge',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'システム事業部',
                'company_id' => 1,
                'department_id' => 1,
                'role' => Role::DEPARTMENT,
                'email' => 'shisutemu@hoge.hoge',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '総務部',
                'company_id' => 1,
                'department_id' => 2,
                'role' => Role::DEPARTMENT,
                'email' => 'soumu@hoge.hoge',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '片伯部',
                'company_id' => 1,
                'department_id' => 1,
                'role' => Role::MEMBER,
                'email' => 'katakabe@hoge.hoge',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '池田',
                'company_id' => 1,
                'department_id' => 1,
                'role' => Role::MANAGER,
                'email' => 'ikeda@hoge.hoge',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '小林',
                'company_id' => 1,
                'department_id' => 3,
                'role' => Role::MEMBER,
                'email' => 'kobayashi@hoge.hoge',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '山田',
                'company_id' => 2,
                'department_id' => 5,
                'role' => Role::MANAGER,
                'email' => 'yamada@hoge.hoge',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($seeds as $seed) {
            DB::table('users')->insert($seed);
        }
    }
}
