<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\Role;

class UsersTableSeeder extends Seeder
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
                'name'              =>  'EeeeG',
                'companies_id'      =>  1,
                'departments_id'    =>  null,
                'role'              =>  Role::COMPANY,
                'email'              =>  'eeeeg@hoge.hoge',
                'password'          =>  'password',
                'created_at'        =>  now(),
                'updated_at'        =>  now()
            ],
            [
                'name'              =>  'システム事業部',
                'companies_id'      =>  1,
                'departments_id'    =>  1,
                'role'              =>  Role::DEPARTMENT,
                'email'              =>  'shisutemu@hoge.hoge',
                'password'          =>  'password',
                'created_at'        =>  now(),
                'updated_at'        =>  now()
            ],
            [
                'name'              =>  '総務部',
                'companies_id'      =>  1,
                'departments_id'    =>  2,
                'role'              =>  Role::DEPARTMENT,
                'email'              =>  'soumu@hoge.hoge',
                'password'          =>  'password',
                'created_at'        =>  now(),
                'updated_at'        =>  now()
            ],
            [
                'name'              =>  '片伯部',
                'companies_id'      =>  1,
                'departments_id'    =>  1,
                'role'              =>  Role::MEMBER,
                'email'              =>  'katakabe@hoge.hoge',
                'password'          =>  'password',
                'created_at'        =>  now(),
                'updated_at'        =>  now()
            ],
            [
                'name'              =>  '池田',
                'companies_id'      =>  1,
                'departments_id'    =>  1,
                'role'              =>  Role::MANAGER,
                'email'              =>  'ikeda@hoge.hoge',
                'password'          =>  'password',
                'created_at'        =>  now(),
                'updated_at'        =>  now()
            ],
            [
                'name'              =>  '小林',
                'companies_id'      =>  1,
                'departments_id'    =>  3,
                'role'              =>  Role::MEMBER,
                'email'              =>  'kobayashi@hoge.hoge',
                'password'          =>  'password',
                'created_at'        =>  now(),
                'updated_at'        =>  now()
            ],
            [
                'name'              =>  '山田',
                'companies_id'      =>  2,
                'departments_id'    =>  5,
                'role'              =>  Role::MANAGER,
                'email'              =>  'yamada@hoge.hoge',
                'password'          =>  'password',
                'created_at'        =>  now(),
                'updated_at'        =>  now()
            ]
        ];

        foreach ($seeds as $seed) {
            DB::table('users')->insert($seed);
        }
    }
}
